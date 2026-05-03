<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
use SoftDeletes;
use HasFactory;

    protected $fillable = [
    'equipment_id',
    'name',
    'user_id',
    'quantity',
    'date_of_booking',
    'rejection_reason',
    'booking_time',
    'date_of_return',
    'return_time',
    'location',
    'status',
];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
