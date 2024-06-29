<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $adminUsers = User::where('admin_enabled', 1)->paginate(20);
        return response()->json([
            'message' => 'Get Admin Users success',
            'data' => $adminUsers
        ]);
    }

    public function show($id)
    {
        $adminUser = User::where('id', $id)->where('admin_enabled', 1)->firstOrFail();
        return response()->json($adminUser);
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
        $validatedData['admin_enabled'] = 1;
        $validatedData['enabled'] = 1;
        $validatedData['type'] = 1;

        $adminUser = User::create($validatedData);

        return response()->json($adminUser, 201);
    }

    public function update(Request $request, $id)
    {
        $adminUser = User::where('id', $id)->where('admin_enabled', 1)->firstOrFail();

        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'username' => 'string|max:255',
            'password' => 'string|min:8',
            'enabled' => 'boolean',
            'admin_enabled' => 'boolean',
        ]);

        if ($request->has('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if($validatedData['admin_enabled']){
            $validatedData['type'] = $validatedData['admin_enabled'];
        }

        $adminUser->update($validatedData);

        return response()->json($adminUser, 200);
    }

    public function destroy($id)
    {
        $adminUser = User::where('id', $id)->where('admin_enabled', 1)->firstOrFail();
        $adminUser->delete();
        return response()->json(null, 204);
    }
}
