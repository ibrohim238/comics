<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Swagger\Responses\NotFoundResponse;
use App\Swagger\Responses\UnauthorizedResponse;
use App\Swagger\Responses\UnprocessableEntityResponse;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\MangaRequest;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Repositories\MangaRepository;
use App\Versions\V1\Services\MangaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use OpenApi\Attributes as OA;
use function app;
use function response;
use function route;

class MangaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->authorizeResource(Manga::class);
    }

    #[OA\Get(
        path: '/manga',
        description: 'Список манг',
        summary: 'Список манг',
        security: [
            [
                'api-key' => []
            ]
        ],
        tags: ['Mangas'],
        parameters: [
            new OA\Parameter(
                name: 'page',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'limit',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'filter[name]',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'filter[teams]',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            ),
            new OA\Parameter(
                name: 'filter[tags]',
                in: 'query',
                required: false,
                schema: new OA\Schema(type: 'integer')
            )
        ],
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/MangaResource")
    )]
    public function index(Request $request): MangaCollection
    {
        return new MangaCollection(
            app(MangaRepository::class)
                ->paginate($request->get('count'))
        );
    }

    public function random()
    {
        $manga = Manga::inRandomOrder()->first();

        return response()->json([
            'url' => route('manga.show', $manga)
        ]);
    }

    #[OA\Get(
        path: '/manga/{slug}',
        description: 'Страница манги',
        summary: 'Страница манги',
        security: [
            [
                'api-key' => []
            ]
        ],
        tags: ['Mangas'],
        parameters: [
            new OA\Parameter(
                name: 'slug',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string'),
                example: 1,
            ),
        ],
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/MangaResource")
    )]
    #[UnauthorizedResponse]
    #[NotFoundResponse]
    public function show(Manga $manga): MangaResource
    {
        return new MangaResource(
            app(MangaRepository::class, [
                'manga' => $manga
            ])->load()->getManga()
        );
    }

    #[OA\Post(
        path: '/mangas',
        description: 'Добавить мангу',
        summary: 'Добавить мангу',
        security: [
            [
                'api-key' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/MangaRequest')
        ),
        tags: ['Mangas']
    )]
    #[OA\Response(
        response: 201,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/MangaResource")
    )]
    #[UnprocessableEntityResponse]
    #[UnauthorizedResponse]
    public function store(MangaRequest $request)
    {
        $manga = app(MangaService::class)
            ->store(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    #[OA\Patch(
        path: '/manga/{id}',
        description: 'Обновить мангу',
        summary: 'Обновить мангу',
        security: [
            [
                'api-key' => []
            ]
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/MangaRequest')
        ),
        tags: ['Mangas'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/MangaResource")
    )]
    #[UnprocessableEntityResponse]
    #[NotFoundResponse]
    #[UnauthorizedResponse]
    public function update(MangaRequest $request, Manga $manga): MangaResource
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->update(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    #[OA\Delete(
        path: '/manga/{id}',
        description: 'Обновить мангу',
        summary: 'Обновить мангу',
        security: [
            [
                'api-key' => []
            ]
        ],
        tags: ['Mangas'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'OK',
        content: new OA\JsonContent(ref: "#/components/schemas/MangaResource")
    )]
    #[NotFoundResponse]
    #[UnauthorizedResponse]
    public function destroy(Manga $manga): Response
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->delete();

        return response()->noContent();
    }
}
