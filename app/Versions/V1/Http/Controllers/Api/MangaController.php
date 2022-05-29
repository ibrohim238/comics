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
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MangaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Manga::class);
    }

    public function index(Request $request)
    {
        $mangas = QueryBuilder::for(Manga::class)
            ->with('media', 'ratings')
            ->allowedFilters(
                AllowedFilter::exact('genres', 'genres.name'),
                AllowedFilter::exact('categories', 'categories.name'),
                AllowedFilter::exact('tags', 'tags.name')
            )
            ->paginate($request->get('count'));

        return new MangaCollection($mangas);
    }

    public function random()
    {
        $manga = Manga::inRandomOrder()->first();

        return response(route('manga.show', $manga));
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
