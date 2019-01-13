<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\DepartmentRepository;

class DepartmentsController extends Controller
{
    private $departmentRepo;

    public function __construct(DepartmentRepository $departmentRepo){
        $this->departmentRepo = $departmentRepo;
    }
    
    public function get(Request $request){
        return response()
            ->json($this->departmentRepo->forTable($request));
    }
    
    public function create(Request $request){
        $created = $this->departmentRepo
            ->create($request->all());

        return response()->json([
            'status' => $created ? true : false,
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->departmentRepo
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function update($id, Request $request){
        $updated = $this->departmentRepo
                        ->updateById(['name' => $request->name, 'group_id' => $request->group_id, 'prefix' => $request->prefix], $id);

        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }
}
