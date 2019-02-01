<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PredefinedFlow extends Model
{
    protected $table = 'predefined_flows';

    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function steps(){
        return $this->hasMany('App\Step', 'flow_id', 'id');
    }

    public function tags(){
        return $this->belongsToMany('App\Tag', 'predefined_flow_tag', 'flow_id', 'tag_id');
    }
    
}
