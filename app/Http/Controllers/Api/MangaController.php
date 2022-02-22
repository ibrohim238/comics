<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MangaResource;
use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function index()
    {
        return MangaResource::collection(
            Manga::query()->get()
        );
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Manga $manga)
    {
        return new MangaResource($manga);
    }

    public function edit(Manga $manga)
    {
        //
    }

    public function update(Request $request, Manga $manga)
    {
        //
    }

    public function destroy(Manga $manga)
    {
        //
    }
}
