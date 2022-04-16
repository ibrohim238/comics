<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\CommentRequest;
use App\Versions\V1\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaCommentController extends Controller
{
    /**
     * @throws UnknownProperties
     */
    public function store(Manga $manga, CommentRequest $request, CommentService $commentService)
    {
        $commentService->create($manga, Auth::user(), CommentDto::fromRequest($request));
    }
}
