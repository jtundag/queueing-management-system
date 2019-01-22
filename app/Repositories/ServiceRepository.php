<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class ServiceRepository extends Repository implements TableContract{
	public function model(){
		return '\App\Service';
	}
	
	public function forTable(\Illuminate\Http\Request $request){
		$services = $this->model;
		
		if($request->keyword){
			$services = $services->where('name', 'like', '%' . $request->keyword . '%');
		}
		
		return [
			'result' => $services->get(),
		];
	}
}