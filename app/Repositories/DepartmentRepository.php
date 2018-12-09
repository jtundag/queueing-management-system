<?php

namespace App\Repositories;

use App\Repositories\Repository;

class DepartmentRepository extends Repository{
	public function model(){
		return '\App\Department';
	}
}