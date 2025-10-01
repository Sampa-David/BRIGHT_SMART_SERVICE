<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'contact_method',
        'phone',
        'status',
        'admin_response',
        'response_sent_at'
    ];

    protected $casts = [
        'response_sent_at' => 'datetime',
    ];
}
