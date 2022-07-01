<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\User;
use App\Versions\V1\Http\Resources\CouponCollection;
use App\Versions\V1\Http\Resources\CouponResource;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CouponTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->user = User::factory()->create();

        $this->user->assignRole('owner');
    }

    public function testIndexOk()
    {
        $coupons = Coupon::factory()->count(5)->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('coupon.index'));

        $response->assertOk()
            ->assertJsonFragment(
                (new CouponCollection($coupons))->response()->getData(true)
            );
    }

    public function testIndexUnauthorized()
    {
        $response = $this->getJson(route('coupon.index'));

        $response->assertUnauthorized();
    }

    public function testIndexForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('coupon.index'));

        $response->assertForbidden();
    }

    public function testShowOk()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($this->user)
            ->getJson(route('coupon.show', $coupon));

        $response->assertOk()
            ->assertJsonFragment(
                (new CouponResource($coupon))->response()->getData(true)
            );
    }

    public function testShowUnauthorized()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->getJson(route('coupon.show', $coupon));

        $response->assertUnauthorized();
    }

    public function testShowForbidden()
    {
        $coupon = Coupon::factory()->create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('coupon.show', $coupon));

        $response->assertForbidden();
    }

    public function testShowNotFound()
    {
        $response = $this->actingAs($this->user)
            ->getJson(route('coupon.show', 'n'));

        $response->assertNotFound();
    }

    public function testStoreOk()
    {
        $response = $this->actingAs($this->user)
            ->postJson(route('coupon.store'), [
            'code' => $this->faker->name,
        ]);

        $response->assertCreated();
    }

    public function testStoreUnauthorized()
    {
        $response = $this
            ->postJson(route('coupon.store'), [
                'code' => $this->faker->name,
            ]);

        $response->assertUnauthorized();
    }

    public function testStoreForbidden()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('coupon.store'), [
                'code' => $this->faker->name,
            ]);

        $response->assertForbidden();
    }

    public function testUpdateOk()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($this->user)
            ->patchJson(route('coupon.update', $coupon), [
            'code' => $this->faker->name,
        ]);

        $response->assertOk();
    }

    public function testUpdateUnauthorized()
    {
        $coupon = Coupon::factory()->create();

        $response = $this
            ->patchJson(route('coupon.update', $coupon), [
                'code' => $this->faker->name,
            ]);

        $response->assertUnauthorized();
    }

    public function testUpdateForbidden()
    {
        $user = User::factory()->create();
        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($user)
            ->patchJson(route('coupon.update', $coupon), [
                'code' => $this->faker->name,
            ]);

        $response->assertForbidden();
    }

    public function testDeleteOk()
    {
        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($this->user)
            ->deleteJson(route('coupon.destroy', $coupon));

        $response->assertNoContent();
    }

    public function testDeleteUnauthorized()
    {
        $coupon = Coupon::factory()->create();

        $response = $this
            ->deleteJson(route('coupon.destroy', $coupon));

        $response->assertUnauthorized();
    }

    public function testDeleteForbidden()
    {
        $user = User::factory()->create();
        $coupon = Coupon::factory()->create();

        $response = $this->actingAs($user)
            ->deleteJson(route('coupon.destroy', $coupon));

        $response->assertForbidden();
    }
}
