<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatInfo extends Model
{
    use HasFactory;
    protected $fillable =[
        'group_title',
        'chat_img'
    ];
}
