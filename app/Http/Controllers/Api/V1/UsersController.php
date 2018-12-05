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
        return response()->json([
            'result' => $this->studentRepository->all(),
        ]);
    }

    public function create(Request $request){
        dd($request->all());    
    }
}
