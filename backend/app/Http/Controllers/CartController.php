<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Resolve or create the user's cart.
     */
    private function getCart(Request $request): Cart
    {
        return Cart::firstOrCreate(['user_id' => $request->user()->id]);
    }

    /**
     * Format cart response consistently.
     */
    private function cartResponse(Cart $cart): array
    {
        $cart->load('items.product.category');

        $items = $cart->items->map(fn ($item) => [
            'id'         => $item->id,
            'product_id' => $item->product_id,
            'qty'        => $item->quantity,
            'name'       => $item->product->name,
            'brand'      => $item->product->brand,
            'emoji'      => $item->product->emoji,
            'price'      => $item->product->price,
            'stock'      => $item->product->stock,
            'subtotal'   => round($item->product->price * $item->quantity, 2),
        ]);

        $subtotal = $items->sum('subtotal');
        $shipping  = $subtotal >= 200 ? 0.00 : 15.00;
        $tax       = round($subtotal * 0.08, 2);
        $total     = round($subtotal + $shipping + $tax, 2);

        return [
            'items'    => $items,
            'count'    => $items->sum('qty'),
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax'      => $tax,
            'total'    => $total,
        ];
    }

    /**
     * GET /api/cart
     * Return the authenticated user's cart.
     */
    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        return response()->json($this->cartResponse($cart));
    }

    /**
     * POST /api/cart/add
     * Add a product to the cart (or increment qty if already present).
     *
     * Body: { product_id, quantity? }
     */
    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity'   => 'sometimes|integer|min:1|max:99',
        ]);

        $product = Product::active()->findOrFail($data['product_id']);

        if ($product->stock < 1) {
            return response()->json(['message' => 'Product is out of stock.'], 422);
        }

        $cart = $this->getCart($request);
        $qty  = $data['quantity'] ?? 1;

        $item = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $product->id)
                        ->first();

        if ($item) {
            $newQty = $item->quantity + $qty;
            $newQty = min($newQty, $product->stock);
            $item->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => min($qty, $product->stock),
            ]);
        }

        return response()->json($this->cartResponse($cart->fresh()));
    }

    /**
     * PUT /api/cart/items/{cartItemId}
     * Update quantity for a specific cart item.
     *
     * Body: { quantity }
     */
    public function updateItem(Request $request, int $cartItemId)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $cart = $this->getCart($request);
        $item = CartItem::where('id', $cartItemId)
                        ->where('cart_id', $cart->id)
                        ->firstOrFail();

        if ($data['quantity'] === 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => min($data['quantity'], $item->product->stock)]);
        }

        return response()->json($this->cartResponse($cart->fresh()));
    }

    /**
     * DELETE /api/cart/items/{cartItemId}
     * Remove a single item from the cart.
     */
    public function removeItem(Request $request, int $cartItemId)
    {
        $cart = $this->getCart($request);
        CartItem::where('id', $cartItemId)
                ->where('cart_id', $cart->id)
                ->firstOrFail()
                ->delete();

        return response()->json($this->cartResponse($cart->fresh()));
    }

    /**
     * DELETE /api/cart/clear
     * Empty the cart entirely.
     */
    public function clear(Request $request)
    {
        $cart = $this->getCart($request);
        $cart->items()->delete();

        return response()->json($this->cartResponse($cart->fresh()));
    }
}
