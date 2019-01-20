<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionFlow extends Model
{
    protected $table = 'transaction_flows';
    protected $fillable = [
        'flow_id',
        'transaction_id',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }
    
    public function steps(){
        return $this->belongsToMany('App\Step', 'transction_flow_steps', 'transaction_flow_id', 'step_id');
    }
    
}
