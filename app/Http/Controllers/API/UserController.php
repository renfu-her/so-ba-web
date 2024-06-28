<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    // 最高管理者
    public function adminUsers()
    {
        $users = User::where('admin_enabled', 1)->get();
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }
        return response()->json(['message' => 'Get Admin users success', 'data' => $users]);
    }

    // 一般管理者
    public function users()
    {
        $users = User::where('admin_enabled', 0)->get();
        if ($users->isEmpty()) {
            return response()->json(['message' => 'No users found'], 404);
        }
        return response()->json(['message' => 'Get Users success', 'data' => $users]);
    }
}
