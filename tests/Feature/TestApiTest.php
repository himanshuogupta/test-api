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

    public function test_get_echo_endpoint_returns_success(): void
    {
        $response = $this->getJson('/api/echo?q=hello');

        $response->assertOk()
            ->assertJson([
                'message' => 'GET echo endpoint is working',
                'method' => 'GET',
                'query' => ['q' => 'hello'],
            ]);
    }

    public function test_post_echo_endpoint_returns_created(): void
    {
        $response = $this->postJson('/api/echo', [
            'value' => 'repeat this',
        ]);

        $response->assertCreated()
            ->assertJson([
                'message' => 'POST echo endpoint is working',
                'method' => 'POST',
                'echo' => 'repeat this',
            ]);
    }

    public function test_get_ping_endpoint_returns_success(): void
    {
        $response = $this->getJson('/api/ping');

        $response->assertOk()
            ->assertJson([
                'message' => 'GET ping endpoint is working',
                'method' => 'GET',
                'pong' => true,
            ]);
    }

    public function test_post_ping_endpoint_returns_created(): void
    {
        $payload = [
            'id' => 42,
            'note' => 'check ping',
        ];

        $response = $this->postJson('/api/ping', $payload);

        $response->assertCreated()
            ->assertJson([
                'message' => 'POST ping endpoint is working',
                'method' => 'POST',
                'data' => $payload,
            ]);
    }
}
