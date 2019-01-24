<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;

class QueueController extends Controller
{
    private $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo){
        $this->transactionRepo = $transactionRepo;
    }
    
    public function push(Request $request){
        $user = auth('api')->user();
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
                            ->where('status', 'queueing')
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

        $currentlyServing = \App\Queue::where('server_id', $request->server_id)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->where('status', 'serving')
                            ->limit(1)
                            ->get()
                            ->first();
        
        if($currentlyServing){
            $currentlyServing->status = 'served';
            $currentlyServing->save();
            $nextStep = null;
            if($currentlyServing->transaction->flow()->exists()){
                $nextStep = $currentlyServing->transaction->flow->steps()->where('status', 'queueing')->first();
                if($nextStep){
                    $this->transactionRepo->createQueueFor($currentlyServing->transaction, [
                        'department_id' => $nextStep->department->id,
                        'service_id' => $nextStep->service->id,
                    ]);
                    $nextStep->pivot->status = 'processing';
                    $nextStep->pivot->save();
                }
            }
        }

        $queue = \App\Queue::whereIn('service_id', $serviceIds)
                            ->whereDate('created_at', \Carbon\Carbon::today())
                            ->where('status', 'queueing')
                            ->limit(1)
                            ->get()
                            ->first();

        $updated = false;
        if($queue){
            $queue->status = 'serving';
            $queue->server_id = $request->server_id;
            $updated = $queue->save();
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
    
}
