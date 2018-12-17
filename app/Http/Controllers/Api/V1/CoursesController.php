<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CourseRepository;

class CoursesController extends Controller
{
    private $courseRepo;

    public function __construct(CourseRepository $courseRepo){
        $this->courseRepo = $courseRepo;
    }
    
    public function get(Request $request){
        return response()
            ->json($this->courseRepo->forTable($request));
    }
    
    public function create(Request $request){
        $created = $this->courseRepo
            ->create($request->all());

        return response()->json([
            'status' => $created ? true : false,
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->courseRepo
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function update($id, Request $request){
        $updated = $this->courseRepo
                        ->updateById(['name' => $request->new_name], $id);

        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }
}
