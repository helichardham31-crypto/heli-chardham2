<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accompany extends Model
{
    use HasFactory;
    protected $table = 'accompany';
    // Relationship with Meals for Accompany
    protected $fillable = [
        'unique_code',
        'name',
        'ref_id',
        'type',
        'qr_code_path',
        'status',
    ];
    
     public function meals()
    {
        return $this->hasMany(Meal::class, 'unique_code', 'unique_code');
    }
    
}
