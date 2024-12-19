<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="City",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Minsk")
 * )
 */
class City extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function stock()
    {
        return $this->hasMany(Stock::class);
    }
}

