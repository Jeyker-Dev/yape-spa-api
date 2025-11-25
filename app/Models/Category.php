<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
