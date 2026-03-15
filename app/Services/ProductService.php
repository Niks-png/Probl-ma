<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ProductService
{

    private const STORES = [
        'max' => [
            'name' => 'max.png',
            'file' => 'max_products.csv',
            'class' => 'max',
        ],
        'top' => [
            'name' => 'top.png',
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
                    'category' => $this->detectCategory($row[0]),
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

    public function filterByShop(Collection $products, string $shop): Collection
    {
        if (empty($shop) || !in_array($shop, ['top', 'max'])) {
            return $products;
        }

        return $products->filter(function ($product) use ($shop) {
            return $product['store_class'] === $shop;
        });
    }

    public function filterByCategory(Collection $products, string $category): Collection
    {
        if (empty($category) || !in_array($category, ['dairy', 'meat', 'vegetables', 'bakery', 'beverages'])) {
            return $products;
        }

        return $products->filter(function ($product) use ($category) {
            return $product['category'] === $category;
        });
    }

    public function filterByCategories(Collection $products, array $categories): Collection
    {
        if (empty($categories)) {
            return $products;
        }

        $validCategories = ['dairy', 'meat', 'vegetables', 'bakery', 'beverages'];
        $categories = array_filter($categories, function ($cat) use ($validCategories) {
            return in_array($cat, $validCategories);
        });

        if (empty($categories)) {
            return $products;
        }

        return $products->filter(function ($product) use ($categories) {
            return in_array($product['category'], $categories);
        });
    }

    private function detectCategory(string $title): string
    {
        $title = strtolower($title);


        if (preg_match('/\b(piens|sviests|siers|jogurts|kefīrs|pudums|krējums|pienoteka)\b/i', $title)) {
            return 'dairy';
        }

   
        if (preg_match('/\b(gaļa|liellopu|cūka|vistas|zivs|makss|desas|paštetā|bļoda)\b/i', $title)) {
            return 'meat';
        }

  
        if (preg_match('/\b(tomāts|dekāniju|kartupeli|dārzeni|salāti|gurķi|kāposti|burkāns|pētersīļi)\b/i', $title)) {
            return 'vegetables';
        }

  
        if (preg_match('/\b(maize|kliņģeris|pīrāgs|biskvīts|maizīte|bulka|rupjmaize|rauga)\b/i', $title)) {
            return 'bakery';
        }


        if (preg_match('/\b(dzēriens|ūdens|sulas|sula|kafija|tēja|alus|vīns|konjaks|dzāriens)\b/i', $title)) {
            return 'beverages';
        }

        return 'other';
    }
}
