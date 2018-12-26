<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class StudentRepository extends Repository implements TableContract{
	private $role = 'student';
	
	public function model(){
		return '\App\User';
	}
	
	public function forTable(\Illuminate\Http\Request $request){
		return [
			'result' => $this->model->whereIs($request->role)->get()->map(function($user){
				$user['department'] = $user->department;
				return $user;
			}),
		];
	}

}