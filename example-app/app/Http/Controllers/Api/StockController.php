<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Stock;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StockController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/stocks",
     *     summary="Все склады",
     *     description="Получить список всех складов.",
     *     tags={"Stocks"},
     *     @OA\Response(
     *         response=200,
     *         description="Список складов.",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Stock"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(Stock::all());
    }

    /**
     * @OA\Get(
     *     path="/api/stocks/{id}",
     *     summary="Просмотр склада",
     *     description="Получить информацию о складе по ID.",
     *     tags={"Stocks"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID склада",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о складе.",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Склад не найден."
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }

        return response()->json($stock);
    }

    /**
     * @OA\Post(
     *     path="/api/stocks",
     *     summary="Создание склада",
     *     description="Создать новый склад.",
     *     tags={"Stocks"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city_id", "address", "lat", "lng"},
     *             @OA\Property(property="city_id", type="integer", example=1),
     *             @OA\Property(property="address", type="string", example="Плеханова, дом 2"),
     *             @OA\Property(property="lat", type="number", format="float", example=12.323232),
     *             @OA\Property(property="lng", type="number", format="float", example=34.343432)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Склад успешно создан.",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибки валидации."
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stock = Stock::create($request->all());
        return response()->json($stock, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/stocks/{id}",
     *     summary="Обновление склада",
     *     description="Обновить информацию о складе.",
     *     tags={"Stocks"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID склада",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"city_id", "address", "lat", "lng"},
     *             @OA\Property(property="city_id", type="integer", example=1),
     *             @OA\Property(property="address", type="string", example="Плеханова, дом 2"),
     *             @OA\Property(property="lat", type="number", format="float", example=12.323232),
     *             @OA\Property(property="lng", type="number", format="float", example=34.343432)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о складе обновлена.",
     *         @OA\JsonContent(ref="#/components/schemas/Stock")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Склад не найден."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибки валидации."
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $stock->update($request->all());
        return response()->json($stock);
    }

    /**
     * @OA\Delete(
     *     path="/api/stocks/{id}",
     *     summary="Удаление склада",
     *     description="Удалить склад по ID.",
     *     tags={"Stocks"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID склада",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Склад успешно удален."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Склад не найден."
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $stock = Stock::find($id);

        if (!$stock) {
            return response()->json(['message' => 'Stock not found'], 404);
        }

        $stock->delete();
        return response()->json(['message' => 'Stock deleted successfully']);
    }

    /**
     * @OA\Post(
     *     path="/api/stocks/nearby",
     *     summary="Поиск ближайшего склада",
     *     description="Найти ближайший склад по координатам.",
     *     tags={"Stocks"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"lat", "lng"},
     *             @OA\Property(property="lat", type="number", format="float", example=23.323232),
     *             @OA\Property(property="lng", type="number", format="float", example=23.212143)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ближайший склад найден.",
     *         @OA\JsonContent(
     *             @OA\Property(property="stock", ref="#/components/schemas/Stock"),
     *             @OA\Property(property="distance", type="number", format="float", example=5.6),
     *             @OA\Property(property="city", ref="#/components/schemas/City")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Ближайший склад не найден."
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибки валидации."
     *     )
     * )
     */
    public function findNearby(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lat = $request->lat;
        $lng = $request->lng;

        $stocks = Stock::all();
        $nearestStock = null;
        $minDistance = PHP_INT_MAX;

        foreach ($stocks as $stock) {
            $distance = $this->calculateDistance($lat, $lng, $stock->lat, $stock->lng);

            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearestStock = $stock;
            }
        }

        if ($nearestStock) {
            $city = City::find($nearestStock->city_id);
            return response()->json([
                'stock' => $nearestStock,
                'distance' => $minDistance,
                'city' => $city,
            ]);
        }

        return response()->json(['message' => 'No nearby stock found'], 404);
    }

    private function calculateDistance($lat1, $lng1, $lat2, $lng2): int
    {
        $earthRadius = 6371; // Радиус Земли в км

        $latFrom = deg2rad($lat1);
        $lngFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lngTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lngDelta / 2) * sin($lngDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c; // Расстояние в км
    }
}
