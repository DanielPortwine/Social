<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BansController extends Controller
{
    public function view(Request $request, User $user)
    {
        if ($request->get('issued')) {
            return response()->json($user->issued_bans()->get());
        }

        return response()->json($user->bans()->get());
    }

    public function store(Request $request)
    {
        $ban = new Ban;
        $ban->user_id = $request->post('user_id');
        $ban->banner_id = Auth::id();
        $ban->reason = $request->post('reason');
        $ban->duration = $request->post('duration');
        $ban->end = date('Y-m-d H:i:s', strtotime('+'.$request->post('duration')));
        $ban->save();

        return response()->json($ban, 201);
    }

    public function delete(Ban $ban)
    {
        $ban->delete();

        return response()->json(null, 204);
    }
}
