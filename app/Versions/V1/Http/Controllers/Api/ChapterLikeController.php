<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Versions\V1\Services\LikeService;
use Illuminate\Support\Facades\Auth;

class ChapterLikeController
{
    public function add(Chapter $chapter)
    {
        app(LikeService::class, [
            'chapter' => $chapter,
            'user' => Auth::user()
        ])->add();
    }

    public function delete(Chapter $chapter)
    {
        app(LikeService::class, [
            'chapter' => $chapter,
            'user' => Auth::user()
        ])->delete();
    }
}
