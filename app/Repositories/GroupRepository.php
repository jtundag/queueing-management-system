<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class GroupRepository extends Repository implements TableContract{
	public function model(){
		return '\App\Group';
	}

	public function forTable(\Illuminate\Http\Request $request){
		return [
			'result' => $this->all()->map(function($group){
				$group['departments'] = $group->departments;
				return $group;
			}),
		];
	}
}