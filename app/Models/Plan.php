<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
		'plan_name',
		'daily_percentage',
		'min_amount',
		'max_amount',
		'plan_duration',
		'referral_percentage',
		'bonus_percentage',
		'status',
	];
}
