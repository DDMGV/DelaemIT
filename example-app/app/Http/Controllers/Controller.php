<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="API для складов по городам (ДелаемIT)",
 *     version="1.0.0",
 *     description="Документация API для работы с городами и складами",
 *     @OA\Contact(
 *         email="magoed694@gmail.com"
 *     ),
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Use Bearer Token for authorization"
 * )
 *
 * @OA\Security(
 *     securityScheme="bearerAuth"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
