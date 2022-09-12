<?php

namespace App\Swagger\Responses;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class BadRequestResponse extends OA\Response
{
    public function __construct(OA\JsonContent $content = null)
    {
        parent::__construct(response: Response::HTTP_BAD_REQUEST, description: 'Bad request.', content: $content);
    }
}
