<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    protected $table = 'queues';
    protected $fillable = [
        'transaction_id',
        'department_id',
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

    public function server(){
        return $this->belongsTo('App\Server');
    }
    
    public function skippedServers(){
        return $this->belongsToMany('App\Server', 'skipped_queues', 'queue_id', 'server_id')->withTimestamps();
    }
}
