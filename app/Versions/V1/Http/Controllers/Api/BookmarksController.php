<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Enums\BookmarkableTypeEnum;
use App\Exceptions\BookmarksException;
use App\Models\User;
use App\Versions\V1\Http\Controllers\Controller;
use App\Versions\V1\Http\Resources\MangaCollection;
use App\Versions\V1\Repositories\UserRepository;
use App\Versions\V1\Services\BookmarkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use function app;
use function response;

class BookmarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function indexManga(Request $request): MangaCollection
    {
        $user = Auth::user();

        /** @var User $user */
        $bookmarks = app(UserRepository::class, [
           'user' => $user
        ])->paginateManga($request->get('count'));

        return new MangaCollection($bookmarks);
    }

    public function attach(BookmarkableTypeEnum $model, int $id): JsonResponse
    {
        $user = Auth::user();

        try {
            app(BookmarkService::class, [
                'bookmarkable' => $model->identify($id),
                'user' => $user,
            ])->attach();
        } catch (BookmarksException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => Lang::get('bookmark.created')]);
    }

    public function detach(BookmarkableTypeEnum $model, int $id): JsonResponse
    {
        $user = Auth::user();

        try {
            app(BookmarkService::class, [
                'bookmarkable' => $model->identify($id),
                'user' => $user
            ])->detach();
        } catch (BookmarksException $exception) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['message' => Lang::get('bookmark.deleted')]);
    }
}
