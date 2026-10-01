<?php

namespace App\Models;

use App\Models\Concerns\Translatable;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use Translatable;

    protected $fillable = [
        'company_en', 'company_km', 'position_en', 'position_km',
        'location_en', 'location_km', 'description_en', 'description_km',
        'content_en', 'content_km', 'logo',
        'start_date', 'end_date', 'is_current', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];
}
