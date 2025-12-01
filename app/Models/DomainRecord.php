<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainRecord extends Model
{
    protected $fillable = [
        'order_id', 'domain_name', 'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
