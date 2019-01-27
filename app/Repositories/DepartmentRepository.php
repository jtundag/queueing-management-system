<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class DepartmentRepository extends Repository implements TableContract{

	public function model(){
		return '\App\Department';
	}

	public function forTable(\Illuminate\Http\Request $request){
		$departments = $this->model->with('group');
		
		if($request->keyword){
			$departments = $departments->where('name', 'like', '%' . $request->keyword . '%');
		}
		
		return [
			'result' => $departments->get(),
		];
	}
}