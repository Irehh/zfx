<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserWallet extends Model
{
    use HasFactory;
    
    protected $table = 'user_wallet';


    protected $fillable = [
        'wallet_type',
        'wallet_address',
        'profit',
        'referal_bonus',
        'trading_bonus',
        'balance'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
