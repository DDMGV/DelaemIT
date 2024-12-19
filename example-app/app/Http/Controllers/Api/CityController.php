<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CityController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/cities",
     *     summary="Получить список всех городов",
     *     tags={"Cities"},
     *     @OA\Response(
     *         response=200,
     *         description="Список городов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/City")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(City::all());
    }

    /**
     * @OA\Get(
     *     path="/api/city/{id}",
     *     summary="Получить информацию о городе",
     *     tags={"Cities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о городе",
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Город не найден"
     *     )
     * )
     */
    public function show($id): JsonResponse
    {
        $city = City::find($id);
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }
        return response()->json($city);
    }

    /**
     * @OA\Post(
     *     path="/api/city",
     *     summary="Создать новый город",
     *     tags={"Cities"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Minsk")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Город создан",
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Неверный запрос"
     *     ),
     *     @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate(['name' => 'required|string']);
        $city = City::create($request->only('name'));
        return response()->json($city, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/city/{id}",
     *     summary="Обновить информацию о городе",
     *     tags={"Cities"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Minsk")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Информация о городе обновлена",
     *         @OA\JsonContent(ref="#/components/schemas/City")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Город не найден"
     *     )
     * )
     */
    public function update(Request $request, $id): JsonResponse
    {
        $city = City::find($id);
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }
        $request->validate(['name' => 'required|string']);
        $city->update($request->only('name'));
        return response()->json($city);
    }

    /**
     * @OA\Delete(
     *     path="/api/city/{id}",
     *     summary="Удалить город",
     *     tags={"Cities"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Город удален"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Город не найден"
     *     )
     * )
     */
    public function destroy($id): JsonResponse
    {
        $city = City::find($id);
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }
        $city->delete();
        return response()->json(['message' => 'City deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/city/{id}/stocks",
     *     summary="Получить список складов города",
     *     tags={"Cities"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Список складов",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Stock")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Город не найден"
     *     )
     * )
     */
    public function getStocks($id): JsonResponse
    {
        $city = City::find($id);
        if (!$city) {
            return response()->json(['message' => 'City not found'], 404);
        }
        return response()->json($city->stock);
    }
}
