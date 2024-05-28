<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Log;

class LogController extends Controller
{
    public function index()
    {
        return Log::all();
    }

    public function show($id)
    {
        return Log::findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'AdminID' => 'required|exists:admins,AdminID',
            'action' => 'required|string',
        ]);

        return Log::create($validated);
    }

    public function update(Request $request, $id)
    {
        $log = Log::findOrFail($id);

        $validated = $request->validate([
            'AdminID' => 'sometimes|required|exists:admins,AdminID',
            'action' => 'sometimes|required|string',
        ]);

        $log->update($validated);

        return $log;
    }

    public function destroy($id)
    {
        $log = Log::findOrFail($id);
        $log->delete();

        return response()->noContent();
    }
}
