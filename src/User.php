<?php

namespace Microservices;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Notifications\Notifiable;
// use Laravel\Passport\HasApiTokens;

class User /* extends Authenticatable */
{
    // use HasApiTokens, Notifiable;

    // protected $guarded = ['id'];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password',
    // ];

    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $is_influencer;

    public function __construct($json)
    {
        $this->id = $json['id'];
        $this->first_name = $json['first_name'];
        $this->last_name = $json['last_name'];
        $this->email = $json['email'];
        $this->is_influencer = $json['is_influencer'] ?? 0;
    }

    public function isAdmin(): bool {
        return $this->is_influencer === 0;
    }

    public function isInfluencer(): bool {
        return $this->is_influencer === 1;
    }

    public function /*getFullNameAttribute*/ fullName(){
        return $this->first_name . ' ' . $this->last_name;
    }
}
