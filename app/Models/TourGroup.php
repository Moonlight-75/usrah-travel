<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'mutawwif_id', 'group_name',
        'flight_no_departure', 'flight_no_return',
        'hotel_makkah', 'hotel_madinah', 'room_allocations', 'notes',
    ];

    protected $casts = [
        'room_allocations' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function mutawwif()
    {
        return $this->belongsTo(Vendor::class, 'mutawwif_id');
    }
}
