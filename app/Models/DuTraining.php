<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuTraining extends Model
{
    use HasFactory;

    protected $table = 'du_training';

    protected $fillable = [
        'name',
        'description',
        'du_user_id',
    ];
}
