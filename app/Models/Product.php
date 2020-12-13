<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','identifier','description','prices','categories','images'];

    protected $casts = [
        'categories' => 'object',
        'prices' => 'object',
        'images' => 'object'
    ];
}
