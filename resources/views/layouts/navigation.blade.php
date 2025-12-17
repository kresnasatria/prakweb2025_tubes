<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="font-bold text-xl text-blue-600">
                                TOKO LARAVEL
                            </a>
                        @else
                            <a href="{{ route('products.index') }}" class="font-bold text-xl text-blue-600">
                                TOKO LARAVEL
                            </a>
                        @endif
                    @else
                        <a href="{{ route('products.index') }}" class="font-bold text-xl text-blue-600">
                            TOKO LARAVEL
                        </a>
                    @endauth
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            {{-- Admin Navigation --}}
                            <a href="{{ route('admin.dashboard') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.products.index') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.products.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                                Kelola Produk
                            </a>
                            <a href="{{ route('admin.categories.index') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.categories.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                                Kelola Kategori
                            </a>
                            <a href="{{ route('admin.orders.index') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.orders.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                                Kelola Pesanan
                            </a>
                        @else
                            {{-- Customer Navigation --}}
                            <a href="{{ route('products.index') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.index') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                                Katalog Produk
                            </a>
                            <a href="{{ route('orders.index') }}" 
                               class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('orders.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                                Pesanan Saya
                            </a>
                        @endif
                    @else
                        {{-- Guest Navigation --}}
                        <a href="{{ route('products.index') }}" 
                           class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.index') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                            Katalog Produk
                        </a>
                    @endauth
                </div>
            </div>

            <!-- Right Side: Cart & User -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                
                <!-- Keranjang (untuk customer & guest) -->
                @auth
                    @if(Auth::user()->role !== 'admin')
                        @php
                            $cartCount = count(session()->get('cart', []));
                        @endphp
                        <a href="{{ route('cart.view') }}" class="relative inline-flex items-center text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            @if($cartCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    @endif
                @else
                    <!-- Guest: Tampilkan cart icon tapi arahkan ke login -->
                    <a href="{{ route('login') }}" class="relative inline-flex items-center text-gray-500 hover:text-gray-700" title="Login untuk melihat keranjang">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </a>
                @endauth

                @auth
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 text-sm text-gray-700 hover:text-gray-900">
                            {{ Auth::user()->name }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Kelola Pesanan</a>
                            @else
                                <a href="{{ route('cart.view') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keranjang</a>
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Pesanan Saya</a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-gray-900">Log in</a>
                        <a href="{{ route('register') }}" class="text-sm text-gray-700 hover:text-gray-900">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('products.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Katalog Produk</a>
            @auth
                @if(Auth::user()->role !== 'admin')
                    @php
                        $cartCountMobile = count(session()->get('cart', []));
                    @endphp
                    <a href="{{ route('cart.view') }}" class="flex items-center pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">
                        Keranjang
                        @if($cartCountMobile > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs rounded-full px-2 py-0.5">{{ $cartCountMobile }}</span>
                        @endif
                    </a>
                    <a href="{{ route('orders.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Pesanan Saya</a>
                @endif

            @else
                <a href="{{ route('login') }}" class="flex items-center pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">
                    Keranjang (Login dulu)
                </a>
            @endauth
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Admin Panel</a>
                        <a href="{{ route('admin.orders.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Kelola Pesanan</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Profil</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left pl-3 pr-4 py-2 text-base font-medium text-red-600 hover:bg-gray-50">Log Out</button>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Log in</a>
                    <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 hover:bg-gray-50">Register</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
