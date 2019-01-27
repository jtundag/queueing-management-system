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
        $flow = $this->predefinedFlowsRepo
            ->create($request->all());

        $tagIds = [];
        collect($request->tags)->map(function($i) use (&$tagIds) {
            if(isset($i['id'])){
                array_push($tagIds, $i['id']);
                return false;
            }

            $tag = \App\Tag::create(['text' => $i['text']]);
            array_push($tagIds, $tag['id']);
        });
        $flow->tags()->sync($tagIds);

        return response()->json([
            'status' => $flow ? true : false,
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
        $flow = $this->predefinedFlowsRepo
                        ->update($request, $id);
        $tagIds = [];
        collect($request->tags)->map(function($i) use (&$tagIds) {
            if(isset($i['id'])){
                array_push($tagIds, $i['id']);
                return false;
            }

            $tag = \App\Tag::create(['text' => $i['text']]);
            array_push($tagIds, $tag['id']);
        });

        $flow->tags()->sync($tagIds);

        return response()->json([
            'status' => $flow ? true : false,
        ]);
    }
}
