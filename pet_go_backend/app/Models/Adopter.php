<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adopter extends Model
{
    use HasFactory;

    protected $fillable = [
        'identity',
        'status',
        'adoption_id',
        'user_id',
    ];
}
