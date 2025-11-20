<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Availability extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'is_working',
    ];
}
