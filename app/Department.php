<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = [
        'group_id',
        'name',
        'prefix',
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

    public function steps(){
        return $this->hasMany('App\Step', 'department_id', 'id');
    }

    public function transactions(){
        return $this->belongsToMany('App\Transaction', 'department_transaction', 'department_id', 'transaction_id')->withPivot(['priority_number', 'status']);
    }
    
}
