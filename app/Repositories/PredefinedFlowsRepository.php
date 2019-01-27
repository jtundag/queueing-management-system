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
			$stepInstance = $flow->steps()->create([
				'service_id' => $step['service']['id'],
				'department_id' => $step['department']['id'],
				'name' => $step['name'],
			]);
		});
		return $flow;
	}

	public function findWithRelatedModels($id){
		return $this->model->with(['steps','steps.department', 'steps.service', 'tags'])->where('id', $id)->first();
	}

	public function update($request, $id){
		$flow = $this->findById($id);
		$flow->name = $request->name;
		$flow->steps()->delete();
		collect($request->steps)->map(function($step) use ($flow) {
			$stepInstance = $flow->steps()->create([
				'service_id' => $step['service']['id'],
				'department_id' => $step['department']['id'],
				'name' => $step['name'],
			]);
		});
		$flow->save();
		return $flow;
	}

	public function forTable(\Illuminate\Http\Request $request){
		$result = $this->model;
		
		if($request->has('tags')){
			$result = $result->whereHas('tags', function($q) use ($request) {
				$q->whereIn('tags.text', explode(',', $request->tags));
			});
		}

		return [
			'result' => $result->get(),
		];
	}
}