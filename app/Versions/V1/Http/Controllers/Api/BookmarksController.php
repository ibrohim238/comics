<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Exceptions\BookmarksException;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Services\BookmarkService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class BookmarksController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $bookmarks = $user?->bookmarks()->get();

        return new MangaCollection($bookmarks);
    }

    public function attach(Manga $manga)
    {
        try {
            app(BookmarkService::class, [
                'manga' => $manga,
                'user' => Auth::user()
            ])->add();
        } catch (BookmarksException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => Lang::get('bookmark.created')]);
    }

    public function detach(Manga $manga)
    {
        try {
            app(BookmarkService::class, [
                'manga' => $manga,
                'user' => Auth::user()
            ])->delete();
        } catch (BookmarksException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => Lang::get('bookmark.deleted')]);
    }
}
