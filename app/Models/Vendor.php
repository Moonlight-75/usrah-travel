<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'contact_person', 'email', 'phone',
        'address', 'city', 'country', 'rating', 'contract_details',
        'bank_name', 'bank_account_no', 'bank_account_name',
        'is_active', 'notes',
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'is_active' => 'boolean',
    ];

    public function tourGroups()
    {
        return $this->hasMany(TourGroup::class, 'mutawwif_id');
    }
}
