<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\StudentRepository;

class UsersController extends Controller
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository){
        $this->studentRepository = $studentRepository;
    }
    
    public function get(Request $request){
        return response()->json($this->studentRepository->forTable($request));
    }

    public function create(Request $request){
        $user = $this->studentRepository
                        ->create($request->all());
                        
        \Bouncer::assign($request->role)->to($user);
        
        return response()->json([
            'status' => $user ? true : false
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->studentRepository
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function find(Request $request){
        $user = $this->studentRepository
                    ->findById($request->id);

        $user['department'] = $user->department;
                    
        return response()->json([
            'status' => $user ? true : false,
            'user' => $user,
        ]);
    }

    public function update(Request $request){
        if($request->has('password')) $request->password = \Hash::make($request->password);
        
        $updated = $this->studentRepository
                        ->updateById($request->except('id'), $request->id);
        
        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }
    
}
