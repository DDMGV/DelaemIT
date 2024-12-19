<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['id' => 1, 'name' => 'Москва'],
            ['id' => 2, 'name' => 'Санкт-Петербург'],
            ['id' => 3, 'name' => 'Вологда'],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['id' => $city['id'], 'name' => $city['name']]);
        }
    }
}
