<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'category', 'description', 'itinerary',
        'duration_days', 'duration_nights', 'price', 'discount_price',
        'image', 'gallery', 'is_active', 'is_featured', 'max_pax',
        'includes', 'excludes', 'terms',
    ];

    protected $casts = [
        'itinerary' => 'array',
        'gallery' => 'array',
        'includes' => 'array',
        'excludes' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
