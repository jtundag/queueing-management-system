<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'steps';
    
    protected $fillable = [
        'department_id',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function flow(){
        return $this->belongsTo('App\PredefinedFlow');
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
    
    public function services(){
        return $this->belongsToMany('App\Service', 'service_step', 'step_id', 'service_id');
    }
    
}
