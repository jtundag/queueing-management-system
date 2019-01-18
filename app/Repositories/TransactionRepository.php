<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Container\Container as App;
use App\Repositories\DepartmentRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\PredefinedFlowsRepository;

class TransactionRepository extends Repository{

	protected $departmentRepo;
	protected $serviceRepo;
	protected $flowRepo;

	public function __construct(App $app, 
								DepartmentRepository $departmentRepo,
								ServiceRepository $serviceRepo,
								PredefinedFlowsRepository $flowRepo){
		parent::__construct($app);
		$this->departmentRepo = $departmentRepo;
		$this->serviceRepo = $serviceRepo;
		$this->flowRepo = $flowRepo;
    }
	
	public function model(){
		return '\App\Transaction';
	}

	public function push($request, $user){
		$transaction = $this->create([
			'flow_id' => $request->flow_id,
			'user_id' => $user->id,
			'status' => 'processing',
		]);
		// If the transaction is custom
		if(!$request->has('flow_id')){
			$avgDuration = \App\Service::select('services.id', 'services.name')
			->join('server_service', 'services.id', '=', 'server_service.service_id')
			->join('servers', 'server_service.server_id', '=', 'servers.id')
			->where('servers.department_id', $request->department_id)
			->whereIn('services.id', [$request->service_id])
			->avg('server_service.duration');

			$service = $this->serviceRepo
							->findById($request->service_id);
			
			$department = $this->departmentRepo
								->findById($request->department_id);
			if(!$transaction) return response()->json(['status' => false, 'message' => 'Cannot create transaction.']);
			$priorityNumber = $this->generateNumberFor($department, $service);
			$attached = $this->saveQueues($transaction, $service, $priorityNumber);
			
			return response()->json(['status' => $attached ? true : false, 'priority_number' => $priorityNumber, 'waiting_time' => $service->queues()->where('service_transaction.status', 'queueing')->count() * $avgDuration,]);
		}
		$flow = $this->flowRepo->findById($request->flow_id);
		$firstStepNumber = null;
		$flow->steps->map(function($step, $index) use ($transaction, &$firstStepNumber) {
			$priorityNumber = $index === 0 ? $this->generateNumberFor($step->department, $service) : null;
			if($index === 0) $firstStepNumber = $priorityNumber;
			$step->services->map(function($step) use ($transaction, $priorityNumber, $index) {

			});
			$this->saveQueues($transaction, $step->department, $priorityNumber, $index === 0 ? 'processing' : 'queueing');
		});

		return response()->json(['status' => true, 'priority_number' => $firstStepNumber]);
	}

	private function generateNumberFor($department, $service){
		$countToday = $service->queues()
							->whereDate('transactions.created_at', '=', \Carbon\Carbon::today())
							->count();
		return $department->prefix . str_pad(($countToday + 1), 4, '0', STR_PAD_LEFT);
	}
	
	private function saveQueues($transaction, $service, $priorityNumber, $initialStatus = 'queueing'){
		$entryData = [
			$service->id => [
				'priority_number' => $priorityNumber,
				'status' => $initialStatus,
				'created_at' => \Carbon\Carbon::now(),
			],
		];
			
		return $transaction->queues()->attach($entryData);
	}

}