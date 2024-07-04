<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::orderByDesc('created_at')->paginate(20);
        return response()->json([
            'message' => 'Get Admin Users success',
            'data' => $members
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'required|boolean',
            'mobile' => 'required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'county' => 'nullable|string|max:20',
            'district' => 'nullable|string|max:20',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'memo' => 'nullable|string'
        ]);

        $member = Member::create($validated);

        return response()->json($member, 201);
    }

    public function show($id)
    {
        return Member::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'sex' => 'sometimes|required|boolean',
            'mobile' => 'sometimes|required|string|max:20',
            'phone' => 'nullable|string|max:20',
            'county' => 'nullable|string|max:20',
            'district' => 'nullable|string|max:20',
            'zipcode' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'memo' => 'nullable|string'
            // 添加其他驗證規則
        ]);

        $member->update($validated);

        return response()->json($member, 200);
    }

    public function destroy($id)
    {
        Member::destroy($id);

        return response()->json(null, 204);
    }
}
