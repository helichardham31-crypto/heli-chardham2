<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MealStaff extends Model
{
    use HasFactory;

    // Define the table associated with this model
    protected $table = 'meals_staff';

    // Fillable fields to allow mass assignment
    protected $fillable = [
        'unique_code',
        'name',
        'ref_id',
        'type',
        'meal',
        'date',
    ];
}
