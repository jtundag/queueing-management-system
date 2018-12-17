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
        $created = $this->studentRepository
                        ->create($request->all());
        return response()->json([
            'status' => $created ? true : false
        ]);
    }
}
