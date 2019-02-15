<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

// class User extends Authenticatable
class User extends Eloquent implements Authenticatable, JWTSubject
{
    use AuthenticableTrait;
    protected $connection = 'mongodb';
    protected $collection = 'users';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

//    /**
//     * The attributes that should be hidden for arrays.
//     *
//     * @var array
//     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

    /*
    url : https://jwt-auth.readthedocs.io/en/docs/quick-start/#update-your-user-model

    */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
