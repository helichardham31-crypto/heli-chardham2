<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Meal extends Model
{
        use HasFactory;

    protected $table = 'meals'; // Name of your table

    protected $fillable = [
        'unique_code',
        'name',
        'ref_id',
        'type',
        'meal',
        'date',
    ];

}
