<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\MangaDto;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\MangaRequest;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Repositories\MangaRepository;
use App\Versions\V1\Services\MangaService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->authorizeResource(Manga::class);
    }

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

    public function show(Manga $manga): MangaResource
    {
        return new MangaResource(
            app(MangaRepository::class, [
                'manga' => $manga
            ])->load()->getManga()
        );
    }

    /**
     * @throws UnknownProperties
     */
    public function store(MangaRequest $request): MangaResource
    {
        $manga = app(MangaService::class)
            ->store(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(MangaRequest $request, Manga $manga): MangaResource
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->update(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function destroy(Manga $manga): Response
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->delete();

        return response()->noContent();
    }
}
