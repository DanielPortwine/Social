<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlocksController extends Controller
{
    public function view(Request $request, User $user)
    {
        if ($request->get('blocked_by')) {
            return response()->json($user->blocked_by()->get());
        }

        return response()->json($user->blocks()->get());
    }

    public function store(Request $request)
    {
        $block = new Block;
        $block->user_id = $request->post('user_id');
        $block->blocker_id = Auth::id();
        $block->save();

        return response()->json($block, 201);
    }

    public function delete(User $user, User $blocker)
    {
        $user->blocks()->detach($blocker);

        return response()->json(null, 204);
    }
}
