<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\Api\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::get('/posts', function (Request $request) {
    $q = $request->query('q');
    $query = Post::with('user')->latest();
    if ($q) {
        $query->where('title', 'like', "%{$q}%")->orWhere('excerpt', 'like', "%{$q}%");
    }
    return $query->paginate(10);
});

Route::get('/posts/{post}', function (Post $post) {
    return $post->load('user');
});

// Protected endpoints for creating/updating/deleting posts (example)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts', function (Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
        ]);
        $data['user_id'] = $request->user()->id;
        $post = Post::create($data);
        return response()->json($post, 201);
    });

    Route::put('/posts/{post}', function (Request $request, Post $post) {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
        ]);
        $post->update($data);
        return response()->json($post);
    });

    Route::delete('/posts/{post}', function (Request $request, Post $post) {
        if ($post->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $post->delete();
        return response()->json(null, 204);
    });
});
