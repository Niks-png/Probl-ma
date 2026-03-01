@extends('layouts.app')
@section('title', $search ? "Search Results for \"$search\"" : 'Home')
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($search)
            <section class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Search Results for "{{ $search }}"</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Found {{ count($products) }} product(s)</p>
            </section>
        @else
            <section class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">Welcome to Price Finder</h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">Find the best prices on your favorite products</p>
            </section>
        @endif
        
        <section>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                    <article class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow duration-300 overflow-hidden relative cursor-pointer">
                        <img src="{{ asset($product['store']) }}" alt="Store logo" class="absolute top-3 right-3 w-10 h-10 z-10 cursor-pointer" aria-label="Store name">
                        
                        <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center text-6xl">
                            📦
                        </div>
                        
                        <div class="p-4">
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100 mb-3 line-clamp-2">{{ Str::limit($product['title'], 60) }}</h2>
                            
                            <div class="flex items-center gap-2">
                                @if($product['original_price'] !== 'N/A')
                                    <span class="text-xs text-gray-500 dark:text-gray-400 line-through">
                                        {{ $product['original_price'] }}€
                                    </span>
                                @endif
                                <span class="text-base font-bold text-red-600 dark:text-red-500">
                                    {{ $product['current_price'] }}€
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16">
                        <p class="text-gray-500 dark:text-gray-400 text-lg">{{ $search ? 'No products found. Try a different search.' : 'No products found. Please run the scrapers first.' }}</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection