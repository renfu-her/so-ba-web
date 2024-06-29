<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('admin_enabled', 0)->paginate(20);
        return response()->json([
            'message' => 'Get Users success',
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::where('id', $id)->where('admin_enabled', 0)->firstOrFail();
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'enabled' => 'required|boolean',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['admin_enabled'] = 0;
        $validatedData['enabled'] = 1;
        $validatedData['type'] = 0;

        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->where('admin_enabled', 0)->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'username' => 'string|max:255', $id,
            'password' => 'string|min:8',
            'enabled' => 'boolean',
            'admin_enabled' => 'boolean',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if ($validatedData['admin_enabled']) {
            $validatedData['type'] = $validatedData['admin_enabled'];
        }

        $user->update($validatedData);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)->where('admin_enabled', 0)->firstOrFail();
        $user->delete();
        return response()->json(null, 204);
    }
}
