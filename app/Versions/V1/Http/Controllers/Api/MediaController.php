<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\MediaModelTypeEnum;
use App\Swagger\Responses\NotFoundResponse;
use App\Swagger\Responses\UnauthorizedResponse;
use App\Versions\V1\Dto\HasMediaDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\HasMediaRequest;
use App\Versions\V1\Http\Resources\MediaCollection;
use App\Versions\V1\Services\HasMediaService;
use App\Versions\V1\Services\MediaService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\QueryBuilder\QueryBuilder;
use function app;
use function response;

class MediaController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    #[OA\Get(
        path: '/media/{media_model}/{id}',
        description: 'Список Изображений модели',
        summary: 'Список Изображений модели',
        security: [
            [
                'api-key' => []
            ]
        ],
        tags: ['Media'],
        parameters: [
            new OA\Parameter(
                name: 'media_model',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    enum: [
                        MediaModelTypeEnum::manga,
                        MediaModelTypeEnum::chapter,
                    ]
                ),
            ),
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/MediaResource")
    )]
    #[NotFoundResponse]
    #[UnauthorizedResponse]
    public function index(
        MediaModelTypeEnum $model,
        int                $id,
        Request            $request
    ): MediaCollection
    {
        /* @var HasMedia $hasMedia */
        $hasMedia = $model->findModel($id);

        $this->authorize('media-index', $hasMedia);

        $media = QueryBuilder::for($hasMedia->media())
            ->defaultSort('id')
            ->paginate($request->get('limit'));

        return new MediaCollection($media);
    }

    #[OA\Post(
        path: '/media/{media_model}/{id}',
        description: 'Добавить Изображение в модель',
        summary: 'Добавить Изображение в модель',
        security: [
            [
                'api-key' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/HasMediaRequest')
        ),
        tags: ['Media'],
        parameters: [
            new OA\Parameter(
                name: 'media_model',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    enum: [
                        MediaModelTypeEnum::manga,
                        MediaModelTypeEnum::chapter
                    ]
                ),
            ),
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
    )]
    #[OA\Response(
        response: 201,
        description: 'OK',
        content: new OA\JsonContent()
    )]
    #[NotFoundResponse]
    #[UnauthorizedResponse]
    public function store(
        MediaModelTypeEnum $model,
        int                $id,
        HasMediaRequest $request,
    )
    {
        /* @var HasMedia $hasMedia */
        $hasMedia = $model->findModel($id);

        $this->authorize('media-store', $hasMedia);

        app(HasMediaService::class, [
            'hasMedia' => $hasMedia
        ])->store(HasMediaDto::fromRequest($request));

        return response()->json([
            'message' => 'Файл отправлен!'
        ]);
    }

    #[OA\Delete(
        '/media/{id}',
        description: 'Удалить изображение',
        summary: 'Удалить изображение',
        security: [
            [
                'api-key' => []
            ]
        ],
        tags: ['Media'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer'),
            ),
        ],
    )]
    #[OA\Response(
        response: 204,
        description: 'OK',
        content: new OA\JsonContent()
    )]
    #[NotFoundResponse]
    #[UnauthorizedResponse]
    public function destroy(Media $media)
    {
        $this->authorize('media-destroy', $media);

        app(MediaService::class, [
            'media' => $media
        ])->destroy();

        return response()->noContent();
    }
}
