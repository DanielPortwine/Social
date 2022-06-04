<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionsController extends Controller
{
    public function view(Post $post)
    {
        return response()->json($post->reactions()->get());
    }

    public function store(Request $request)
    {
        $reaction = new Reaction;
        $reaction->post_id = $request->post('post_id');
        $reaction->user_id = Auth::id();
        $reaction->reaction = $request->post('reaction');
        $reaction->save();

        return response()->json($reaction, 201);
    }

    public function delete(Reaction $reaction)
    {
        $reaction->delete();

        return response()->json(null, 204);
    }
}
