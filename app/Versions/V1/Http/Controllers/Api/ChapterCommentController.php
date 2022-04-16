<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\CommentRequest;
use App\Versions\V1\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class ChapterCommentController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function store(
        Chapter $chapter,
        CommentRequest $request,
        CommentService $commentService
    ) {
        $commentService->create($chapter, Auth::user(), CommentDto::fromRequest($request));
    }
}
