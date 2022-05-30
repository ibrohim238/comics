<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;
use function route;

class BookmarksTest extends TestCase
{
    use WithFaker;

    public function testIndexOk()
    {
        $user = User::factory()->create();

        $mangas = Manga::factory()->count(3)->create();

        foreach ($mangas as $manga) {
            $user->bookmarks()->attach(['manga_id' => $manga->id]);
        }

        $response = $this->actingAs($user)->getJson(route('bookmarks.index'));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new MangaCollection($mangas))->response()->getData(true)
            );
    }

    public function testIndexUnauthorized()
    {
        $response = $this->getJson(route('bookmarks.index'));

        $response->assertUnauthorized();
    }

    public function testAttachOk()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)->postJson(route('bookmarks.attach', $manga));

        $response->assertOk();
    }

    public function testAttachBusy()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $this->actingAs($user)->postJson(route('bookmarks.attach', $manga));

        $response = $this->actingAs($user)->postJson(route('bookmarks.attach', $manga));

        $response
            ->assertOk()
            ->assertSee(Lang::get('bookmark.unique'));
    }

    public function testAttachUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this->postJson(route('bookmarks.attach', $manga));

        $response->assertUnauthorized();
    }

    public function testDetachOk()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $response = $this->actingAs($user)->postJson(route('bookmarks.detach', $manga));

        $response->assertOk();
    }

    public function testDetachBusy()
    {
        $user = User::factory()->create();

        $manga = Manga::factory()->create();

        $this->actingAs($user)->postJson(route('bookmarks.detach', $manga));

        $response = $this->actingAs($user)->postJson(route('bookmarks.detach', $manga));

        $response
            ->assertOk()
            ->assertSee(Lang::get('bookmark.notFound'));
    }

    public function testDetachUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this->postJson(route('bookmarks.detach', $manga));

        $response->assertUnauthorized();
    }
}
