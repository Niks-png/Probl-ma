@extends('layouts.app')
@section('title', $search ? "Search Results for \"$search\"" : 'Home')
@section('content')
    <div class="main-content">
        @if($search)
            <section class="search-results">
                <h1>Search Results for "{{ $search }}"</h1>
                <p class="search-info">Found {{ count($products) }} product(s)</p>
            </section>
        @else
            <section class="hero">
                <h1>Welcome to Price Finder</h1>
                <p class="lead">Find the best prices on your favorite products</p>
            </section>
        @endif
        
        <section class="products-section">
            <div class="products-grid">
                @forelse($products as $product)
                    <article class="product-card {{ $product['store_class'] }}">
                        <div class="product-store-badge" aria-label="Store name">
                            {{ $product['store'] }}
                        </div>
                        
                        <div class="product-image-placeholder" aria-hidden="true">
                            📦
                        </div>
                        
                        <div class="product-info">
                            <h2 class="product-title">{{ Str::limit($product['title'], 60) }}</h2>
                            
                            <div class="product-prices">
                                @if($product['original_price'] !== 'N/A')
                                    <span class="original-price" aria-label="Original price">
                                        {{ $product['original_price'] }}€
                                    </span>
                                @endif
                                <span class="current-price" aria-label="Current price">
                                    {{ $product['current_price'] }}€
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="no-products">
                        <p>{{ $search ? 'No products found. Try a different search.' : 'No products found. Please run the scrapers first.' }}</p>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection