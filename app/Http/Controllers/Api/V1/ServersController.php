<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ServerRepository;

class ServersController extends Controller {
    private $serverRepo;

    public function __construct(ServerRepository $serverRepo){
        $this->serverRepo = $serverRepo;
    }
    
    public function get(Request $request){
        return response()
            ->json($this->serverRepo->forTable($request));
    }
    
    public function create(Request $request){
        $tableData = [
            'name' => $request->name,
            'department_id' => $request->department_id,
        ];
        
        $server = $this->serverRepo
            ->create($tableData);

        $services = [];

        foreach($request->services as $service){
            $services[$service['id']] = [
                'duration' => $service['pivot']['duration'],
            ];
        }
        
        $server->department->marker_location = $request->marker_location;
        $server->department->save();
        $server->services()->sync($services);
        $server->personnels()->sync(collect($request->personnels)->pluck('id'));

        return response()->json([
            'status' => $server ? true : false,
        ]);
    }
    
    public function delete(Request $request){
        $deleted = $this->serverRepo
            ->deleteById($request->id);

        return response()->json([
            'status' => $deleted ? true : false,
        ]);
    }

    public function update($id, Request $request){
        $server = $this->serverRepo
                        ->updateById([
                            'name' => $request->name, 
                            'department_id' => $request->department_id,
                            'marker_location' => $request->marker_location
                        ], $id);

        $services = [];

        foreach($request->services as $service){
            $services[$service['id']] = [
                'duration' => $service['pivot']['duration'],
            ];
        }
        
        $server->department->marker_location = $request->marker_location;
        $server->department->save();
        $server->services()->sync($services);
        $server->personnels()->sync(collect($request->personnels)->pluck('id'));

        return response()->json([
            'status' => $server ? true : false,
        ]);
    }

    public function find(Request $request){
        $server = $this->serverRepo
                    ->findById($request->id);

        $server['department'] = $server->department;
        $server['services'] = $server->services;
        $server['personnels'] = $server->personnels;
                    
        return response()->json([
            'status' => $server ? true : false,
            'server' => $server,
        ]);
    }

    public function reports($id, Request $request){
        $server = $this->serverRepo
                        ->findById($id);
        $monthlyReport = $server->queues()
                    ->select(\DB::raw('count(id) as total'), \DB::raw('date_format(created_at, "%m-%Y") as dates'))
                    ->where('queues.status', 'served')
                    ->groupBy('dates')
                    ->orderBy('dates')
                    ->get();
        
        $skippedQueues = [];
        foreach($monthlyReport as $report){
            array_push($skippedQueues, $server->skippedQueues()->where(\DB::raw('date_format(skipped_queues.created_at, "%m-%Y")'), $report->dates)->count());
        }

        return response()->json([
            'monthly_report' => $monthlyReport->pluck('total')->flatten(),
            'skipped_queues' => $skippedQueues,
        ]);
    }
    
}
