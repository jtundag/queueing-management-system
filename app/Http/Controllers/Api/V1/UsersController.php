<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use League\Csv\Reader;

class UsersController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }
    
    public function get(Request $request){
        return response()->json($this->userRepository->forTable($request));
    }

    public function create(Request $request){
        $request->merge(['password' => \Hash::make($request->password)]);
        $user = $this->userRepository
                        ->create($request->all());
                        
        \Bouncer::assign($request->role)->to($user);
        
        return response()->json([
            'status' => $user ? true : false
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->userRepository
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function find(Request $request){
        $user = $this->userRepository
                    ->findById($request->id);
        $user['department'] = $user->department;
                    
        return response()->json([
            'status' => $user ? true : false,
            'user' => $user,
        ]);
    }

    public function update(Request $request){
        if($request->has('password')) $request->merge(['password' => \Hash::make($request->password)]);
        
        $updated = $this->userRepository
                        ->updateById($request->except('id'), $request->id);
        
        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }

    public function requestVerification(Request $request){
        $authyApi = new \Authy\AuthyApi(env('TWILIO_AUTHY_API'));

        $user = $this->userRepository
                    ->where('uuid', '=', $request->uuid)
                    ->where('email', '=', $request->email)
                    ->first();
        
        $sent = $authyApi->phoneVerificationStart($user->mobile_no, '+63', 'sms');

        return response()->json([
            'status' => $sent->ok(),
            'message' => $sent->ok() ? 'Success!' : $sent->errors()->message,
        ]);
    }
    
    public function verify(Request $request){
        $user = $this->userRepository
                    ->unverifiedUser($request);

        if(!$user) return response()->json(['status' => false, 'message' => 'Cannot find an unverified account with an ID Number of ' . $request->uuid .  '.']);
        $authyApi = new \Authy\AuthyApi(env('TWILIO_AUTHY_API'));


        $verification = $authyApi->phoneVerificationCheck($user->mobile_no, '+63', $request->code);

        if(!$verification->ok()) return response()->json([
            'status' => false,
            'message' => $verification->errors()->message,
        ]);

        $requestBody = [
            'app_id' => env('ONE_SIGNAL_APP_ID', ''),
            'device_type' => $request->device_type,
            'device_model' => $request->device_model,
            'device_os' => $request->device_os,
            'notification_types' => 1,
            'test_type' => $request->test_type,
            'game_version' => $request->game_version,
        ];

        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players"); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_HEADER, FALSE); 
        curl_setopt($ch, CURLOPT_POST, TRUE); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody)); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 

        $response = curl_exec($ch); 
        curl_close($ch); 
        $response = json_decode($response, true);
        
        $updated = false;
        
        if($response['success']){
            $updated = $this->userRepository
                        ->updateById([
                            'verified_at' => \Carbon\Carbon::now(),
                            'player_id' => $response['id'],
                        ], $user->id);
        }

        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }

    public function changePassword(Request $request){
        $user = $this->userRepository
                    ->where('uuid', '=', $request->uuid)
                    ->first();
        $user->password = \Hash::make($request->password);
        $updated = $user->save();

        return response()->json([
            'status' => $updated,
        ]);
    }

    public function queues($id, Request $request){
        $user = \Auth::Guard('api')->user();
        $queues = $user->queues();

        if($request->date){
            $queues = $queues->whereDate('queues.created_at', \Carbon\Carbon::parse($request->date)->toDateString());
        }

        return response()->json([
            'result' => $queues->get(),
        ]);
    }

    public function offices($id, Request $request){
        
    }

    public function importCSV(Request $request){
        $csv = Reader::createFromPath($request->file('file')->getPathName(), 'r');
        $csv->setHeaderOffset(0);

        $header = $csv->getHeader();
        $records = $csv->getRecords();
        $records->rewind();
        foreach($records as $key => $value){
            $value['password'] = \Hash::make($value['password']);

            $user = $this->userRepository
                            ->create($value);

            \Bouncer::assign($request->role)->to($user);
        }
        return response()->json([
            'status' => true,
            'message' => 'Success!',
        ]);
    }
    
}
