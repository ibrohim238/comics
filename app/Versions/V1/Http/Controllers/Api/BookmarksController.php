<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Exceptions\BookmarksException;
use App\Models\Manga;
use App\Versions\V1\Http\Controllers\Controller;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Repository\MangaRepository;
use App\Versions\V1\Services\BookmarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;

class BookmarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(string $model, Request $request)
    {
        $user = Auth::user();

        /** @var User $user */
        $bookmarks = app(MangaRepository::class, [
           'manga' => $user->mangas()->where('bookmarkable_type', $model)
        ])->paginate($request->get('count'));

        return new MangaCollection($bookmarks);
    }

    public function attach(string $model, int $id)
    {
        $user = Auth::user();

        try {
            app(BookmarkService::class, [
                'bookmarkable' => identifyModel($model, $id),
                'user' => $user
            ])->add();
        } catch (BookmarksException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => Lang::get('bookmark.created')]);
    }

    public function detach(string $model, int $id)
    {
        $user = Auth::user();

        try {
            app(BookmarkService::class, [
                'bookmarkable' => identifyModel($model, $id),
                'user' => $user
            ])->delete();
        } catch (BookmarksException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => Lang::get('bookmark.deleted')]);
    }
}
