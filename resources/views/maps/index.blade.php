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

                // Set nilai awal statistik
                document.getElementById('total-sellers').textContent = '0';
                document.getElementById('total-buyers').textContent = '0';
                document.getElementById('total-transactions').textContent = '0';
            });
        }
    </script>
</body>
</html>
