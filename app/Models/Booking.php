<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'name',
        'travel_date',
        'travel_from',
        'travel_to',
        'booking_status',
        'payment_status',
    ];
}
