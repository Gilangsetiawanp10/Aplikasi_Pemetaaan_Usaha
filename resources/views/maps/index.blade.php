<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemetaan Usaha</title>
    <!-- Mapbox CSS -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .count-circle {
            position: relative;
        }
        .count-circle::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: inherit;
            z-index: -1;
            opacity: 0.35;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.35;
            }
            70% {
                transform: scale(1.4);
                opacity: 0.2;
            }
            100% {
                transform: scale(1);
                opacity: 0.35;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-center h-20">
                    <div class="flex items-center space-x-4">
                        <i class="fas fa-map-marked-alt text-3xl text-white"></i>
                        <h1 class="text-3xl font-bold text-white tracking-wider">Pemetaan Usaha</h1>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4">
                    <!-- Map Container (3/4 width) -->
                    <div class="md:col-span-3">
                        <div id="map" class="w-full h-[800px] rounded-lg shadow-inner"></div>
                    </div>

                    <!-- Right Sidebar (1/4 width) -->
                    <div class="md:col-span-1 space-y-4">
                        <!-- Filter Section -->
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Filter Data</h3>
                            <select id="filterType" class="w-full p-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                                <option value="all">Semua Data</option>
                                <option value="seller">Penjual</option>
                                <option value="buyer">Pembeli</option>
                                <option value="transaction">Transaksi</option>
                            </select>
                        </div>

                        <!-- Stats Section -->
                        <div class="space-y-4">
                            <!-- Total Penjual -->
                            <div class="bg-white rounded-lg shadow-lg p-4">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-blue-100">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-gray-600 text-sm">Total Penjual</h2>
                                        <p id="total-sellers" class="text-2xl font-semibold text-gray-800">0</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Pembeli -->
                            <div class="bg-white rounded-lg shadow-lg p-4">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-green-100">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-gray-600 text-sm">Total Pembeli</h2>
                                        <p id="total-buyers" class="text-2xl font-semibold text-gray-800">0</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Transaksi -->
                            <div class="bg-white rounded-lg shadow-lg p-4">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-purple-100">
                                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h2 class="text-gray-600 text-sm">Total Transaksi</h2>
                                        <p id="total-transactions" class="text-2xl font-semibold text-gray-800">0</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mapbox JS -->
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
    <script>
        // Mengambil token dari env
        mapboxgl.accessToken = '{{ env('MAPBOX_TOKEN') }}';

        // Data dari backend
        const sellers = @json($sellers);
        const buyers = @json($buyers);
        const transactions = @json($transactions);

        // Hitung total
        const totalSellers = sellers.reduce((sum, item) => sum + (parseInt(item.jumlah_pendaftar_penjual) || 0), 0);
        const totalBuyers = buyers.reduce((sum, item) => sum + (parseInt(item.jumlah_pendaftar_pembeli) || 0), 0);
        const totalTransactions = transactions.reduce((sum, item) => sum + (parseInt(item.jumlah) || 0), 0);

        // Set statistik ke elemen
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('total-sellers').textContent = totalSellers;
            document.getElementById('total-buyers').textContent = totalBuyers;
            document.getElementById('total-transactions').textContent = totalTransactions;
        });

        // Inisialisasi map dengan lokasi pengguna
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(position => {
                const { longitude, latitude } = position.coords;

                // Inisialisasi map
                const map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: [longitude, latitude],
                    zoom: 15
                });

                // Tambahkan kontrol navigasi
                map.addControl(new mapboxgl.NavigationControl());

                // Tambahkan kontrol geolocation
                map.addControl(new mapboxgl.GeolocateControl({
                    positionOptions: {
                        enableHighAccuracy: true
                    },
                    trackUserLocation: true,
                    showUserHeading: true
                }));

                // Tambahkan marker untuk lokasi pengguna
                new mapboxgl.Marker({
                    color: "#FF0000" // Marker merah untuk lokasi pengguna
                })
                .setLngLat([longitude, latitude])
                .setPopup(new mapboxgl.Popup().setHTML('<div class="p-2"><h3 class="font-bold">Lokasi Anda</h3></div>'))
                .addTo(map);

                // ---
                // Jika nanti ada data koordinat, tambahkan marker di sini
                // Contoh:
                // sellers.forEach(seller => {
                //   if (seller.longitude && seller.latitude) {
                //     new mapboxgl.Marker({color: '#2563eb'})
                //       .setLngLat([seller.longitude, seller.latitude])
                //       .setPopup(new mapboxgl.Popup().setHTML(`<div class='p-2'><b>Penjual</b><br>Kecamatan: ${seller.kecamatan}</div>`))
                //       .addTo(map);
                //   }
                // });
                // ---
            });
        }

        // ...existing code...
async function getCoordinatesFromName(name) {
    const accessToken = mapboxgl.accessToken;
    const url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(name + ', Kabupaten Cilacap, Jawa Tengah, Indonesia')}.json?access_token=${accessToken}&limit=1`;
    const response = await fetch(url);
    const data = await response.json();
    if (data.features && data.features.length > 0) {
        return data.features[0].center; // [longitude, latitude]
    }
    return null;
}

document.addEventListener('DOMContentLoaded', function() {
    let map;
    let markers = [];
    // Source IDs untuk layer circles
    const sourceIds = {
        transactions: 'transactions-source',
        sellers: 'sellers-source',
        buyers: 'buyers-source'
    };

    // Function untuk membuat GeoJSON data
    function createGeoJSONData(data, countField) {
        return {
            type: 'FeatureCollection',
            features: data.filter(item => item.coordinates && item.coordinates.length === 2)
                .map(item => ({
                    type: 'Feature',
                    properties: {
                        count: parseInt(item[countField] || 0),
                        ...item
                    },
                    geometry: {
                        type: 'Point',
                        coordinates: item.coordinates
                    }
                }))
        };
    }

    // Function untuk menambahkan count circles dengan nilai di dalamnya
    function addCountCircles(type) {
        // Hapus semua count circle yang ada
        const existingCircles = document.querySelectorAll('.count-circle');
        existingCircles.forEach(circle => circle.remove());
        
        // Warna untuk setiap jenis data
        const colors = {
            transaction: '#a21caf',  // ungu
            seller: '#2563eb',       // biru
            buyer: '#22c55e'         // hijau
        };
        
        // Fungsi untuk membuat circle dengan angka di dalamnya
        function createCountCircle(coordinates, count, type, index) {
            // Buat elemen div untuk circle
            const circle = document.createElement('div');
            circle.className = 'count-circle absolute rounded-full flex items-center justify-center text-white font-bold shadow-md border-2 border-white';
            
            // Ukuran circle tetap sama untuk semua data
            const size = 26; // Ukuran yang konsisten dan tidak terlalu besar
            
            // Set style
            circle.style.width = `${size}px`;
            circle.style.height = `${size}px`;
            circle.style.backgroundColor = colors[type];
            circle.style.fontSize = count > 999 ? '10px' : '11px'; // Font size yang lebih kecil untuk muat di circle
            circle.style.zIndex = '10';
            circle.style.cursor = 'pointer'; // Tambahkan cursor pointer
            
            // Set teks jumlah
            circle.textContent = count > 999 ? `${Math.floor(count/1000)}k` : count;
            
            // Tambahkan atribut data untuk tipe dan koordinat asli
            circle.dataset.type = type;
            circle.dataset.index = index;
            
            // Siapkan popup content berdasarkan tipe data
            let popupContent = '';
            
            if (type === 'transaction') {
                const item = transactions[index];
                popupContent = `
                    <div class="p-3">
                        <h3 class="font-bold text-purple-600 mb-2">Detail Transaksi</h3>
                        <p><span class="font-semibold">Kecamatan:</span> ${item.kecamatan}</p>
                        <p><span class="font-semibold">Desa:</span> ${item.desa ?? '-'}</p>
                        ${item.jenis ? `<p><span class="font-semibold">Jenis:</span> ${item.jenis}</p>` : ''}
                        <p class="font-bold mt-2">Jumlah: ${count}</p>
                    </div>
                `;
            } else if (type === 'seller') {
                const item = sellers[index];
                popupContent = `
                    <div class="p-3">
                        <h3 class="font-bold text-blue-600 mb-2">Detail Penjual</h3>
                        <p><span class="font-semibold">Kecamatan:</span> ${item.kecamatan}</p>
                        <p class="font-bold mt-2">Jumlah Penjual: ${count}</p>
                    </div>
                `;
            } else if (type === 'buyer') {
                const item = buyers[index];
                popupContent = `
                    <div class="p-3">
                        <h3 class="font-bold text-green-600 mb-2">Detail Pembeli</h3>
                        <p><span class="font-semibold">Kecamatan:</span> ${item.kecamatan}</p>
                        <p class="font-bold mt-2">Jumlah Pembeli: ${count}</p>
                    </div>
                `;
            }
            
            // Buat marker dengan elemen HTML custom
            const marker = new mapboxgl.Marker({
                element: circle,
                anchor: 'center',
                offset: getMarkerOffset(type)
            })
            .setLngLat(coordinates)
            .setPopup(
                new mapboxgl.Popup({
                    closeButton: true,
                    closeOnClick: true
                })
                .setHTML(popupContent)
            )
            .addTo(map);
            
            // Simpan marker untuk bisa dihapus nanti
            markers.push(marker);
        }
        
        // Fungsi untuk mendapatkan offset marker berdasarkan tipe
        function getMarkerOffset(type) {
            switch(type) {
                case 'transaction':
                    return [25, -25]; // [x, y] - kanan atas
                case 'seller':
                    return [-25, -25]; // kiri atas
                case 'buyer':
                    return [0, 35];  // bawah
                default:
                    return [0, 0];
            }
        }
        
        // Tambahkan count circles untuk setiap jenis data sesuai filter
        if (type === 'all' || type === 'transaction') {
            transactions.forEach((item, index) => {
                if (item.coordinates && item.coordinates.length === 2) {
                    const count = parseInt(item.jumlah || 0);
                    createCountCircle(item.coordinates, count, 'transaction', index);
                }
            });
        }
        
        if (type === 'all' || type === 'seller') {
            sellers.forEach((item, index) => {
                if (item.coordinates && item.coordinates.length === 2) {
                    const count = parseInt(item.jumlah_pendaftar_penjual || 0);
                    createCountCircle(item.coordinates, count, 'seller', index);
                }
            });
        }
        
        if (type === 'all' || type === 'buyer') {
            buyers.forEach((item, index) => {
                if (item.coordinates && item.coordinates.length === 2) {
                    const count = parseInt(item.jumlah_pendaftar_pembeli || 0);
                    createCountCircle(item.coordinates, count, 'buyer', index);
                }
            });
        }
    }

    // Function untuk menambahkan circle layers
    function addCircleLayers(type) {
        // Hapus semua source dan layer yang sudah ada
        Object.values(sourceIds).forEach(id => {
            if (map.getSource(id)) {
                if (map.getLayer(`${id}-circles`)) {
                    map.removeLayer(`${id}-circles`);
                }
                map.removeSource(id);
            }
        });

        // Tambahkan source dan layer baru sesuai filter
        if (type === 'all' || type === 'transaction') {
            const transactionsData = createGeoJSONData(transactions, 'jumlah');
            map.addSource(sourceIds.transactions, {
                type: 'geojson',
                data: transactionsData
            });
            
            map.addLayer({
                id: `${sourceIds.transactions}-circles`,
                type: 'circle',
                source: sourceIds.transactions,
                paint: {
                    'circle-radius': [
                        'interpolate', ['linear'], ['get', 'count'],
                        0, 5,
                        10, 10,
                        100, 20,
                        1000, 30
                    ],
                    'circle-color': '#a21caf',
                    'circle-opacity': 0,  // Transparansi 0 untuk menyembunyikan circle asli
                    'circle-stroke-width': 0,
                    'circle-stroke-color': '#fff'
                }
            });
        }
        
        if (type === 'all' || type === 'seller') {
            const sellersData = createGeoJSONData(sellers, 'jumlah_pendaftar_penjual');
            map.addSource(sourceIds.sellers, {
                type: 'geojson',
                data: sellersData
            });
            
            map.addLayer({
                id: `${sourceIds.sellers}-circles`,
                type: 'circle',
                source: sourceIds.sellers,
                paint: {
                    'circle-radius': [
                        'interpolate', ['linear'], ['get', 'count'],
                        0, 5,
                        10, 10,
                        100, 20,
                        1000, 30
                    ],
                    'circle-color': '#2563eb',
                    'circle-opacity': 0,  // Transparansi 0 untuk menyembunyikan circle asli
                    'circle-stroke-width': 0,
                    'circle-stroke-color': '#fff'
                }
            });
        }
        
        if (type === 'all' || type === 'buyer') {
            const buyersData = createGeoJSONData(buyers, 'jumlah_pendaftar_pembeli');
            map.addSource(sourceIds.buyers, {
                type: 'geojson',
                data: buyersData
            });
            
            map.addLayer({
                id: `${sourceIds.buyers}-circles`,
                type: 'circle',
                source: sourceIds.buyers,
                paint: {
                    'circle-radius': [
                        'interpolate', ['linear'], ['get', 'count'],
                        0, 5,
                        10, 10,
                        100, 20,
                        1000, 30
                    ],
                    'circle-color': '#22c55e',
                    'circle-opacity': 0,  // Transparansi 0 untuk menyembunyikan circle asli
                    'circle-stroke-width': 0,
                    'circle-stroke-color': '#fff'
                }
            });
        }
        
        // Tambahkan event popup untuk circle layers
        setupCirclePopups();
    }
    
    // Function untuk setup popup pada circle layers
    function setupCirclePopups() {
        const popup = new mapboxgl.Popup({
            closeButton: false,
            closeOnClick: false
        });
        
        // Untuk transaksi
        if (map.getLayer(`${sourceIds.transactions}-circles`)) {
            map.on('mouseenter', `${sourceIds.transactions}-circles`, (e) => {
                map.getCanvas().style.cursor = 'pointer';
                const properties = e.features[0].properties;
                const coordinates = e.features[0].geometry.coordinates.slice();
                const html = `
                    <div class='p-2'>
                        <b>Transaksi</b><br>
                        Kecamatan: ${properties.kecamatan}<br>
                        Desa: ${properties.desa ?? '-'}<br>
                        Jenis: ${properties.jenis}<br>
                        Jumlah: ${properties.count}
                    </div>
                `;
                
                popup.setLngLat(coordinates).setHTML(html).addTo(map);
            });
            
            map.on('mouseleave', `${sourceIds.transactions}-circles`, () => {
                map.getCanvas().style.cursor = '';
                popup.remove();
            });
        }
        
        // Untuk penjual
        if (map.getLayer(`${sourceIds.sellers}-circles`)) {
            map.on('mouseenter', `${sourceIds.sellers}-circles`, (e) => {
                map.getCanvas().style.cursor = 'pointer';
                const properties = e.features[0].properties;
                const coordinates = e.features[0].geometry.coordinates.slice();
                const html = `
                    <div class='p-2'>
                        <b>Penjual</b><br>
                        Kecamatan: ${properties.kecamatan}<br>
                        Jumlah: ${properties.count}
                    </div>
                `;
                
                popup.setLngLat(coordinates).setHTML(html).addTo(map);
            });
            
            map.on('mouseleave', `${sourceIds.sellers}-circles`, () => {
                map.getCanvas().style.cursor = '';
                popup.remove();
            });
        }
        
        // Untuk pembeli
        if (map.getLayer(`${sourceIds.buyers}-circles`)) {
            map.on('mouseenter', `${sourceIds.buyers}-circles`, (e) => {
                map.getCanvas().style.cursor = 'pointer';
                const properties = e.features[0].properties;
                const coordinates = e.features[0].geometry.coordinates.slice();
                const html = `
                    <div class='p-2'>
                        <b>Pembeli</b><br>
                        Kecamatan: ${properties.kecamatan}<br>
                        Jumlah: ${properties.count}
                    </div>
                `;
                
                popup.setLngLat(coordinates).setHTML(html).addTo(map);
            });
            
            map.on('mouseleave', `${sourceIds.buyers}-circles`, () => {
                map.getCanvas().style.cursor = '';
                popup.remove();
            });
        }
    }

    function addMarkers(type) {
        // Hapus marker lama
        markers.forEach(m => m.remove());
        markers = [];

        // Tambahkan circle layers untuk visualisasi jumlah data (hanya untuk popup)
        addCircleLayers(type);
        
        // Tambahkan circle dengan jumlah di dalamnya
        addCountCircles(type);

        if (type === 'all' || type === 'transaction') {
            transactions.forEach(item => {
                if (item.coordinates && item.coordinates.length === 2) {
                    const marker = new mapboxgl.Marker({ 
                        color: "#a21caf",
                        scale: 0.8 // Marker sedikit lebih kecil
                    })
                        .setLngLat(item.coordinates)
                        .setPopup(new mapboxgl.Popup().setHTML(
                            `<div class='p-2'><b>Transaksi</b><br>Kecamatan: ${item.kecamatan}<br>Desa: ${item.desa ?? '-'}<br>Jenis: ${item.jenis}<br>Jumlah: ${item.jumlah}</div>`
                        ))
                        .addTo(map);
                    markers.push(marker);
                }
            });
        }
        if (type === 'all' || type === 'seller') {
            sellers.forEach(item => {
                if (item.coordinates && item.coordinates.length === 2) {
                    const marker = new mapboxgl.Marker({ 
                        color: "#2563eb",
                        scale: 0.8 // Marker sedikit lebih kecil
                    })
                        .setLngLat(item.coordinates)
                        .setPopup(new mapboxgl.Popup().setHTML(
                            `<div class='p-2'><b>Penjual</b><br>Kecamatan: ${item.kecamatan}<br>Jumlah: ${item.jumlah_pendaftar_penjual ?? '-'}</div>`
                        ))
                        .addTo(map);
                    markers.push(marker);
                }
            });
        }
        if (type === 'all' || type === 'buyer') {
            buyers.forEach(item => {
                if (item.coordinates && item.coordinates.length === 2) {
                    const marker = new mapboxgl.Marker({ 
                        color: "#22c55e",
                        scale: 0.8 // Marker sedikit lebih kecil
                    })
                        .setLngLat(item.coordinates)
                        .setPopup(new mapboxgl.Popup().setHTML(
                            `<div class='p-2'><b>Pembeli</b><br>Kecamatan: ${item.kecamatan}<br>Jumlah: ${item.jumlah_pendaftar_pembeli ?? '-'}</div>`
                        ))
                        .addTo(map);
                    markers.push(marker);
                }
            });
        }
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(position => {
            const { longitude, latitude } = position.coords;

            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [longitude, latitude],
                zoom: 12,
                // Menambahkan opsi untuk performa lebih baik
                fadeDuration: 0,
                renderWorldCopies: false
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: { enableHighAccuracy: true },
                trackUserLocation: true,
                showUserHeading: true
            }));

            // Marker lokasi user
            new mapboxgl.Marker({ color: "#FF0000" })
                .setLngLat([longitude, latitude])
                .setPopup(new mapboxgl.Popup().setHTML('<div class="p-2"><h3 class="font-bold">Lokasi Anda</h3></div>'))
                .addTo(map);

            // Tunggu hingga map selesai dimuat baru tambahkan data
            map.on('load', function() {
                // Tampilkan semua marker awal
                addMarkers('all');
                
                // Tambahkan legend untuk ukuran circle
                addLegend();
            });

            // Optimasi ketika peta digeser
            let filterActive = 'all';
            
            // Event filter
            document.getElementById('filterType').addEventListener('change', function() {
                filterActive = this.value;
                addMarkers(filterActive);
            });
        });
    }
    
    // Function untuk menambahkan legend
    function addLegend() {
        const legend = document.createElement('div');
        legend.className = 'bg-white p-2 rounded-lg shadow-lg absolute bottom-5 right-5';
        legend.style.zIndex = '1';
        legend.innerHTML = `
            <h4 class="font-semibold text-sm mb-2">Keterangan Warna</h4>
            <div class="flex items-center mb-1">
                <div class="w-4 h-4 rounded-full bg-purple-600 mr-2"></div>
                <span class="text-xs">Transaksi</span>
            </div>
            <div class="flex items-center mb-1">
                <div class="w-4 h-4 rounded-full bg-blue-600 mr-2"></div>
                <span class="text-xs">Penjual</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 rounded-full bg-green-600 mr-2"></div>
                <span class="text-xs">Pembeli</span>
            </div>
        `;
        document.getElementById('map').appendChild(legend);
    }
});
    </script>
</body>
</html>