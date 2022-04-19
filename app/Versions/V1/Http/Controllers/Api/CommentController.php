<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Comment;
use App\Models\Manga;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\CommentRequest;
use App\Versions\V1\Http\Resources\CommentCollection;
use App\Versions\V1\Http\Resources\CommentResource;
use App\Versions\V1\Services\CommentService;
use App\Versions\V1\Traits\IdentifiesModels;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentController extends Controller
{
    use IdentifiesModels;

    /**
     * @throws Exception
     */
    public function index(string $model, int $id)
    {
        $model = $this->identifyModel($model, $id);
        $comments = $model->comments()->get();

        return new CommentCollection($comments);
    }

    /**
     * @throws UnknownProperties
     * @throws Exception
     */
    public function store(CommentRequest $request, string $model, int $id): CommentResource
    {
        $model = $this->identifyModel($model, $id);
        $comment = (new CommentService())->create($model, Auth::user(), CommentDto::fromRequest($request));

        return new CommentResource($comment);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(
        Comment $comment,
        CommentRequest $request,
        CommentService $commentService
    ) {
        $commentService->update($comment, CommentDto::fromRequest($request));
    }

    public function destroy(Comment $comment, CommentService $commentService)
    {
        $commentService->delete($comment);
    }
}
