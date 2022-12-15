<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Laravel\Sanctum\Sanctum;
use App\Models\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setupAuth()
    {
        Sanctum::actingAs(User::factory()->create());
    }

    protected function testUnauthorised(
        $type,
        $url,
        $params = []
    ) {
        $this->json($type, $url, $params)
            ->assertUnauthorized()
            ->assertJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    protected function getInvalidId()
    {
        return 9999;
    }
}
