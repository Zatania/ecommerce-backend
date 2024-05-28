<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return Admin::all();
    }

    public function show($id)
    {
        return Admin::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:admins',
            'password' => 'required|string|min:8',
            'email' => 'required|string|email|max:100|unique:admins',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
        ]);

        $admin = new Admin($validated);
        $admin->password = Hash::make($request->password);
        $admin->save();

        return $admin;
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'username' => 'sometimes|required|string|max:50|unique:admins,username,' . $id . ',AdminID',
            'password' => 'sometimes|required|string|min:8',
            'email' => 'sometimes|required|string|email|max:100|unique:admins,email,' . $id . ',AdminID',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
        ]);

        if ($request->has('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->update($validated);

        return $admin;
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return response()->noContent();
    }
}
