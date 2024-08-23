<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuUser extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password'];
}
