<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name',
    ];

    public function users(){
        return $this->hasMany('App\User', 'group_id', 'id');
    }

    public function departments(){
        return $this->hasMany('App\Department', 'group_id', 'id');
    }
    
}
