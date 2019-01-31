<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use SMSGatewayMe\Client\ApiClient;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use SMSGatewayMe\Client\Model\SendMessageRequest;

class QueueController extends Controller
{
    private $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo){
        $this->transactionRepo = $transactionRepo;
    }
    
    public function push(Request $request){
        $user = $request->has('uuid') ? \App\User::where('uuid', $request->uuid)->first() : auth('api')->user();
        if(!$user) return response()->json(['status' => false, 'message' => 'Cannot find user.']);
        return $this->transactionRepo->push($request, $user);
    }
    
    public function retrieveWaitingTime($id){
        return response()->json([
            'waiting_time' => $this->transactionRepo->generateWaitingTimeFor($this->transactionRepo->findQueueById($id)),
        ]);
    }

    public function getQueues(Request $request){
        $user = auth('api')->user();

        $serviceIds = $user->myServersServices->pluck('services')->flatten()->unique('id')->pluck('id');
        $queues = \App\Queue::whereIn('service_id', $serviceIds)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->whereIn('status', ['queueing', 'skipped'])
                            ->orderBy('status')
                            ->get();

        $currentlyServing = \App\Queue::where('server_id', $request->server_id)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->where('status', 'serving')
                            ->limit(1)
                            ->get()
                            ->first();
        
        return response()->json([
            'result' => $queues,
            'currently_serving' => $currentlyServing,
        ]);
    }
    
    public function serveNext(Request $request){
        $user = auth('api')->user();

        $serviceIds = $user->myServersServices->pluck('services')->flatten()->unique('id')->pluck('id');
        $server = \App\Server::find($request->server_id);
        $currentlyServing = \App\Queue::where('server_id', $server->id)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->where('status', 'serving')
                            ->limit(1)
                            ->get()
                            ->first();
        
        if($currentlyServing){
            if($request->action == 'skip') {
                $server->skippedQueues()->attach($currentlyServing);
            }
            $currentlyServing->status = $request->action == 'skip' ? 'skipped' : 'served';
            $currentlyServing->updated_at = \Carbon\Carbon::now();
            $currentlyServing->save();
            $nextStep = null;
            if($currentlyServing->transaction->flow()->exists() && $request->action != 'skip'){
                $nextStep = $currentlyServing->transaction->flow->steps()->where('status', 'queueing')->first();
                if($nextStep){
                    $this->transactionRepo->createQueueFor($currentlyServing->transaction, [
                        'department_id' => $nextStep->department->id,
                        'service_id' => $nextStep->service->id,
                    ]);
                    $nextStep->pivot->status = 'processing';
                    $nextStep->pivot->save();
                }else {
                    $currentlyServing->transaction->status = 'completed';
                    $currentlyServing->transaction->save();

                    $currentlyServing->transaction->flow->status = 'completed';
                    $currentlyServing->transaction->flow->save();
                }
            }
        }

        $queue = \App\Queue::whereIn('service_id', $serviceIds)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->whereIn('status', ['queueing', 'skipped'])
                            ->orderBy('updated_at')
                            ->limit(1)
                            ->get()
                            ->first();

        $updated = false;
        if($queue){
            $queue->status = 'serving';
            $queue->server_id = $request->server_id;
            $updated = $queue->save();
            
            if(!$queue->transaction->user->mobile_no) return response()->json([
            'status' => $queue ? $updated : true,
            'currently_serving' => $queue,
        ]);

            $deviceID = env('SMSGATEWAYME_DEVICE_ID', '');
            $number = $queue->transaction->user->mobile_no;
            $message = 'ITS YOUR TURN! Please present your priority number (' . $queue->priority_number . ') to ' . $server->name;
            
            $config = Configuration::getDefaultConfiguration();
            $config->setApiKey('Authorization', env('SMSGATEWAYME_API', ''));
            $apiClient = new ApiClient($config);
            $messageClient = new MessageApi($apiClient);

            $sendMessageRequest = new SendMessageRequest([
                'phoneNumber' => $number,
                'message' => $message,
                'deviceId' => $deviceID,
            ]);

            $sendMessages = $messageClient->sendMessages([
                $sendMessageRequest,
            ]);

            if($queue->transaction->user->player_id) \OneSignal::sendNotificationToUser(
                $message,
                $queue->transaction->user->player_id
            );
        }

        return response()->json([
            'status' => $queue ? $updated : true,
            'currently_serving' => $queue,
        ]);
    }
    
    public function serviceQueues(Request $request){
        $department = \App\Department::find($request->department_id);
        $queues = $department->servers()
                            ->with([
                                'queues' => function($q){
                                    $q->whereDate('queues.created_at', \Carbon\Carbon::now())
                                    ->where('queues.status', 'serving')
                                    ->limit(1)
                                    ->first();
                                }
                            ])
                            ->get();
        return response()->json([
            'result' => $queues,
        ]);
    }
    
    public function find(Request $request){
        $transaction = $this->transactionRepo->findById($request->id);
        return response()->json($transaction->queues()->with('service', 'service.servers')->get());
    }
    
}
