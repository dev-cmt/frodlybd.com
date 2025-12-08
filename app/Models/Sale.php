<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'invoice_number',
        'amount',
        'start_date',
        'end_date',
        'allowed_domains',
        'domains_count',
        'allowed_requests',
        'requests_count',
        'status' //'pending','active','expired'
    ];

    protected $dates = ['start_date', 'end_date'];

    // Order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Order belongs to a plan
    public function plan()
    {
        return $this->belongsTo(PricingPlan::class, 'plan_id');
    }

    // One order has many domains
    public function domains()
    {
        return $this->hasMany(DomainRecord::class, 'sale_id');
    }
}
