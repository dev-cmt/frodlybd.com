<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DomainRecord extends Model
{
    protected $fillable = [
        'sale_id', 'domain_name', 'status'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
