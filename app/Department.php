<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->hasMany('App\User', 'department_id', 'id');
    }

    public function courses(){
        return $this->hasMany('App\Course', 'department_id', 'id');
    }
    
}
