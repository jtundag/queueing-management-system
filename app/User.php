<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'uuid',
        'username',
        'first_name', 
        'middle_name', 
        'last_name', 
        'email', 
        'password',
        'gender',
        'mobile_no',
        'phone_no',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function department(){
        return $this->belongsTo('App\Department');
    }
    
    public function servers(){
        return $this->belongsToMany('App\Server', 'personnel_server', 'id', 'personnel_id');
    }
    
}
