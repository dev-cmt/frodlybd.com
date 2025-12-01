<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\Str;

class PricingPlan extends Model
{
    protected $fillable = [
        'name', 'slug', 'domain_count', 'price', 'regular_price', 'billing_cycle', 'description', 'features', 'status'
    ];

    protected $casts = [
        'features' => 'array', // automatically decode JSON to array
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(fn($priceing) => $priceing->slug = Str::slug($priceing->name));
        static::updating(fn($priceing) => $priceing->slug = Str::slug($priceing->name));
    }
}
