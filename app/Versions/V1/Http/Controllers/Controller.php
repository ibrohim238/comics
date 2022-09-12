<?php

namespace App\Versions\V1\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes as OA;

#[OA\Server(
    url: '/api/v1'
)]
#[OA\Info(
    version: '1.0.0',
    description: 'V1 Api docs',
    title: 'Comics documentation',
    contact: new OA\Contact(email: ''),
    license: new OA\License(name: 'Apache 2.0', url: 'https://www.apache.org/licenses/LICENSE-2.0.html')
)]
#[OA\SecurityScheme(
    securityScheme: 'api-key',
    type: 'http',
    name: 'Authorization',
    in: 'header',
    bearerFormat: 'JWT',
    scheme: 'bearer'
)]
#[OA\Tag(name: 'Mangas', description: 'комиксы')]
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
