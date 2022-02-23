<?php

namespace App\Http\Controllers\Api;

use App\Dto\MangaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\MangaRequest;
use App\Http\Resources\MangaResource;
use App\Models\Manga;
use App\Services\MangaService;

class MangaController extends Controller
{
    public function index()
    {
        return MangaResource::collection(
            Manga::query()->get()
        );
    }

    public function store(MangaRequest $request, MangaService $service)
    {
        $manga = $service->save(new Manga(), MangaDto::fromRequest($request->validated()));

        return new MangaResource($manga);
    }

    public function show(Manga $manga)
    {
        return new MangaResource($manga);
    }

    public function update(MangaRequest $request, Manga $manga, MangaService $service)
    {
        $service->save($manga, MangaDto::fromRequest($request->validated()));

        return new MangaResource($manga);
    }

    public function destroy(Manga $manga, MangaService $service)
    {
        $service->delete($manga);

        return response()->noContent();
    }
}
