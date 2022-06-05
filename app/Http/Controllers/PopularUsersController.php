<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PopularUsersController extends Controller
{
    public function index(Request $request)
    {
        return User::withCount('followers')
            ->orderByDesc('followers_count')
            ->limit(5)
            ->offset(($request->get('page') - 1) * 5)
            ->get();
    }
}
