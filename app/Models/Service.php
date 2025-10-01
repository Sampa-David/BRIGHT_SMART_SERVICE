<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    

    protected $fillable = [
        'name',
        'title',
        'description',
        'price',
        'image',
    ];

    public function service_requests()
    {
        return $this->hasMany(ServiceRequest::class);
    }
}
