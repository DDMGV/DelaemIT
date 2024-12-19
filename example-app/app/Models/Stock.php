<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Stock",
 *     type="object",
 *     required={"id", "city_id", "name", "lat", "lng"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="city_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Main Warehouse"),
 *     @OA\Property(property="lat", type="numeric", example="55,123456"),
 *     @OA\Property(property="lng", type="numeric", example="23,123456")
 * )
 */
class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['city_id', 'address', 'lat', 'lng'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
