<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class PredefinedFlowsRepository extends Repository implements TableContract{

	public function model(){
		return '\App\PredefinedFlow';
	}

	public function create($data = array()){
		$data = collect($data);
		$flow = $this->model->create([
			'name' => $data->get('name'),
		]);
		collect($data->get('steps'))->map(function($step) use ($flow) {
			$step = collect($step);
			$stepInstance = $flow->steps()->create([
				'department_id' => $step['department']['id'],
				'name' => $step->get('name'),
			]);

		});
		return $flow;
	}

	public function update($request, $id){
		$flow = $this->findById($id);
		$flow->name = $request->name;
		$flow->steps()->delete();
		collect($request->steps)->map(function($step) use ($flow) {
			$step = collect($step);
			$stepInstance = $flow->steps()->create([
				'department_id' => $step['department']['id'],
				'name' => $step->get('name'),
			]);

		});
		$flow->save();
		return $flow;
	}

	public function forTable(\Illuminate\Http\Request $request){
		return [
			'result' => $this->all()->map(function($predefinedFlow){
				$predefinedFlow['group'] = $predefinedFlow->group;
				return $predefinedFlow;
			}),
		];
	}
}