<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Enums\BookmarkTypeEnum;
use App\Models\Manga;
use App\Models\User;
use App\Versions\V1\Http\Resources\MangaCollection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use function route;

class MangaBookmarkTest extends TestCase
{
    use WithFaker;

    private int $type;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->type = $this->faker->randomElement(BookmarkTypeEnum::values());
    }

    public function testIndexOk()
    {
        $mangas = Manga::factory()->count(3)->create();

        $pluck = $mangas->pluck('id')
            ->mapWithKeys(function (int $id) {
                return [
                    $id => [
                        'type' => $this->type,
                    ]
                ];
            });
        $this->user->mangas()->sync($pluck);

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
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type
            ]);

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
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type
            ]);

        $response = $this
            ->actingAs($this->user)
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type
            ]);

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
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type
            ]);

        $response
            ->assertUnauthorized();
    }

    public function testDetachOk()
    {
        $manga = Manga::factory()->create();

        $this
            ->actingAs($this->user)
            ->postJson(route('bookmarks.attach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type,
            ]);

        $response = $this
            ->actingAs($this->user)
            ->deleteJson(route('bookmarks.detach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type
            ]);

        $response->assertOk()
            ->assertJsonFragment([
                'message' => Lang::get('bookmark.deleted')
            ]);
    }

    public function testDetachBusy()
    {
        $manga = Manga::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('bookmarks.detach', [getMorphedType($manga::class), $manga->id]), [
                'type' => $this->type
            ]);

        $response
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJsonFragment([
                'message' => Lang::get('bookmark.notFound')
            ]);
    }

    public function testDetachUnauthorized()
    {
        $manga = Manga::factory()->create();

        $response = $this->deleteJson(route('bookmarks.detach', [getMorphedType($manga::class), $manga->id]), [
            'type' => $this->type
        ]);

        $response->assertUnauthorized();
    }
}
