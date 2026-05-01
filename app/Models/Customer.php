<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ic_passport_no', 'ic_passport_expiry',
        'address', 'city', 'state', 'postcode', 'country',
        'emergency_name', 'emergency_phone', 'emergency_relation',
    ];

    protected $casts = [
        'ic_passport_expiry' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
