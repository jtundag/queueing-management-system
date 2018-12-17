<?php

namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\Contracts\TableContract;

class CourseRepository extends Repository implements TableContract{

	public function model(){
		return '\App\Course';
	}

	public function forTable(\Illuminate\Http\Request $request){
		return [
			'result' => $this->all()->map(function($course){
				$course['department'] = $course->department;
				return $course;
			}),
		];
	}
}