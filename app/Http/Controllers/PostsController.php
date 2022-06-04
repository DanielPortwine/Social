<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        return Post::limit(10)->offset(($request->get('page') -1) * 10)->get();
    }

    public function view(Post $post)
    {
        return $post;
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::id();
        $post->parent_id = $request->post('parent_id');
        $post->content = $request->post('content');
        $post->save();

        return response()->json($post, 201);
    }

    public function update(Post $post, Request $request)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(null, 404);
        }

        $post->content = $request->post('content');
        $post->save();

        return response()->json($post);
    }

    public function delete(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(null, 404);
        }

        $post->delete();

        return response()->json(null, 204);
    }
}
