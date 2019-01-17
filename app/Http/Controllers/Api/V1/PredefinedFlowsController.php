<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PredefinedFlowsRepository;

class PredefinedFlowsController extends Controller
{
    private $predefinedFlowsRepo;

    public function __construct(PredefinedFlowsRepository $predefinedFlowsRepo){
        $this->predefinedFlowsRepo = $predefinedFlowsRepo;
    }
    
    public function get(Request $request){
        return response()
            ->json($this->predefinedFlowsRepo->forTable($request));
    }

    public function find(Request $request){
        $flow = $this->predefinedFlowsRepo
                    ->findWithRelatedModels($request->id);
                    
        return response()->json([
            'status' => $flow ? true : false,
            'flow' => $flow,
        ]);
    }
    
    public function create(Request $request){
        $created = $this->predefinedFlowsRepo
            ->create($request->all());

        return response()->json([
            'status' => $created ? true : false,
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->predefinedFlowsRepo
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function update($id, Request $request){
        $updated = $this->predefinedFlowsRepo
                        ->update($request, $id);

        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }
}
