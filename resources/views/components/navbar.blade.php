{{-- Navigation Bar Component --}}
<nav class="navbar-custom" role="navigation" aria-label="Main navigation">
    <div class="navbar-container">
        <div class="navbar-brand">
            <a href="{{ route('home') }}" class="brand-link">
                <span class="brand-logo" aria-hidden="true"></span>
                <span class="brand-text">PriceFinder</span>
            </a>
        </div>
        
        <form action="{{ route('home') }}" method="GET" class="navbar-search">
            <input
                type="text"
                class="search-input"
                name="q"
                placeholder="Search products..."
                value="{{ request('q') }}"
                aria-label="Search products by title"
                autocomplete="off"
            >
            <button class="search-button" type="submit" aria-label="Search">
                Search
            </button>
        </form>
    </div>
</nav>