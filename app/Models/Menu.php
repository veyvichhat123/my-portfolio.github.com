<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title_en',
        'title_km',
        'slug',
        'parent_id',
        'page_type',
        'sort_order',
        'is_active',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class);
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
            ->orderBy('sort_order');
    }

    public function getTitleAttribute()
    {
        return app()->getLocale() === 'km'
            ? $this->title_km
            : $this->title_en;
    }
}
