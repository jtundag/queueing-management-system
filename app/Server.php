<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';
    protected $fillable = [
        'department_id',
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function services(){
        return $this->belongsToMany('App\Service', 'server_service', 'server_id', 'service_id')->withPivot(['duration']);
    }

    public function personnels(){
        return $this->belongsToMany('App\User', 'personnel_server', 'server_id', 'personnel_id');
    }
    
    public function department(){
        return $this->belongsTo('App\Department');
    }
    
    public function queues(){
        return $this->hasMany('App\Queue', 'server_id', 'id');
    }
    
    public function skippedQueues(){
        return $this->belongsToMany('App\Queue', 'skipped_queues', 'server_id', 'queue_id')->withTimestamps();
    }
    
}
