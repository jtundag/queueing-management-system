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
				'name' => $step->get('name'),
			]);

			$stepInstance->servers()->sync(collect($step->get('servers'))->pluck('id'));
		});
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