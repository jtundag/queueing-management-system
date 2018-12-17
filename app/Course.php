<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'department_id',
        'name',
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }
    
}
