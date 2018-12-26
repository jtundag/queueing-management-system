<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\GroupRepository;

class GroupsController extends Controller
{
    private $groupRepo;

    public function __construct(GroupRepository $groupRepo){
        $this->groupRepo = $groupRepo;
    }
    
    public function get(Request $request){
        $groups = $this->groupRepo->all();
        
        return response()
            ->json([
                'result' => $groups->toArray(),
            ]);
    }
    
    public function create(Request $request){
        $created = $this->groupRepo
            ->create($request->all());

        return response()->json([
            'status' => $created ? true : false,
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->groupRepo
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function update($id, Request $request){
        $updated = $this->groupRepo
                        ->updateById(['name' => $request->new_name], $id);

        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }
}
