<?php

namespace App\Versions\V1\Http\Controllers\Api;

use App\Versions\V1\Http\Controllers\Controller;
use App\Http\Resources\MangaResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarksController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $bookmarks = $user?->bookmarks()->get();
        dd($bookmarks);
    }
}
