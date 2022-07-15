<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Dto\CommentDto;
use App\Enums\CommentableTypeEnum;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\CommentRequest;
use App\Versions\V1\Http\Resources\CommentCollection;
use App\Versions\V1\Http\Resources\CommentResource;
use App\Versions\V1\Services\CommentService;
use App\Versions\V1\Traits\IdentifiesModels;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentController extends Controller
{
    use IdentifiesModels;

    public function __construct()
    {
        $this->middleware('auth')->except('index');
        $this->authorizeResource(Comment::class);
    }

    /**
     * @throws Exception
     */
    public function index(
        CommentableTypeEnum $model,
        int                 $id,
        Request             $request
    ): CommentCollection
    {
        $model = $model->identify($id);

        /* @var Manga|Chapter $model */
        $comments = $model->comments()->with('user')
            ->paginate($request->get('count'));

        return new CommentCollection($comments);
    }

    /**
     * @throws UnknownProperties
     * @throws Exception
     */
    public function store(
        CommentableTypeEnum $model,
        int                 $id,
        CommentRequest      $request,
        CommentService      $service
    ): CommentResource
    {
        $model = $model->identify($id);

        /* @var Manga|Chapter $model */
        $comment = $service->create($model, CommentDto::fromRequest($request));

        return new CommentResource($comment);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(
        Comment        $comment,
        CommentRequest $request,
        CommentService $service
    ): CommentResource
    {
        $service->update($comment, CommentDto::fromRequest($request));

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment, CommentService $service): Response
    {
        $service->delete($comment);

        return response()->noContent();
    }
}
