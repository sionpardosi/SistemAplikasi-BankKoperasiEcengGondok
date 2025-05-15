<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;

class ShopController extends BaseController
{
    // Menampilkan daftar produk dengan filter
    public function index(Request $request)
    {
        try {
            // Default filter
            $size = $request->query('size', 12);
            $order = $request->query('order', -1);
            $f_brands = $request->query('brands', '');
            $f_categories = $request->query('categories', '');
            $min_price = $request->query('min', 1);
            $max_price = $request->query('max', 10000000); // 10 juta

            // Menentukan kolom dan arah sorting
            $sortOptions = [
                1 => ['created_at', 'DESC'],
                2 => ['created_at', 'ASC'],
                3 => ['sale_price', 'ASC'],
                4 => ['sale_price', 'DESC'],
            ];

            [$o_column, $o_order] = $sortOptions[$order] ?? ['id', 'DESC'];

            // Mengambil daftar brands dan categories
            $brands = Brand::orderBy('name', 'ASC')->get();
            $categories = Category::orderBy('name', 'ASC')->get();

            // Query produk berdasarkan filter
            $products = Product::query()
                ->when($f_brands, function ($query) use ($f_brands) {
                    $brandIds = explode(',', $f_brands);
                    $query->whereIn('brand_id', $brandIds);
                })
                ->when($f_categories, function ($query) use ($f_categories) {
                    $categoryIds = explode(',', $f_categories);
                    $query->whereIn('category_id', $categoryIds);
                })
                ->where(function ($query) use ($min_price, $max_price) {
                    $query->whereBetween('regular_price', [$min_price, $max_price])
                        ->orWhereBetween('sale_price', [$min_price, $max_price]);
                })
                ->orderBy($o_column, $o_order)
                ->paginate($size);

            return $this->sendResponse([
                'products' => $products,
                'filters' => [
                    'size' => $size,
                    'order' => $order,
                    'brands' => $brands,
                    'selected_brands' => $f_brands,
                    'categories' => $categories,
                    'selected_categories' => $f_categories,
                    'min_price' => $min_price,
                    'max_price' => $max_price,
                ]
            ], 'Product list retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve product list', ['error' => $e->getMessage()], 500);
        }
    }

    // Menampilkan detail produk berdasarkan slug
    public function productDetails($product_slug)
    {
        try {
            $product = Product::where('slug', $product_slug)->first();

            if (!$product) {
                return $this->sendError('Product not found', [], 404);
            }

            $relatedProducts = Product::where('slug', '<>', $product_slug)
                ->inRandomOrder()
                ->take(8)
                ->get();

            return $this->sendResponse([
                'product' => $product,
                'related_products' => $relatedProducts,
            ], 'Product details retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve product details', ['error' => $e->getMessage()], 500);
        }
    }
}
