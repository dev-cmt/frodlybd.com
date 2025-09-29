<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'favicon',
        'phone',
        'email',
        'address',
        'title',
        'description',
        'success_text',
        'fb_pixel_code',
    ];
}
