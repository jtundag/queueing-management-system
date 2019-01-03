<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'group_id',
        'name',
    ];

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function users(){
        return $this->hasMany('App\User', 'department_id', 'id');
    }

    public function servers(){
        return $this->hasMany('App\Server', 'department_id', 'id');
    }
    
}
