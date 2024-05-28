<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function show($id)
    {
        return Order::with('orderItems')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'UserID' => 'required|exists:users,UserID',
            'status' => 'required|string|max:50',
            'total_amount' => 'required|numeric|min:0',
        ]);

        return Order::create($validated);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|required|string|max:50',
            'total_amount' => 'sometimes|required|numeric|min:0',
        ]);

        $order->update($validated);

        return $order;
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->noContent();
    }
}
