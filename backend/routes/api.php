<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| AutoParts MY — API Routes
|--------------------------------------------------------------------------
|
| All routes are prefixed with /api (configured in bootstrap/app.php).
|
| Public routes  — no authentication required
| Auth routes    — require Sanctum token (Authorization: Bearer <token>)
|
*/

// ─── Public Routes ───────────────────────────────────────────────────────────

/**
 * POST /api/register
 * Create a new user account.
 * Body: { name, email, phone?, password, password_confirmation }
 */
Route::post('/register', [AuthController::class, 'register']);

/**
 * POST /api/login
 * Authenticate and receive a Sanctum token.
 * Body: { email, password }
 */
Route::post('/login', [AuthController::class, 'login']);

/**
 * GET /api/categories
 * List all active part categories.
 */
Route::get('/categories', [CategoryController::class, 'index']);

/**
 * GET /api/products
 * List products with optional filters.
 * Query: ?search=&category=&sort=featured|price_asc|price_desc|rating&max_price=&per_page=
 */
Route::get('/products', [ProductController::class, 'index']);

/**
 * GET /api/products/{id}
 * Get a single product by ID or slug.
 */
Route::get('/products/{id}', [ProductController::class, 'show']);


// ─── Authenticated Routes (Sanctum) ──────────────────────────────────────────

Route::middleware('auth:sanctum')->group(function () {

    // ── Auth / Profile ────────────────────────────────────────────────────────

    /**
     * POST /api/logout
     * Revoke the current Sanctum token.
     */
    Route::post('/logout', [AuthController::class, 'logout']);

    /**
     * GET /api/user
     * Return the authenticated user's profile.
     */
    Route::get('/user', [AuthController::class, 'me']);

    /**
     * PUT /api/user
     * Update name, phone, or password.
     * Body: { name?, phone?, password?, password_confirmation? }
     */
    Route::put('/user', [AuthController::class, 'update']);


    // ── Shopping Cart ─────────────────────────────────────────────────────────

    /**
     * GET /api/cart
     * Return the user's cart with items, totals, and shipping.
     */
    Route::get('/cart', [CartController::class, 'index']);

    /**
     * POST /api/cart/add
     * Add a product to the cart (increments quantity if already present).
     * Body: { product_id, quantity? }
     */
    Route::post('/cart/add', [CartController::class, 'add']);

    /**
     * PUT /api/cart/items/{cartItemId}
     * Update the quantity of a specific cart line.
     * Body: { quantity }  — set to 0 to remove the item.
     */
    Route::put('/cart/items/{cartItemId}', [CartController::class, 'updateItem']);

    /**
     * DELETE /api/cart/items/{cartItemId}
     * Remove a single item from the cart.
     */
    Route::delete('/cart/items/{cartItemId}', [CartController::class, 'removeItem']);

    /**
     * DELETE /api/cart/clear
     * Empty the entire cart.
     */
    Route::delete('/cart/clear', [CartController::class, 'clear']);


    // ── Orders ────────────────────────────────────────────────────────────────

    /**
     * GET /api/orders
     * List all orders for the authenticated user (paginated, newest first).
     */
    Route::get('/orders', [OrderController::class, 'index']);

    /**
     * POST /api/orders
     * Place a new order from the current cart contents.
     * Body: { shipping_name, shipping_phone, shipping_address1, shipping_address2?,
     *         shipping_city, shipping_postcode, shipping_state, delivery_notes?,
     *         payment_method: fpx|card|ewallet|cod }
     */
    Route::post('/orders', [OrderController::class, 'store']);

    /**
     * GET /api/orders/{id}
     * Get a single order with all line items.
     */
    Route::get('/orders/{id}', [OrderController::class, 'show']);
});
