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
    public $timestamps = false;

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }
    
    public function steps(){
        return $this->belongsToMany('App\Step', 'transaction_flow_steps', 'transaction_flow_id', 'step_id')->withPivot(['status']);
    }
    
}
