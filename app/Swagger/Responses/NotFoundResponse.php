<?php

namespace App\Swagger\Responses;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class NotFoundResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(response: Response::HTTP_NOT_FOUND, description: 'Not found.');
    }
}
