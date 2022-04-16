<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Comment;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\CommentRequest;
use App\Versions\V1\Services\CommentService;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Comment::class);
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
