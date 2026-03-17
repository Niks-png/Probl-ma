<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <span class="font-bold text-lg text-gray-700 dark:text-gray-100">PriceFinder</span>
                    </a>
                </div>

                <!-- Search -->
                <form action="{{ route('home') }}" method="GET" class="hidden sm:flex sm:flex-col items-start ms-10 space-y-2" x-data="{ categoriesOpen: false }">
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            class="px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm"
                            name="q"
                            placeholder="Meklēt produktus..."
                            value="{{ request('q') }}"
                            aria-label="Meklēt produktus pēc nosaukuma"
                            autocomplete="off"
                        >
                        <button class="px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700" type="submit" aria-label="Meklēt">
                            Meklēt
                        </button>
                    </div>
                    
                    
                    <div class="flex gap-4 text-sm items-center">
                        <!-- Store Dropdown -->
                        <div class="relative" style="width: 120px;">
                            <select 
                                name="shop" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm appearance-none cursor-pointer bg-white dark:bg-gray-900"
                                onchange="this.form.submit()"
                            >
                                <option value="">Visi veikali</option>
                                <option value="top" {{ request('shop') === 'top' ? 'selected' : '' }}>🔝 Top</option>
                                <option value="max" {{ request('shop') === 'max' ? 'selected' : '' }}>📦 Maxima</option>
                            </select>
                        </div>

                        <!-- Category Dropdown -->
                        <div class="relative">
                            <button 
                                @click="categoriesOpen = !categoriesOpen"
                                type="button"
                                class="px-4 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 flex items-center gap-2"
                            >
                                <span>🛒 Produkti</span>
                                <svg :class="categoriesOpen ? 'rotate-180' : ''" class="fill-current h-4 w-4 transition-transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </button>

                            <!-- Dropdown  -->
                            <div 
                                x-show="categoriesOpen"
                                @click.outside="categoriesOpen = false"
                                x-transition
                                class="absolute left-0 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50"
                            >
                                <div class="p-4">
                                    <h3 class="text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wide mb-3">Kategorijas</h3>
                                    
                                    <div class="space-y-2">
                                        <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                                            <input 
                                                type="checkbox" 
                                                name="categories[]" 
                                                value="dairy"
                                                {{ in_array('dairy', (array)request('categories', [])) ? 'checked' : '' }}
                                                onchange="this.closest('form').submit()"
                                                class="rounded border-gray-300 dark:border-gray-700 cursor-pointer"
                                            >
                                            <span class="text-lg">🥛</span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 flex-1">Piena produkti un olas</span>
                                        </label>

                                        <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                                            <input 
                                                type="checkbox" 
                                                name="categories[]" 
                                                value="vegetables"
                                                {{ in_array('vegetables', (array)request('categories', [])) ? 'checked' : '' }}
                                                onchange="this.closest('form').submit()"
                                                class="rounded border-gray-300 dark:border-gray-700 cursor-pointer"
                                            >
                                            <span class="text-lg">🥗</span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 flex-1">Augļi un dārzeņi</span>
                                        </label>

                                        <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                                            <input 
                                                type="checkbox" 
                                                name="categories[]" 
                                                value="bakery"
                                                {{ in_array('bakery', (array)request('categories', [])) ? 'checked' : '' }}
                                                onchange="this.closest('form').submit()"
                                                class="rounded border-gray-300 dark:border-gray-700 cursor-pointer"
                                            >
                                            <span class="text-lg">🍞</span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 flex-1">Maize un konditorejas iz...</span>
                                        </label>

                                        <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                                            <input 
                                                type="checkbox" 
                                                name="categories[]" 
                                                value="meat"
                                                {{ in_array('meat', (array)request('categories', [])) ? 'checked' : '' }}
                                                onchange="this.closest('form').submit()"
                                                class="rounded border-gray-300 dark:border-gray-700 cursor-pointer"
                                            >
                                            <span class="text-lg">🥩</span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 flex-1">Gaļa, zivis un gatavā kuli...</span>
                                        </label>

                                        <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition">
                                            <input 
                                                type="checkbox" 
                                                name="categories[]" 
                                                value="beverages"
                                                {{ in_array('beverages', (array)request('categories', [])) ? 'checked' : '' }}
                                                onchange="this.closest('form').submit()"
                                                class="rounded border-gray-300 dark:border-gray-700 cursor-pointer"
                                            >
                                            <span class="text-lg">🥤</span>
                                            <span class="text-sm text-gray-700 dark:text-gray-300 flex-1">Dzērieni</span>
                                        </label>
                                    </div>

                                    <!-- Clear Categories -->
                                    @if(request('categories'))
                                        <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                            <button 
                                                type="button"
                                                onclick="document.querySelectorAll('[name=\'categories[]\']').forEach(el => el.checked = false); this.closest('form').submit();"
                                                class="w-full px-3 py-2 text-xs text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition"
                                            >
                                                Notīrīt kategorijas
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                    </div>
                </form>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-100 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-400 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center">
                        <img src="{{ asset('pfp.png') }}" alt="Login" class="w-10 h-10 rounded-full hover:opacity-80 transition-opacity">
                    </a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <!-- Responsive Search -->
            <form action="{{ route('home') }}" method="GET" class="px-4 py-2">
                <input
                    type="text"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md text-sm"
                    name="q"
                    placeholder="Search products..."
                    value="{{ request('q') }}"
                    autocomplete="off"
                >
                <button class="w-full mt-2 px-4 py-2 bg-gray-800 text-white text-sm rounded-md hover:bg-gray-700" type="submit">
                    Search
                </button>
            </form>

            @auth
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-100">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <a href="{{ route('login') }}" class="inline-flex items-center">
                        <img src="{{ asset('pfp.png') }}" alt="Login" class="w-12 h-12 rounded-full hover:opacity-80 transition-opacity">
                    </a>
                </div>
            </div>
        @endauth
    </div>
</nav>