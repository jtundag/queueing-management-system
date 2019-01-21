<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = [
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
        return $this->hasOne('App\TransactionFlow', 'transaction_id', 'id');
    }

    public function queues(){
        return $this->hasMany('App\Queue', 'transaction_id', 'id');
    }
    
}
