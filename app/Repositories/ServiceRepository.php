<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class ServiceRepository extends Repository implements TableContract{
	public function model(){
		return '\App\Service';
	}
	
	public function forTable(\Illuminate\Http\Request $request){
		$items = $this->all()->map(function($service){
			$service['department'] = $service->department;
			return $service;
		});
		
		return [
			'result' => $items,
		];
	}
}