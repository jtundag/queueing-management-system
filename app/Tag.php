<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    protected $fillable = [
        'text',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function flows(){
        return $this->belongsToMany('App\PredefinedFlow', 'predefined_flow_tag', 'tag_id', 'flow_id');
    }
    
}
