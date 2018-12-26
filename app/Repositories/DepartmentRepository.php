<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class DepartmentRepository extends Repository implements TableContract{

	public function model(){
		return '\App\Department';
	}

	public function forTable(\Illuminate\Http\Request $request){
		return [
			'result' => $this->all()->map(function($department){
				$department['group'] = $department->group;
				return $department;
			}),
		];
	}
}