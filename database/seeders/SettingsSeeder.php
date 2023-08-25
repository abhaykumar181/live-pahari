<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Settings::create([
            'title' => 'Your Website Title here',
            'slug' => 'your-website-title-here',
            'thumbnail' => 'logo.jpg',
            'maxGuests' => 10,
            'CurateifGuests' => 4,

        ]);
    }
}
