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

        $products = $this->productService->searchProducts($products, $query);

        return view('index', [
            'products' => $products,
            'search' => $query,
        ]);
    }

    public function products()
    {
        $products = $this->productService->loadAllProducts();

        return view('products', ['products' => $products]);
    }
}

