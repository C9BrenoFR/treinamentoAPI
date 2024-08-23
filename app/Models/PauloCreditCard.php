<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PauloCreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'number',
        'brand',
        'is_credit',
        'user_id',
    ];
}
