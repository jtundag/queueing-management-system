<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function servers(){
        return $this->belongsToMany('App\Server', 'server_service', 'service_id', 'server_id')->withPivot(['duration']);
    }
    
    public function steps(){
        return $this->hasMany('App\Step', 'service_id', 'id');
    }

    public function queues(){
        return $this->hasMany('App\Queue', 'service_id', 'id');
    }
    
}
