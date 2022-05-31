<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Chapter;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;
use function route;

class ChapterLikeTest extends TestCase
{
    use WithFaker;

    public function testAddOk()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();


        $response = $this->actingAs($user)
            ->postJson(route('likeable.add', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertCreated()
            ->assertSee(Lang::get('likeable.add'));
    }

    public function testAddDelete()
    {
        $user = User::factory()->create();

        $chapter = Chapter::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('likeable.delete', [getMorphedType($chapter::class), $chapter->id]));

        $response->assertNoContent()
            ->assertSee(Lang::get('likeable.delete'));
    }
}
