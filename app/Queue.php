<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'queues';
    protected $fillable = [
        'transaction_id',
        'service_id',
        'priority_number',
        'status',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function transaction(){
        return $this->belongsTo('App\Transaction');
    }
    
    public function department(){
        return $this->belongsTo('App\Department');
    }

    public function service(){
        return $this->belongsTo('App\Service');
    }
    
}
