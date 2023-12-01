<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserWallet extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'wallet_type',
        'wallet_address'
    ];
}
