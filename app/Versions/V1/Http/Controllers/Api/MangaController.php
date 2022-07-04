<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\MangaRequest;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Repository\MangaRepository;
use App\Versions\V1\Services\MangaService;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->authorizeResource(Manga::class);
    }

    public function index(Request $request, MangaRepository $repository)
    {
        return new MangaCollection(
            $repository->paginate($request->get('count'))
        );
    }

    public function random()
    {
        $manga = Manga::inRandomOrder()->first();

        return response(route('manga.show', $manga));
    }

    public function show(Manga $manga): MangaResource
    {
        return new MangaResource(
            app(MangaRepository::class, [
                'manga' => $manga
            ])->load()
        );
    }


    /**
     * @throws UnknownProperties
     */
    public function store(MangaRequest $request)
    {
        $manga = app(MangaService::class)
            ->store(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(MangaRequest $request, Manga $manga)
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->update(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function destroy(Manga $manga)
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->delete();

        return response()->noContent();
    }
}
