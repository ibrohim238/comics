<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Manga;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class MangaBookmarksTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function testIndexOk()
    {
        $mangas = Manga::factory()->count(3)->create();

        $this->user->mangas()->sync($mangas->pluck('id'));

        $response = $this
            ->actingAs($this->user)
            ->getJson(route('bookmarks.index-manga', 'manga'));

        $response
            ->assertOk()
            ->assertJsonFragment(
                (new MangaCollection($mangas))->response()->getData(true)
            );
    }

    public function testIndexUnauthorized()
    {
        $response = $this
            ->getJson(route('bookmarks.index-manga', 'manga'));

        $response->assertUnauthorized();
    }

    public function testAttachOk()
    {
        $manga = Manga::factory()->create();

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('bookmark.created')
            ]);
    }

    public function testAttachBusy()
    {
        $manga = Manga::factory()->create();

        $this
            ->actingAs($this->user)
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]));

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]));

        $response
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('bookmark.unique')
            ]);
    }

    public function testAttachUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]));

        $response
            ->assertUnauthorized();
    }

    public function testDetachOk()
    {
        $manga = Manga::factory()->create();

        $this
            ->actingAs($this->user)
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]));

        $response = $this
            ->actingAs($this->user)
            ->deleteJson(route('bookmarks.detach', [getMorphedType($manga::class), $manga->id]));

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('bookmark.deleted')
            ]);
    }

    public function testDetachBusy()
    {
        $manga = Manga::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('bookmarks.detach', [getMorphedType($manga::class), $manga->id]));

        $response
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('bookmark.notFound')
            ]);
    }

    public function testDetachUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this->deleteJson(route('bookmarks.detach', [getMorphedType($manga::class), $manga->id]));

        $response->assertUnauthorized();
    }
}
