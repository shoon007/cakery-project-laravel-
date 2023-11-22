<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'image',
        'message',
        'delete_status',
        'reset_status',
        'show_status',
        'seen_status',
        'seen_user'
    ];
}
