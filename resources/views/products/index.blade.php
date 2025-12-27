@extends('layouts.app')

@section('content')
    
    @auth
        <div class="w-screen relative left-[calc(-50vw+50%)] mb-8 -mt-6 py-8 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <form id="filterForm" method="GET" action="{{ route('products.index') }}">
                    
                    {{-- Search Bar --}}
                    <div class="max-w-3xl mx-auto text-center mb-8">
                        <label class="block text-3xl font-extrabold text-gray-800 mb-6">Apa yang ingin Anda cari?</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                                   placeholder="Ketik nama baju, celana, atau produk lainnya..."
                                   class="pl-14 block w-full bg-white border-0 rounded-full shadow-lg ring-1 ring-gray-200 focus:ring-2 focus:ring-black py-4 text-gray-700 text-lg transition hover:shadow-xl">
                            <div id="searchDropdown"
                                class="absolute top-full left-0 w-full bg-white rounded-xl shadow-xl mt-3 z-50 hidden text-left">

                                <div class="p-4 border-b">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs text-gray-400">Pencarian Anda</span>
                                        <button type="button" id="clearHistory"
                                                class="text-xs text-black hover:underline">
                                            Hapus
                                        </button>
                                    </div>
                                    <ul id="searchHistory" class="space-y-2 text-gray-700 text-sm"></ul>
                                </div>

                                <div class="p-4">
                                    <span class="text-xs text-gray-400 block mb-2">Kategori Populer</span>
                                    <ul class="space-y-2 text-gray-700 text-sm">
                                        @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                                class="block cursor-pointer hover:text-gray-400">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- Filter Lanjutan --}}
                    <div class="px-2">
                        <div class="flex items-center gap-2 mb-2 text-gray-400 uppercase tracking-wide text-[10px] font-bold pl-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            Filter Lanjutan
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3 items-end">
                            {{-- Input Kategori --}}
                            <div>
                                <select name="category" id="categoryFilter" class="w-full bg-white border-0 rounded-md shadow-sm ring-1 ring-gray-200 focus:ring-blue-500 py-2 text-sm text-gray-600">
                                    <option value="">Semua Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Input Harga Min --}}
                            <div>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-gray-400 text-xs">Rp</span></div>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                           class="pl-8 w-full bg-white border-0 rounded-md shadow-sm ring-1 ring-gray-200 focus:ring-blue-500 py-2 text-sm text-gray-600">
                                </div>
                            </div>
                            {{-- Input Harga Max --}}
                            <div>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><span class="text-gray-400 text-xs">Rp</span></div>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                           class="pl-8 w-full bg-white border-0 rounded-md shadow-sm ring-1 ring-gray-200 focus:ring-blue-500 py-2 text-sm text-gray-600">
                                </div>
                            </div>
                            {{-- Input Sorting --}}
                            <div>
                                <select name="sort" id="sortFilter" class="w-full bg-white border-0 rounded-md shadow-sm ring-1 ring-gray-200 focus:ring-blue-500 py-2 text-sm text-gray-600">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Termurah</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Termahal</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>A-Z</option>
                                </select>
                            </div>
                            {{-- Tombol Reset & Cari --}}
                            <div class="flex gap-2">
                                <a href="{{ route('products.index') }}" class="flex-1 py-2 text-center text-gray-500 hover:text-gray-800 text-sm font-medium transition border border-gray-200 rounded-md hover:bg-gray-50 bg-white">
                                    Reset
                                </a>
                                <button type="submit" class="flex-1 bg-black text-white py-2 rounded-md hover:bg-gray-700 shadow-sm transition font-medium text-sm">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endauth


    @guest
        {{-- Carousel Container --}}
        <div class="w-screen relative left-[calc(-50vw+50%)] mb-10 -mt-6"
             x-data="{ 
                activeSlide: 0,
                slides: [
                    { title: 'Halo, Ini GetReloved', text: 'Lebih dari sekadar outfit, ini pilihan.',image: '{{ asset('slider/slide1.jpg') }}' , btn: 'Daftar Sekarang', link: '{{ route('login') }}' },
                    { title: 'Second Hand, Still On Trend', text: 'Mix, match, repeat.', image: '{{ asset('slider/slide2.jpg') }}', btn: 'Lihat Produk', link: '{{ route('login') }}' },
                    { title: 'Diskon Spesial Setiap Hari', text: 'Nikmati gratis ongkir untuk setiap pembelian.', image: '{{ asset('slider/slide3.jpg') }}', btn: 'Belanja Yuk', link: '{{ route('login') }}' }
                ],
                next() { this.activeSlide = (this.activeSlide + 1) % this.slides.length },
                prev() { this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length },
                init() { setInterval(() => this.next(), 5000) }
             }"
             x-init="init()">
            
            {{-- Slide Track --}}
        <div class="relative h-[600px] overflow-hidden">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="absolute inset-0 w-full h-full text-white flex items-center justify-center transition-opacity duration-1000 ease-in-out"
                    x-show="activeSlide === index"
                    x-transition:enter="transition ease-out duration-1000"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-1000"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-105">

            {{-- Background Image --}}
            <div class="absolute inset-0 bg-cover bg-center"
                 :style="`background-image: url('${slide.image}')`">
            </div>

            {{-- Overlay sama Blur --}}
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="absolute inset-0 backdrop-blur-sm"></div>


            <div class="relative z-10 text-center px-4 max-w-4xl">
                <h1 class="text-6xl font-extrabold mb-6 leading-tight"
                    x-text="slide.title"></h1>
                <p class="text-2xl text-white/90 mb-10"
                   x-text="slide.text"></p>
                <a :href="slide.link"
                   class="inline-block bg-white text-gray-900 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition shadow-xl transform hover:-translate-y-1"
                   x-text="slide.btn">
                </a>
            </div>

        </div>
    </template>
</div>

            {{-- Navigasi Carousel --}}
            <button @click="prev()" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 p-4 rounded-full text-white backdrop-blur-sm transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </button>
            <button @click="next()" class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/20 hover:bg-white/40 p-4 rounded-full text-white backdrop-blur-sm transition">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>

            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex space-x-3">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index" 
                            class="w-3 h-3 rounded-full transition-all duration-300"
                            :class="activeSlide === index ? 'bg-white w-10' : 'bg-white/50 hover:bg-white/80'">
                    </button>
                </template>
            </div>
        </div>

        {{-- Info Promo --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-lg shadow p-6 text-center hover:-translate-y-1 transition transform duration-300">
                <div class="text-4xl mb-3">📦</div>
                <h3 class="font-bold text-gray-800 mb-2">Gratis Ongkir</h3>
                <p class="text-gray-500 text-sm">Pengiriman gratis untuk pembelian tertentu</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center hover:-translate-y-1 transition transform duration-300">
                <div class="text-4xl mb-3">✅</div>
                <h3 class="font-bold text-gray-800 mb-2">Produk Original</h3>
                <p class="text-gray-500 text-sm">100% produk asli berkualitas tinggi</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center hover:-translate-y-1 transition transform duration-300">
                <div class="text-4xl mb-3">💳</div>
                <h3 class="font-bold text-gray-800 mb-2">Pembayaran Aman</h3>
                <p class="text-gray-500 text-sm">Transaksi dijamin aman dan terpercaya</p>
            </div>
        </div>
    @endguest


    {{-- DAFTAR PRODUK --}}
    <div class="mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Daftar Produk</h2>
            <p class="text-gray-600 text-sm">
                Menampilkan <span class="font-semibold">{{ $products->total() }}</span> produk
                @if(request('search'))
                    untuk "<span class="font-semibold">{{ request('search') }}</span>"
                @endif
            </p>
        </div>

        {{-- Partial View Grid Produk --}}
        <div id="productGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @include('products.partials.product-grid', ['products' => $products])
        </div>

        <div id="pagination" class="mt-8">
            {{ $products->links() }}
        </div>
    </div>

    {{-- LIVE SEARCH (AJAX) --}}
    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const categoryFilter = document.getElementById('categoryFilter');
            const sortFilter = document.getElementById('sortFilter');
            let debounceTimer;

            if(searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => { fetchProducts(); }, 500);
                });
            }

            if(categoryFilter) categoryFilter.addEventListener('change', fetchProducts);
            if(sortFilter) sortFilter.addEventListener('change', fetchProducts);

            function fetchProducts() {
                const form = document.getElementById('filterForm');
                if(!form) return;
                
                const formData = new FormData(form);
                const params = new URLSearchParams(formData);

                window.history.replaceState({}, '', `${window.location.pathname}?${params}`);

                fetch(`{{ route('products.index') }}?${params}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('productGrid').innerHTML = data.html;
                    document.getElementById('pagination').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
            }
        });

        
    </script>
    @endauth

    {{-- Maps Toko --}}

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
        .location-card {
            max-width: 100%;
            margin: 60px auto 0;
            background: #f8fafc;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 24px;
            text-align: center;
        }
        .location-title {
            font-size: 1.6rem;
            font-weight: bold;
            margin-bottom: 16px;
            color: #2d3748;
        }
        #map {
            height: 350px;
            border-radius: 12px;
        }
        .maps-link {
            display: inline-block;
            margin-top: 18px;
            font-size: 1rem;
            color: #2563eb;
            font-weight: 500;
            border: 1px solid #2563eb;
            border-radius: 8px;
            padding: 8px 18px;
            transition: all 0.2s;
        }
        .maps-link:hover {
            background: #2563eb;
            color: white;
        }
    </style>

    <div class="location-card">
        <div class="location-title">Lokasi GetReloved</div>
        <div id="map"></div>
        <a class="maps-link"
           href="https://www.google.com/maps/place/Universitas+Pasundan/@-6.866502,107.593245,17z"
           target="_blank">
            Buka di Google Maps
        </a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const lat = -6.8663741705271635;
            const lon = 107.59322353768817;

            const map = L.map('map').setView([lat, lon], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([lat, lon]).addTo(map)
                .bindPopup('<b>GetReloved</b><br>Lokasi Kami')
                .openPopup();
        });
    </script>

            <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('searchInput');
            const dropdown = document.getElementById('searchDropdown');
            const historyList = document.getElementById('searchHistory');
            const clearBtn = document.getElementById('clearHistory');

            if (!input || !dropdown) return;

            function getHistory() {
                return JSON.parse(localStorage.getItem('search_history')) || [];
            }

            function saveHistory(keyword) {
                let history = getHistory();
                history = history.filter(item => item !== keyword);
                history.unshift(keyword);
                history = history.slice(0, 5);
                localStorage.setItem('search_history', JSON.stringify(history));
            }

            function renderHistory() {
                historyList.innerHTML = '';
                const history = getHistory();

                if (history.length === 0) {
                    historyList.innerHTML =
                        '<li class="text-gray-400 text-sm">Belum ada pencarian</li>';
                    return;
                }

                history.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    li.className = 'cursor-pointer hover:text-blue-600';
                    li.onclick = () => {
                        input.value = item;
                        dropdown.classList.add('hidden');
                        input.form.submit();
                    };
                    historyList.appendChild(li);
                });
            }

            input.addEventListener('focus', () => {
                renderHistory();
                dropdown.classList.remove('hidden');
            });

            input.addEventListener('blur', () => {
                setTimeout(() => dropdown.classList.add('hidden'), 200);
            });

            input.form.addEventListener('submit', () => {
                if (input.value.trim()) {
                    saveHistory(input.value.trim());
                }
            });

            clearBtn.addEventListener('click', () => {
                localStorage.removeItem('search_history');
                renderHistory();
            });
        });
</script>

@endsection