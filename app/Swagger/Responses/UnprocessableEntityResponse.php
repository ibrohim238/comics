<?php

namespace App\Swagger\Responses;

use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class UnprocessableEntityResponse extends OA\Response
{
    public function __construct(OA\JsonContent $content = null)
    {
        parent::__construct(
            response: Response::HTTP_UNPROCESSABLE_ENTITY,
            description: 'Unprocessable entity.',
            content: $content ?? new OA\JsonContent(
                properties: [
                    new OA\Property('message', type: 'string'),
                    new OA\Property('errors', type: 'array', items: new OA\Items()),
                ],
                type: 'object'
            )
        );
    }
}
