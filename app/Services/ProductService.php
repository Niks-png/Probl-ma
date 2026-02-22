<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ProductService
{

    private const STORES = [
        'max' => [
            'name' => 'MAXIMA',
            'file' => 'max_products.csv',
            'class' => 'max',
        ],
        'top' => [
            'name' => 'eTOP',
            'file' => 'top_products.csv',
            'class' => 'top',
        ],
    ];


    public function loadAllProducts(): Collection
    {
        $products = collect();

        foreach (self::STORES as $store) {
            $products = $products->merge($this->loadProductsFromStore($store));
        }

        return $products;
    }

    private function loadProductsFromStore(array $store): Collection
    {
        $filePath = public_path($store['file']);
        $products = collect();

        if (!file_exists($filePath)) {
            return $products;
        }

        $rows = array_map('str_getcsv', file($filePath));
        array_shift($rows);

        foreach ($rows as $row) {
            if ($this->isValidRow($row)) {
                $products->push([
                    'title' => $row[0],
                    'original_price' => $row[1],
                    'current_price' => $row[2],
                    'store' => $store['name'],
                    'store_class' => $store['class'],
                ]);
            }
        }

        return $products;
    }


    private function isValidRow(array $row): bool
    {
        return count($row) >= 3 && !empty($row[0]);
    }


    public function searchProducts(Collection $products, string $query): Collection
    {
        if (empty($query)) {
            return $products;
        }

        return $products->filter(function ($product) use ($query) {
            return stripos($product['title'], $query) !== false;
        });
    }
}
