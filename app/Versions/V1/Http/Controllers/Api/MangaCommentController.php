<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\Manga;
use App\Versions\V1\Dto\CommentDto;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Requests\Api\CommentRequest;
use App\Versions\V1\Http\Resources\CommentCollection;
use App\Versions\V1\Services\CommentService;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class MangaCommentController extends Controller
{
    public function index(Manga $manga)
    {
        $comments = $manga->comments()->get();

        return new CommentCollection($comments);
    }

    /**
     * @throws UnknownProperties
     */
    public function store(Manga $manga, CommentRequest $request, CommentService $commentService)
    {
        $commentService->create($manga, Auth::user(), CommentDto::fromRequest($request));
    }
}
