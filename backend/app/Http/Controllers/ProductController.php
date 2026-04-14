<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /api/products
     * List products with optional filtering, searching, and sorting.
     *
     * Query params:
     *   ?search=   - search by name, brand, sku
     *   ?category= - filter by category slug or name
     *   ?sort=     - price_asc | price_desc | rating | featured (default)
     *   ?max_price= - maximum price filter
     *   ?per_page= - items per page (default 20)
     */
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->active();

        // Search
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($category = $request->query('category')) {
            if (strtolower($category) !== 'all') {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category)
                      ->orWhere('name', $category);
                });
            }
        }

        // Price filter
        if ($maxPrice = $request->query('max_price')) {
            $query->where('price', '<=', (float) $maxPrice);
        }

        // Sorting
        switch ($request->query('sort', 'featured')) {
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderByDesc('price');
                break;
            case 'rating':
                $query->orderByDesc('rating');
                break;
            default:
                $query->orderByDesc('reviews')->orderByDesc('rating');
                break;
        }

        $perPage = min((int) $request->query('per_page', 20), 100);
        $products = $query->paginate($perPage);

        return response()->json($products);
    }

    /**
     * GET /api/products/{id}
     * Get a single product by ID (or slug).
     */
    public function show(string $idOrSlug)
    {
        $product = is_numeric($idOrSlug)
            ? Product::with('category')->active()->findOrFail($idOrSlug)
            : Product::with('category')->active()->where('slug', $idOrSlug)->firstOrFail();

        return response()->json($product);
    }
}
