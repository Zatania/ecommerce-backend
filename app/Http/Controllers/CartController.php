<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->UserID;

        if (!$userId) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $cart = Cart::with('items.product')->where('UserID', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        unset($cart['created_at']);
        unset($cart['updated_at']);

        foreach ($cart['items'] as &$item) {
            unset($item['created_at']);
            unset($item['updated_at']);

            unset($item['product']->created_at);
            unset($item['product']->updated_at);
        }

        return $cart;
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'ProductID' => 'required|exists:products,ProductID',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->UserID;
        $cart = Cart::firstOrCreate(['UserID' => $userId]);
        $product = Product::findOrFail($request->ProductID);

        $cartItem = CartItem::where('CartID', $cart->CartID)
                            ->where('ProductID', $product->ProductID)
                            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);

            return response()->json(['message' => 'Product quantity updated'], 200);
        } else {
            $cartItem = CartItem::create([
                'CartID' => $cart->CartID,
                'ProductID' => $product->ProductID,
                'quantity' => $request->quantity
            ]);

            return response()->json(['message' => 'Product added to cart'], 200);
        }
    }


    public function removeFromCart(Request $request, $id)
    {
        $userId = $request->user()->UserID;

        if (!$userId) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $cart = Cart::where('UserID', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cartItem = CartItem::where('CartID', $cart->CartID)->where('ProductID', $id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Product not found in cart'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart'], 200);
    }

    public function updateCartItem(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = $request->user()->UserID;

        if (!$userId) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $cart = Cart::where('UserID', $userId)->first();

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $cartItem = CartItem::where('CartID', $cart->CartID)->where('ProductID', $id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Product not found in cart'], 404);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['message' => 'Product quantity updated'], 200);
    }

    public function clearCart(Request $request)
    {
        $userId = $request->user()->UserID;
        $cart = Cart::where('UserID', $userId)->firstOrFail();

        $cart->items()->delete();

        return response()->json(['message' => 'Cart cleared'], 200);
    }
}
