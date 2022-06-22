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
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MangaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
        $this->authorizeResource(Manga::class);
    }

    public function index(Request $request, MangaRepository $repository)
    {
        return new MangaCollection($repository->paginate($request->get('count')));
    }

    public function random()
    {
        $manga = Manga::inRandomOrder()->first();

        return response(route('manga.show', $manga));
    }

    public function show(Manga $manga): MangaResource
    {
        return (new MangaResource($manga->loadAvg('ratings', 'value')));
    }

    /**
     * @throws UnknownProperties
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(MangaRequest $request)
    {
        $manga = app(MangaService::class)->save(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    /**
     * @throws UnknownProperties
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(MangaRequest $request, Manga $manga)
    {
        app(MangaService::class, [
            'manga' => $manga
        ])->save(MangaDto::fromRequest($request));

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
