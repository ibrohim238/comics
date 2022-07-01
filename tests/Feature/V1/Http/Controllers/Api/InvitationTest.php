<?php

namespace Tests\Feature\V1\Http\Controllers\Api;

use App\Models\User;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();

    }
}
