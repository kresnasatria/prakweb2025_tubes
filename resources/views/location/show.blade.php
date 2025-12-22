<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
    .location-card {
        max-width: 500px;
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
    <div class="location-title">Lokasi Toko Saya</div>
    <div id="map"></div>
    <a class="maps-link" href="https://www.google.com/maps/place/Universitas+Pasundan/@-6.866502,107.5906701,17z/data=!3m1!4b1!4m6!3m5!1s0x2e68e6be3e8a0c49:0x730028bf4627def4!8m2!3d-6.866502!4d107.593245!16s%2Fg%2F1td10cl0?entry=ttu&g_ep=EgoyMDI1MTIwOS4wIKXMDSoASAFQAw%3D%3D" target="_blank">
        Buka di Google Maps
    </a>
</div>

<script>
    // Koordinat toko: universitas pasundan
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