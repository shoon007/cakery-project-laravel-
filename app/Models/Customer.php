<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',

    ];
}
