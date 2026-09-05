<?php

namespace Tests\Feature;

use Tests\TestCase;

class TestApiTest extends TestCase
{
    public function test_get_test_endpoint_returns_success(): void
    {
        $response = $this->getJson('/api/test?foo=bar');

        $response->assertOk()
            ->assertJson([
                'message' => 'GET test endpoint is working',
                'method' => 'GET',
                'query' => ['foo' => 'bar'],
            ]);
    }

    public function test_post_test_endpoint_returns_created(): void
    {
        $payload = [
            'name' => 'Himanshu',
            'message' => 'Hello from POST',
        ];

        $response = $this->postJson('/api/test', $payload);

        $response->assertCreated()
            ->assertJson([
                'message' => 'POST test endpoint is working',
                'method' => 'POST',
                'data' => $payload,
            ]);
    }

    public function test_post_test_endpoint_requires_name(): void
    {
        $response = $this->postJson('/api/test', [
            'message' => 'Missing name',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
