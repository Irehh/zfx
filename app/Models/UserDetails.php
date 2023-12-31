<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetails extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user_details';

    protected $fillable = [
        'last_name',
        'first_name',
        'city',
        'country',
        'photo',
        'verication_document',
        'profile_image',
        'phone_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
