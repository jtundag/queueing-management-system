<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Container\Container as App;
use App\Repositories\DepartmentRepository;
use App\Repositories\PredefinedFlowsRepository;

class TransactionRepository extends Repository{

	protected $departmentRepo;
	protected $flowRepo;

	public function __construct(App $app, 
								DepartmentRepository $departmentRepo,
								PredefinedFlowsRepository $flowRepo){
		parent::__construct($app);
		$this->departmentRepo = $departmentRepo;
		$this->flowRepo = $flowRepo;
    }
	
	public function model(){
		return '\App\Transaction';
	}

	public function push($request, $user){
		$transaction = $this->create([
			'flow_id' => $request->flow_id,
			'user_id' => $user->id,
			'status' => 'ongoing',
		]);
		if(!$request->has('flow_id')){
			$department = $this->departmentRepo
								->findById($request->department_id);
			if(!$transaction) return response()->json(['status' => false, 'message' => 'Cannot create transaction.']);
			$priorityNumber = $this->generateNumberFor($department);
			$attached = $this->saveEntriesFor($transaction, $department, $priorityNumber. 'ongoing');
			
			return response()->json(['status' => $attached ? true : false, 'priority_number' => $priorityNumber,]);
		}
		$flow = $this->flowRepo->findById($request->flow_id);
		$firstStepNumber = null;
		$flow->steps->map(function($step, $index) use ($transaction, &$firstStepNumber) {
			$priorityNumber = $index === 0 ? $this->generateNumberFor($step->department) : null;
			if($index === 0) $firstStepNumber = $priorityNumber;
			$this->saveEntriesFor($transaction, $step->department, $priorityNumber, $index === 0 ? 'ongoing' : 'pending');
		});

		return response()->json(['status' => true, 'priority_number' => $firstStepNumber]);
	}

	private function generateNumberFor($department){
		$countToday = $department->transactions()
									->whereDate('transactions.created_at', '=', \Carbon\Carbon::today())
									->count();
		return $department->prefix . str_pad(($countToday + 1), 4, '0', STR_PAD_LEFT);
	}
	
	private function saveEntriesFor($transaction, $department, $priorityNumber, $initialStatus = 'ongoing'){
		$entryData = [
			$department->id => [
				'priority_number' => $priorityNumber,
				'status' => $initialStatus,
				'created_at' => \Carbon\Carbon::now(),
			],
		];
			
		return $transaction->queueEntries()->attach($entryData);
	}

}