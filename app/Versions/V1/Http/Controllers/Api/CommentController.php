<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\CommentableTypeEnum;
use App\Interfaces\Commentable;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Manga;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\CommentRequest;
use App\Versions\V1\Http\Resources\CommentCollection;
use App\Versions\V1\Http\Resources\CommentResource;
use App\Versions\V1\Repositories\CommentableRepository;
use App\Versions\V1\Repositories\CommentRepository;
use App\Versions\V1\Services\CommentableService;
use App\Versions\V1\Services\CommentService;
use App\Versions\V1\Traits\IdentifiesModels;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use function response;

class CommentController extends Controller
{
    use IdentifiesModels;

    public function __construct()
    {
        $this->middleware('auth')->except('index');
        $this->authorizeResource(Comment::class);
    }

    public function index(
        CommentableTypeEnum $model,
        int                 $id,
        Request             $request
    ): CommentCollection
    {
        $comments = app(CommentableRepository::class, [
            'commentable' => $model->identify($id)
        ])->paginate($request->get('count'));

        return new CommentCollection($comments);
    }

    public function loadChild(int $parentId, Request $request)
    {
        $comments = app(CommentRepository::class)
            ->loadChild($parentId, $request->get('count'));

        return new CommentCollection($comments);
    }

    public function store(
        CommentableTypeEnum $model,
        int                 $id,
        CommentRequest      $request,
    ): CommentResource
    {
        $comment = app(CommentableService::class, [
           'commentable' => $model->identify($id),
        ])->store(CommentDto::fromRequest($request));

        return new CommentResource($comment);
    }

    public function update(
        Comment        $comment,
        CommentRequest $request,
    ): CommentResource
    {
        app(CommentService::class, [
            'comment' => $comment
        ])->update(CommentDto::fromRequest($request));

        return new CommentResource($comment);
    }

    public function destroy(Comment $comment): Response
    {
        app(CommentService::class, [
            'comment' => $comment
        ])->destroy();

        return response()->noContent();
    }
}
