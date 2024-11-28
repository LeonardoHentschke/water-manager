<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('user')->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'value' => 'required|max:255',
            'vendor_id' => 'required|max:255',
            'product_id' => 'required|max:255',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
        ]);

        $post = $request->user()->posts()->create($fields);

        return ['post' => $post, 'user' => $post->user];
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return ['post' => $post, 'user' => $post->user];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);

        $fields = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'value' => 'required|max:255',
            'vendor_id' => 'required|max:255',
            'product_id' => 'required|max:255',
            'latitude' => 'required|max:255',
            'longitude' => 'required|max:255',
        ]);

        $post->update($fields);

        return ['post' => $post, 'user' => $post->user];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);

        $post->delete();

        return ['message' => 'A postagem foi excluída'];
    }
}