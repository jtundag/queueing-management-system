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
    
}
