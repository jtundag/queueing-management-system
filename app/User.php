<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
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
        'verified_at',
        'player_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'verified_at',
    ];

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function department(){
        return $this->belongsTo('App\Department');
    }
    
    public function servers(){
        return $this->belongsToMany('App\Server', 'personnel_server', 'personnel_id', 'server_id');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction', 'user_id', 'id');
    }

    public function myServersServices(){
        return $this->servers()->with('services');
    }
    
    public function queues(){
        return $this->hasManyThrough('App\Queue', 'App\Transaction');
    }
    
}
