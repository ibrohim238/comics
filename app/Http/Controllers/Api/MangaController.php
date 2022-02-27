<?php

namespace App\Http\Controllers\Api;

use App\Dto\MangaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MangaRequest;
use App\Http\Resources\MangaResource;
use App\Http\Resources\UserResource;
use App\Models\Manga;
use App\Models\User;
use App\Services\MangaService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaController extends Controller
{
    public function index()
    {
        return MangaResource::collection(
            Manga::query()->get()
        );
    }

    /**
     * @throws UnknownProperties
     */
    public function store(MangaRequest $request, MangaService $service)
    {
        $manga = $service->save(new Manga(), MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function show(Manga $manga)
    {
        return new MangaResource($manga);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(MangaRequest $request, Manga $manga, MangaService $service)
    {
        $service->save($manga, MangaDto::fromRequest($request));

        return new MangaResource($manga);
    }

    public function destroy(Manga $manga, MangaService $service)
    {
        $service->delete($manga);

        return response()->noContent();
    }
}
