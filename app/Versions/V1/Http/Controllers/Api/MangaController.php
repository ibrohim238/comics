<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\MangaRequest;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Models\Manga;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Services\MangaService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaController extends Controller
{
    public function index()
    {
        return new MangaCollection(
            Manga::query()->get()
        );
    }

    /**
     * @throws UnknownProperties
     */
    public function store(MangaRequest $request)
    {
        $manga = (new MangaService(new Manga()))->save(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function show(Manga $manga): MangaResource
    {
        return (new MangaResource($manga->load('comments', 'chapters')));
    }

    /**
     * @throws UnknownProperties
     */
    public function update(MangaRequest $request, Manga $manga)
    {
        (new MangaService($manga))->save(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function destroy(Manga $manga)
    {
        (new MangaService($manga))->delete();

        return response()->noContent();
    }
}
