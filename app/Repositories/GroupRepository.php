<?php

namespace App\Repositories;

use App\Repositories\Repository;

class GroupRepository extends Repository{
	public function model(){
		return '\App\Group';
	}
}