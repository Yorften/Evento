<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Music Concerts']);
        Category::create(['name' => 'Art Exhibitions']);
        Category::create(['name' => 'Food Festivals']);
        Category::create(['name' => 'Sports Events']);
        Category::create(['name' => 'Technology Conferences']);
        Category::create(['name' => 'Fashion Shows']);
        Category::create(['name' => 'Film Screenings']);
        Category::create(['name' => 'Wellness Retreats']);
        Category::create(['name' => 'Educational Workshops']);
        Category::create(['name' => 'Cultural Festivals']);
        Category::create(['name' => 'Business Networking Events']);
        Category::create(['name' => 'Charity Fundraisers']);
        Category::create(['name' => 'Comedy Shows']);
        Category::create(['name' => 'Gaming Tournaments']);
        Category::create(['name' => 'Travel Expos']);
        Category::create(['name' => 'Automotive Events']);
        Category::create(['name' => 'Dance Performances']);
        Category::create(['name' => 'Environmental Sustainability Events']);
        Category::create(['name' => 'Literary Readings']);
        Category::create(['name' => 'Pet Shows']);
    }
}
