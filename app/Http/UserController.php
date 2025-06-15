<?php

namespace App\Http;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()->get();

        return response()->json(['data' => $users]);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::query()->create($request->all());

        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        $user->update($request->all());

        return response()->json($user);
    }

    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => "User deleted successfully"], 204);
    }
}
