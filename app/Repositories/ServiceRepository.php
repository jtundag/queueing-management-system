<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ServiceRepository extends Repository{
	public function model(){
		return '\App\Service';
	}
}