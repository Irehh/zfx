<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'remember_token',
        'slug',
        'phone_verified',
        'document_verified',
        'balance',
        'blocked_at',
        'role',
        'provider',
        'provider_id',
        'status',
        'referral_code',
        'referrer'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function UserDetails()
    {
        return $this->hasOne(UserDetails::class);
    }
 
    public function UserWallet()
    {
        return $this->hasOne(UserWallet::class);
    }

    public function Deposits()
    {
        return $this->hasMany(Deposits::class);
    }

    public static function getUserInfo(){
        return User::with(['Deposits','UserDetails','UserWallet']);
    }
}
