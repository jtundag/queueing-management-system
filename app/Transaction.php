<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
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

    public function queueEntries(){
        return $this->belongsToMany('App\Department', 'department_transaction', 'transaction_id', 'department_id')->withPivot(['priority_number', 'status']);
    }
}
