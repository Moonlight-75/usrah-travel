<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'package_id', 'booking_ref', 'status',
        'travel_date', 'return_date', 'pax_adults', 'pax_children', 'pax_infants',
        'total_amount', 'paid_amount', 'room_preference',
        'special_requests', 'admin_notes', 'cancelled_reason', 'cancelled_at',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'return_date' => 'date',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'special_requests' => 'array',
        'cancelled_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function tourGroup()
    {
        return $this->hasOne(TourGroup::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
