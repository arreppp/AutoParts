<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * GET /api/orders
     * List all orders for the authenticated user (newest first).
     */
    public function index(Request $request)
    {
        $orders = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    /**
     * POST /api/orders
     * Place a new order from the user's cart.
     *
     * Body: { shipping_name, shipping_phone, shipping_address1, shipping_address2?,
     *         shipping_city, shipping_postcode, shipping_state, delivery_notes?,
     *         payment_method }
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name'     => 'required|string|max:255',
            'shipping_phone'    => 'required|string|max:20',
            'shipping_address1' => 'required|string|max:255',
            'shipping_address2' => 'nullable|string|max:255',
            'shipping_city'     => 'required|string|max:100',
            'shipping_postcode' => 'required|string|max:10',
            'shipping_state'    => 'required|string|max:100',
            'delivery_notes'    => 'nullable|string|max:500',
            'payment_method'    => 'required|in:fpx,card,ewallet,cod',
        ]);

        $user = $request->user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 422);
        }

        // Validate all cart items are still in stock
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return response()->json([
                    'message' => "Insufficient stock for {$item->product->name}.",
                ], 422);
            }
        }

        $order = DB::transaction(function () use ($cart, $data, $user) {
            $subtotal    = $cart->items->sum(fn ($i) => $i->product->price * $i->quantity);
            $shippingFee = $subtotal >= 200 ? 0.00 : 15.00;
            $tax         = round($subtotal * 0.08, 2);
            $total       = round($subtotal + $shippingFee + $tax, 2);

            $order = Order::create([
                'user_id'           => $user->id,
                'order_number'      => 'ORD-' . strtoupper(uniqid()),
                'status'            => 'Processing',
                'subtotal'          => $subtotal,
                'shipping_fee'      => $shippingFee,
                'tax'               => $tax,
                'total'             => $total,
                'shipping_name'     => $data['shipping_name'],
                'shipping_phone'    => $data['shipping_phone'],
                'shipping_address1' => $data['shipping_address1'],
                'shipping_address2' => $data['shipping_address2'] ?? null,
                'shipping_city'     => $data['shipping_city'],
                'shipping_postcode' => $data['shipping_postcode'],
                'shipping_state'    => $data['shipping_state'],
                'delivery_notes'    => $data['delivery_notes'] ?? null,
                'payment_method'    => $data['payment_method'],
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item->product_id,
                    'product_name'  => $item->product->name,
                    'product_sku'   => $item->product->sku,
                    'product_brand' => $item->product->brand,
                    'product_emoji' => $item->product->emoji,
                    'unit_price'    => $item->product->price,
                    'quantity'      => $item->quantity,
                    'subtotal'      => round($item->product->price * $item->quantity, 2),
                ]);

                // Decrement stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear the cart
            $cart->items()->delete();

            return $order;
        });

        return response()->json([
            'message' => 'Order placed successfully.',
            'order'   => $order->load('items'),
        ], 201);
    }

    /**
     * GET /api/orders/{id}
     * Get a single order by ID (must belong to authenticated user).
     */
    public function show(Request $request, int $id)
    {
        $order = Order::with('items')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json($order);
    }
}
