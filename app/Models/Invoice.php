<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //  Allow mass assignment
    protected $fillable = [
        'customer_name',
        'items',
        'total'
    ];

    //  Convert JSON to array automatically
    protected $casts = [
        'items' => 'array'
    ];
}