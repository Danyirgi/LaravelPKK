<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

<<<<<<< HEAD
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = "user"; 

=======
class User extends Authenticatable
{
    use Notifiable;

>>>>>>> 88935b6138a5fd4f44ef8594f92bfb33c2967cfb
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
        'username', 'fullname', 'alamat', 'email', 'password', 'kodepos',
=======
        'name', 'email', 'password',
>>>>>>> 88935b6138a5fd4f44ef8594f92bfb33c2967cfb
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
<<<<<<< HEAD

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
=======
>>>>>>> 88935b6138a5fd4f44ef8594f92bfb33c2967cfb
}
