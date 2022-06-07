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

        return Post::withCount('comments')
            ->with(['user', 'reactions', 'reports'])
            ->where(function($q) use ($following) {
                $q->whereIn('user_id', $following)
                    ->orWhere('user_id', Auth::id());
            })
            ->whereNull('parent_id')
            ->limit(10)
            ->offset(($request->get('page') -1) * 10)
            ->orderByDesc('created_at')
            ->get();
    }

    public function view(Post $post, Request $request)
    {
        $post->loadCount('comments')->load(['user', 'reactions', 'reports', 'comments' => function($q) use ($request) {
            $q->withCount('comments')
                ->with(['user', 'reactions', 'reports', 'comments'])
                ->limit(10)
                ->offset(($request->get('page') -1) * 10)
                ->orderByDesc('created_at');
        }]);

        return $post;
    }

    public function store(Request $request)
    {
        $post = new Post;
        $post->user_id = Auth::id();
        $post->parent_id = $request->post('parent_id');
        $post->content = $request->post('content');
        $post->save();

        $post->load(['user', 'reactions', 'reports']);

//        $post = Post::with(['user', 'reactions', 'reports'])->where('id', $post->id)->first();

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

        return response()->json($post, 204);
    }

    public function restore(Post $post)
    {
        if (Auth::id() !== $post->user_id) {
            return response()->json(null, 404);
        }

        $post->restore();

        return response()->json($post, 204);
    }
}
