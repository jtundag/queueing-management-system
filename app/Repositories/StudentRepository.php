<?php

namespace App\Repositories;

use App\Repositories\Repository;

class StudentRepository extends Repository{
	private $role = 'student';
	
	public function model(){
		return '\App\User';
	}
}