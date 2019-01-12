<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';
    protected $fillable = [
        'department_id',
        'name',
        'prefix',
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

    public function steps(){
        return $this->belongsToMany('App\Step', 'server_step', 'server_id', 'step_id');
    }
    
}
