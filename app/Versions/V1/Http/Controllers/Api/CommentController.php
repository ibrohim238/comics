<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentController extends Controller
{
    use IdentifiesModels;

    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }

    /**
     * @throws Exception
     */
    public function index(string $model, int $id, Request $request)
    {
        $model = $this->identifyModel($model, $id);

        /* @var Manga|Chapter $model*/
        $comments = $model->comments()->with('user', 'likes')
            ->paginate($request->get('count'));

        return new CommentCollection($comments);
    }

    /**
     * @throws UnknownProperties
     * @throws Exception
     */
    public function store(CommentRequest $request, string $model, int $id, CommentService $service): CommentResource
    {
        $model = $this->identifyModel($model, $id);
        $comment = $service->create($model, Auth::user(), CommentDto::fromRequest($request));

        return new CommentResource($comment);
    }

    /**
     * @throws UnknownProperties
     */
    public function update(
        Comment $comment,
        CommentRequest $request,
        CommentService $service
    ) {
        $service->update($comment, CommentDto::fromRequest($request));
    }

    public function destroy(Comment $comment, CommentService $service)
    {
        $service->delete($comment);
    }
}
