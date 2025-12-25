<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
         {{-- Lokasi Toko --}}

 <!-- Leaflet CSS sama Leaflet JS-->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    .location-card {
        max-width: 100%;
        margin: 40px auto;
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
        margin-top: 12px;
    }
    .maps-link {
        display: block;
        margin: 18px auto 0 auto;
        font-size: 1.1em;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        border: 1px solid #2563eb;
        border-radius: 8px;
        padding: 8px 18px;
        width: fit-content;
        transition: background 0.2s, color 0.2s;
    }
    .maps-link:hover {
        background: #2563eb;
        color: #fff;
    }
</style>

<div class="location-card">
    <div class="location-title">Lokasi GetReloved</div>
    <div id="map"></div>
    <a class="maps-link" href="https://www.google.com/maps/place/Universitas+Pasundan/@-6.866502,107.5906701,17z/data=!3m1!4b1!4m6!3m5!1s0x2e68e6be3e8a0c49:0x730028bf4627def4!8m2!3d-6.866502!4d107.593245!16s%2Fg%2F1td10cl0?entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D" target="_blank">
        Buka di Google Maps
    </a>
</div>

<script>
    // Koordinat GetReloved
    var lat = -6.8663741705271635; 
    var lon = 107.59322353768817; 

    var map = L.map('map').setView([lat, lon], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Peta Toko | © OpenStreetMap contributors'
    }).addTo(map);

    L.marker([lat, lon]).addTo(map)
        .bindPopup('<b>Toko Saya</b><br>Di sini lokasi toko Anda.')
        .openPopup();
</script>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            
            {{-- Kolom 1: Brand & Deskripsi --}}
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('GetReloved.png') }}" 
                    class="h-4 w-auto">    
                </div>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs">
                GetReloved percaya fashion bukan hanya soal tampilan, tapi tentang pilihan sadar. Dengan memperpanjang usia pakai pakaian, kami ikut mengurangi limbah dan dampak berlebih industri fashion.                </p>
            </div>

            {{-- Kolom 2: Navigasi Cepat --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Navigasi</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-blue-600 text-sm transition">
                            Katalog Produk
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('cart.view') }}" class="text-gray-500 hover:text-blue-600 text-sm transition">
                                Keranjang Belanja
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-blue-600 text-sm transition">
                                Riwayat Pesanan
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-gray-500 hover:text-blue-600 text-sm transition">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-gray-500 hover:text-blue-600 text-sm transition">
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- Kolom 3: Kontak / Info Kampus --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-900 tracking-wider uppercase mb-4">Hubungi Kami</h3>
                <ul class="space-y-3 text-gray-500 text-sm">
                    <li class="flex items-start gap-2">
                        <span>📍</span>
                        <span>
                            GetReloved<br>
                            Setiabudi, Sukajadi<br>
                            Bandung, Indonesia
                        </span>
                    </li>
                    <li class="flex items-center gap-2">
                        <span>📧</span>
                        <a href="mailto:admin@unpas.ac.id" class="hover:text-blue-600">contact@GetReloved.co.id</a>
                    </li>
                </ul>
            </div>
        </div>

       
        {{-- Copyright Bawah --}}
        <div class="border-t border-gray-100 mt-10 pt-6 flex flex-col md:flex-row justify-between items-center">
            <p class="text-sm text-gray-400">
                &copy; {{ date('Y') }} GetReloved. All rights reserved.
            </p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">GitHub</span>
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/></svg>
                </a>
            </div>
        </div>
    </div>
</footer>