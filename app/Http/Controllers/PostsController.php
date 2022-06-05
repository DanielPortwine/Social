<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        $following = Auth::user()->following()->pluck('id')->toArray();

        return Post::with(['user', 'reactions', 'reports'])
            ->whereIn('user_id', $following)
            ->orWhere('user_id', Auth::id())
            ->limit(10)
            ->offset(($request->get('page') -1) * 10)
            ->orderByDesc('created_at')
            ->get();
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
