<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('API Tester')
            ->assertSee('/api/test')
            ->assertSee('/api/echo')
            ->assertSee('/api/ping')
            ->assertSee('GET', false)
            ->assertSee('POST', false);
    }
}
