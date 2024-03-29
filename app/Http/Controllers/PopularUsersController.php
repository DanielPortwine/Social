<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PopularUsersController extends Controller
{
    public function index(Request $request)
    {
        return User::withCount('followers')
            ->with('followers')
            ->orderByDesc('followers_count')
            ->limit(5 * $request->get('pages', 1))
            ->offset(($request->get('page') - 1) * 5)
            ->get();
    }
}
