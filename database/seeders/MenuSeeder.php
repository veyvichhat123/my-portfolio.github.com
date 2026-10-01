<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Menu, Page};

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Page::updateOrCreate(['slug' => 'manual'], [
        'title_en'   => 'Manual',
        'title_km'   => 'សៀវភៅណែនាំ',
        'content_en' => '<h2>How to use</h2><p>Write your manual here.</p>',
        'is_active'  => true,
        ]);

        Menu::updateOrCreate(['slug' => 'manual', 'page_type' => 'page'], [
            'title_en'   => 'Manual',
            'title_km'   => 'សៀវភៅណែនាំ',
            'sort_order' => 10,
            'is_active'  => true,
        ]);
    }
}
