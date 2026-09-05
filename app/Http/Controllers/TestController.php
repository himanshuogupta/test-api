<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'GET test endpoint is working',
            'method' => $request->method(),
            'query' => $request->query(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        return response()->json([
            'message' => 'POST test endpoint is working',
            'method' => $request->method(),
            'data' => $validated,
        ], 201);
    }

    public function echoGet(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'GET echo endpoint is working',
            'method' => $request->method(),
            'query' => $request->query(),
        ]);
    }

    public function echoPost(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'value' => ['required'],
        ]);

        return response()->json([
            'message' => 'POST echo endpoint is working',
            'method' => $request->method(),
            'echo' => $validated['value'],
        ], 201);
    }

    public function pingGet(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'GET ping endpoint is working',
            'method' => $request->method(),
            'pong' => true,
        ]);
    }

    public function pingPost(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'note' => ['nullable', 'string', 'max:255'],
        ]);

        return response()->json([
            'message' => 'POST ping endpoint is working',
            'method' => $request->method(),
            'data' => $validated,
        ], 201);
    }
}
