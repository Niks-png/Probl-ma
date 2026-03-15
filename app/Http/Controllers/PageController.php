<?php

namespace App\Http\Controllers;

use App\Services\ProductService;

class PageController extends Controller
{

    public function __construct(
        private ProductService $productService,
    ) {
    }


    public function home()
    {
        $products = $this->productService->loadAllProducts();
        $query = request()->query('q', '');
        $shop = request()->query('shop', '');
        $categories = request()->query('categories', []);
        
        // Handle categories as array
        if (is_string($categories)) {
            $categories = [$categories];
        }

        $products = $this->productService->searchProducts($products, $query);
        $products = $this->productService->filterByShop($products, $shop);
        $products = $this->productService->filterByCategories($products, $categories);

        return view('index', [
            'products' => $products,
            'search' => $query,
            'shop' => $shop,
            'categories' => $categories,
        ]);
    }

    public function products()
    {
        $products = $this->productService->loadAllProducts();

        return view('products', ['products' => $products]);
    }
}

