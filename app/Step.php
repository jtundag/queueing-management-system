<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'steps';
    
    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function flow(){
        return $this->belongsTo('App\PredefinedFlow');
    }

    public function servers(){
        return $this->belongsToMany('App\Server', 'server_step', 'step_id', 'server_id');
    }
}
