<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\TagDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\TagRequest;
use App\Versions\V1\Http\Resources\TagCollection;
use App\Versions\V1\Http\Resources\TagResource;
use App\Versions\V1\Services\TagService;
use IAleroy\Tags\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{


    public function index(Request $request): TagCollection
    {
        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters(['type'])
            ->paginate($request->get('count'));

        return new TagCollection($tags);
    }

    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    /**
     * @throws UnknownProperties
     */
    public function store(TagRequest $request): TagResource
    {
        $tag = app(TagService::class)->store(TagDto::fromRequest($request));

        return new TagResource($tag);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(Tag $tag, TagRequest $request): TagResource
    {
        app(TagService::class, [
            'tag' => $tag
        ])->update(TagDto::fromRequest($request));

        return new TagResource($tag);
    }

    public function destroy(Tag $tag): Response
    {
        app(TagService::class, [
            'tag' => $tag
        ])->delete();

        return response()->noContent();
    }
}
