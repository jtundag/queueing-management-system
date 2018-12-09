<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ServiceRepository;

class ServicesController extends Controller
{
    private $serviceRepo;

    public function __construct(ServiceRepository $serviceRepo){
        $this->serviceRepo = $serviceRepo;
    }
    
    public function get(Request $request){
        $services = $this->serviceRepo->all();
        
        return response()
            ->json([
                'result' => $services->toArray(),
            ]);
    }
    
    public function create(Request $request){
        $created = $this->serviceRepo
            ->create($request->all());

        return response()->json([
            'status' => $created ? true : false,
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->serviceRepo
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function update($id, Request $request){
        $updated = $this->serviceRepo
                        ->updateById(['name' => $request->new_name], $id);

        return response()->json([
            'status' => $updated ? true : false,
        ]);
    }
}
