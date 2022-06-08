<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function view(User $user, Request $request)
    {
        $user->loadCount(['posts', 'followers', 'following'])->load(['posts' => function ($query) use ($request) {
            $query->with(['user', 'reactions', 'reports', 'comments'])
                ->whereNull('parent_id')
                ->limit(10)
                ->offset(($request->get('page') -1) * 10)
                ->orderByDesc('created_at');
        }, 'followers', 'following']);

        return response()->json($user);
    }
}
