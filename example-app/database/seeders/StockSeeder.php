<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['city_id' => 1, 'address' => 'Автозаводская улица, 23с308', 'lat' => 55.691465, 'lng' => 37.633760],
            ['city_id' => 2, 'address' => 'улица Марата, 67/17Б', 'lat' => 59.921439, 'lng' => 30.343599],
            ['city_id' => 3, 'address' => 'Козлёнская улица, 47', 'lat' => 59.213735, 'lng' => 39.896553]
        ];

        foreach ($stocks as $stock) {
            Stock::firstOrCreate(['city_id' => $stock['city_id'], 'address' => $stock['address'], 'lat' => $stock['lat'], 'lng' => $stock['lng']]);
        }
    }
}
