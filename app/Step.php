<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'steps';
    
    protected $fillable = [
        'service_id',
        'flow_id',
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
    
    public function service(){
        return $this->belongsTo('App\Service');
    }

    public function transactionFlows(){
        return $this->belongsToMany('App\TransactionFlow', 'transaction_flow_steps', 'step_id', 'transaction_flow_id')->withPivot(['status']);
    }
    
}
