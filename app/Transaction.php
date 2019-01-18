<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
        'department_id',
        'flow_id',
        'user_id',
        'status',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function flow(){
        return $this->belongsTo('App\Flow');
    }

    public function queues(){
        return $this->belongsToMany('App\Service', 'service_transaction', 'transaction_id', 'service_id')->withPivot(['priority_number', 'status', 'created_at', 'updated_at',]);
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
}
