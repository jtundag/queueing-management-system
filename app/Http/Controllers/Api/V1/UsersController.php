<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

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

    public function verify(Request $request){
        $user = $this->userRepository
                    ->unverifiedUser($request);

        if(!$user) return response()->json(['status' => false, 'message' => 'Cannot find an unverified account with an ID Number of ' . $request->uuid . ' and E-mail Address of ' . $request->email]);

        $newPassword = str_random();
        
        $updated = $this->userRepository
                        ->updateById([
                            'password' => \Hash::make($newPassword),
                            'verified_at' => \Carbon\Carbon::now(),
                        ], $user->id);

        return response()->json([
            'status' => $updated ? true : false,
            'password' => $newPassword,
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
    
}
