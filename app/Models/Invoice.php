<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'language',
        'logo_path',
        'items',
        'total'
    ];

    protected $casts = [
        'items' => 'array'
    ];
}