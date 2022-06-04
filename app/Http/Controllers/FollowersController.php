<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowersController extends Controller
{
    public function view(Request $request, User $user)
    {
        if ($request->get('following')) {
            return response()->json($user->following()->get());
        }
        return response()->json($user->followers()->get());
    }

    public function store(Request $request)
    {
        $follower = new Follower;
        $follower->user_id = $request->post('user_id');
        $follower->follower_id = Auth::id();
        $follower->save();

        return response()->json($follower, 201);
    }

    public function delete(User $user, User $follower)
    {
        $user->followers()->detach($follower);

        return response()->json(null, 204);
    }
}
