<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Versions\V1\Actions\ShowMangaAction;
use App\Versions\V1\Dto\MangaDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\MangaRequest;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Http\Resources\MangaResource;
use App\Versions\V1\Services\MangaService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class MangaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Manga::class);
    }

    public function index()
    {
        return new MangaCollection(
            Manga::query()->get()
        );
    }

    public function show(Manga $manga, ShowMangaAction $action): MangaResource
    {
        return (new MangaResource($action->execute($manga)));
    }

    /**
     * @throws UnknownProperties
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(MangaRequest $request)
    {
        $manga = app(MangaService::class, [new Manga()])->save(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    /**
     * @throws UnknownProperties
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(MangaRequest $request, Manga $manga)
    {
        app(MangaService::class, [$manga])->save(MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function destroy(Manga $manga)
    {
        app(MangaService::class, [$manga])->delete();

        return response()->noContent();
    }
}
