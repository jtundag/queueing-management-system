<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class ServerRepository extends Repository implements TableContract{
	public function model(){
		return '\App\Server';
	}
	
	public function forTable(\Illuminate\Http\Request $request){
		return [
			'result' => $this->all()->map(function($server){
				$server['department'] = $server->department;
				return $server;
			}),
		];
	}
}