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
        
        /* Legend Styles */
        .legend-item {
            transition: all 0.3s ease;
        }
        .legend-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .legend-color-dot {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        /* Map Legend Responsive */
        @media (max-width: 768px) {
            #map-legend {
                bottom: 10px !important;
                right: 10px !important;
                left: 10px !important;
                max-width: none !important;
            }
        }
        
        /* Smooth transitions for legend toggle */
        #legend-content {
            transition: all 0.3s ease;
            overflow: hidden;
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
                        <div class="relative">
                            <div id="map" class="w-full h-[800px] rounded-lg shadow-inner"></div>
                            <!-- Loading overlay -->
                            <div id="mapLoading" class="absolute inset-0 bg-gray-100 bg-opacity-90 flex items-center justify-center rounded-lg z-10">
                                <div class="text-center">
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                                    <p class="mt-2 text-gray-600 font-medium">Memuat peta...</p>
                                    <p class="text-sm text-gray-500">Sedang memproses data...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Sidebar (1/4 width) -->
                    <div class="md:col-span-1 space-y-4">
                            <!-- Filter Section -->
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-700 mb-3">Filter Data</h3>
                            <select id="filterType" class="w-full p-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 mb-3">
                                <option value="all">Semua Data</option>
                                <option value="seller">Penjual</option>
                                <option value="buyer">Pembeli</option>
                                <option value="transaction">Transaksi</option>
                            </select>
                            
                            <!-- Info clustering -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-3">
                                <h4 class="text-sm font-semibold text-blue-800 mb-1">💡 Info Tampilan</h4>
                                <div class="text-xs text-blue-700 space-y-1">
                                    <div>• <strong>Zoom Rendah:</strong> Data digabung dalam cluster</div>
                                    <div>• <strong>Zoom Tinggi:</strong> Tampil detail individual</div>
                                    <div>• <strong>Klik cluster:</strong> Zoom ke detail</div>
                                    <div>• <strong>Data konsisten:</strong> Tidak ada yang hilang</div>
                                </div>
                            </div>
                            
                            <!-- Filter by jenis penjualan -->
                            <div class="mt-3">
                                <label for="searchJenis" class="block text-sm font-medium text-gray-700 mb-1">Cari Jenis Penjualan:</label>
                                <div class="flex space-x-2">
                                    <input type="text" id="searchJenis" placeholder="Contoh: Mie Ayam" 
                                        class="w-full p-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500">
                                    <button id="searchButton" class="bg-blue-600 text-white px-3 rounded-lg hover:bg-blue-700 flex items-center justify-center">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <div class="flex justify-between items-center mt-2">
                                    <div class="text-xs text-gray-500">* Pencarian berdasarkan jenis penjualan/transaksi</div>
                                    <button id="resetSearchButton" class="text-xs text-blue-600 hover:underline">Reset</button>
                                </div>
                                <div id="searchStatus" class="hidden mt-2 py-1 px-2 bg-blue-100 text-blue-800 text-sm rounded-md"></div>
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="space-y-4">
                            <!-- Performance Info -->
                            <div class="bg-white rounded-lg shadow-lg p-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Status Tampilan</h3>
                                <div class="space-y-2 text-xs">
                                    <div class="flex justify-between">
                                        <span>Zoom Level:</span>
                                        <span id="zoom-level" class="font-mono font-semibold">12</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Data Tampil:</span>
                                        <span id="visible-markers" class="font-mono font-semibold">0</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Mode:</span>
                                        <span id="render-mode" class="font-mono font-semibold">Clustered</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-1">
                                        <span>Performa:</span>
                                        <div class="flex items-center">
                                            <div id="performance-indicator" class="w-2 h-2 rounded-full bg-green-500 mr-1"></div>
                                            <span id="performance-text" class="text-green-600 font-semibold">Optimal</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Legend Kategori Warna -->
                            <div class="bg-white rounded-lg shadow-lg p-4">
                                <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-palette mr-2 text-blue-600"></i>
                                    Kategori Data
                                    <span class="ml-2 text-xs text-gray-500">(Klik untuk filter)</span>
                                </h3>
                                <div class="space-y-3">
                                    <!-- Transaksi -->
                                    <div class="legend-item flex items-center justify-between p-3 rounded-lg bg-purple-50 border border-purple-100 cursor-pointer hover:shadow-md transition-all duration-200" 
                                         title="Klik untuk filter hanya data transaksi">
                                        <div class="flex items-center">
                                            <div class="legend-color-dot w-5 h-5 rounded-full bg-gradient-to-r from-purple-500 to-purple-700 mr-3 flex items-center justify-center">
                                                <i class="fas fa-exchange-alt text-white text-xs"></i>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-800">Transaksi</span>
                                                <div class="text-xs text-purple-600">Volume perdagangan</div>
                                            </div>
                                        </div>
                                        <div class="text-xs">
                                            <i class="fas fa-mouse-pointer text-purple-400 opacity-60"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Penjual -->
                                    <div class="legend-item flex items-center justify-between p-3 rounded-lg bg-blue-50 border border-blue-100 cursor-pointer hover:shadow-md transition-all duration-200"
                                         title="Klik untuk filter hanya data penjual">
                                        <div class="flex items-center">
                                            <div class="legend-color-dot w-5 h-5 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 mr-3 flex items-center justify-center">
                                                <i class="fas fa-store text-white text-xs"></i>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-800">Penjual</span>
                                                <div class="text-xs text-blue-600">Pendaftar penjual</div>
                                            </div>
                                        </div>
                                        <div class="text-xs">
                                            <i class="fas fa-mouse-pointer text-blue-400 opacity-60"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Pembeli -->
                                    <div class="legend-item flex items-center justify-between p-3 rounded-lg bg-green-50 border border-green-100 cursor-pointer hover:shadow-md transition-all duration-200"
                                         title="Klik untuk filter hanya data pembeli">
                                        <div class="flex items-center">
                                            <div class="legend-color-dot w-5 h-5 rounded-full bg-gradient-to-r from-green-500 to-green-700 mr-3 flex items-center justify-center">
                                                <i class="fas fa-shopping-cart text-white text-xs"></i>
                                            </div>
                                            <div>
                                                <span class="text-sm font-medium text-gray-800">Pembeli</span>
                                                <div class="text-xs text-green-600">Pendaftar pembeli</div>
                                            </div>
                                        </div>
                                        <div class="text-xs">
                                            <i class="fas fa-mouse-pointer text-green-400 opacity-60"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-3 border-t border-gray-200">
                                    <div class="text-xs text-gray-500 space-y-1">
                                        <div class="flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                            <span>Ukuran lingkaran = jumlah data</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-search-plus mr-2 text-blue-500"></i>
                                            <span>Zoom untuk melihat detail</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-filter mr-2 text-blue-500"></i>
                                            <span>Klik kategori untuk filter data</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

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

        // Data dari backend - Optimasi: hanya load data yang diperlukan
        const rawSellers = @json($sellers);
        const rawBuyers = @json($buyers);
        const rawTransactions = @json($transactions);
        
        // Optimasi: Pre-process dan filter data yang valid
        const sellers = rawSellers.filter(item => item.coordinates && item.coordinates.length === 2);
        const buyers = rawBuyers.filter(item => item.coordinates && item.coordinates.length === 2);
        const transactions = rawTransactions.filter(item => item.coordinates && item.coordinates.length === 2);

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
    let filteredTransactions = [...transactions];
    let searchKeyword = '';
    let currentZoom = 12;
    let isLowZoom = true;
    let visibleMarkerCount = 0;
    
    // Performance monitoring
    const performanceMonitor = {
        updateZoomLevel: (zoom) => {
            document.getElementById('zoom-level').textContent = zoom.toFixed(1);
        },
        
        updateVisibleMarkers: (count) => {
            visibleMarkerCount = count;
            document.getElementById('visible-markers').textContent = count;
        },
        
        updateRenderMode: (mode) => {
            document.getElementById('render-mode').textContent = mode;
        },
        
        updatePerformanceStatus: (count) => {
            const indicator = document.getElementById('performance-indicator');
            const text = document.getElementById('performance-text');
            
            if (count < 100) {
                indicator.className = 'w-2 h-2 rounded-full bg-green-500 mr-1';
                text.textContent = 'Optimal';
                text.className = 'text-green-600';
            } else if (count < 300) {
                indicator.className = 'w-2 h-2 rounded-full bg-yellow-500 mr-1';
                text.textContent = 'Sedang';
                text.className = 'text-yellow-600';
            } else {
                indicator.className = 'w-2 h-2 rounded-full bg-red-500 mr-1';
                text.textContent = 'Berat';
                text.className = 'text-red-600';
            }
        }
    };
    
    // Optimasi: Clustering threshold berdasarkan zoom level - DIPERBAIKI
    const ZOOM_SETTINGS = {
        cluster: {
            enabled: true,
            maxZoom: 13,        // Clustering sampai zoom 13
            radius: 50          // Radius clustering
        },
        visibility: {
            minZoom: 8,         // Minimum zoom untuk mulai tampil
            maxZoom: 18,        // Maximum zoom
            fadeTransition: true // Smooth transition
        }
    };
    
    // Optimasi: Batasan jumlah marker yang ditampilkan - DISEDERHANAKAN
    const MAX_MARKERS_PER_TYPE = 500; // Konsisten untuk semua zoom level
    
    // Source IDs untuk layer circles
    const sourceIds = {
        transactions: 'transactions-source',
        sellers: 'sellers-source',
        buyers: 'buyers-source',
        clusteredTransactions: 'clustered-transactions-source',
        clusteredSellers: 'clustered-sellers-source',
        clusteredBuyers: 'clustered-buyers-source'
    };

    // PERBAIKAN: Function untuk clustering yang konsisten
    function smartClusterData(data, zoom) {
        // Jika zoom tinggi (>13), tampilkan semua data tanpa clustering
        if (zoom > ZOOM_SETTINGS.cluster.maxZoom) {
            return data.map(item => ({
                coordinates: item.coordinates,
                items: [item],
                count: parseInt(item.jumlah || item.jumlah_pendaftar_penjual || item.jumlah_pendaftar_pembeli || 0),
                type: item.jenis ? 'transaction' : (item.jumlah_pendaftar_penjual ? 'seller' : 'buyer'),
                clustered: false
            }));
        }
        
        // Untuk zoom rendah, gunakan clustering
        const clusterDistance = zoom < 10 ? 0.02 : zoom < 12 ? 0.01 : 0.005;
        const clusters = [];
        const processed = new Set();
        
        data.forEach((item, index) => {
            if (processed.has(index) || !item.coordinates) return;
            
            const cluster = {
                coordinates: item.coordinates,
                items: [item],
                count: parseInt(item.jumlah || item.jumlah_pendaftar_penjual || item.jumlah_pendaftar_pembeli || 0),
                type: item.jenis ? 'transaction' : (item.jumlah_pendaftar_penjual ? 'seller' : 'buyer'),
                clustered: false
            };
            
            // Cari data lain yang dekat untuk clustering
            data.forEach((otherItem, otherIndex) => {
                if (processed.has(otherIndex) || otherIndex === index || !otherItem.coordinates) return;
                
                const distance = getDistance(item.coordinates, otherItem.coordinates);
                if (distance < clusterDistance) {
                    cluster.items.push(otherItem);
                    cluster.count += parseInt(otherItem.jumlah || otherItem.jumlah_pendaftar_penjual || otherItem.jumlah_pendaftar_pembeli || 0);
                    processed.add(otherIndex);
                    cluster.clustered = true;
                }
            });
            
            processed.add(index);
            clusters.push(cluster);
        });
        
        return clusters;
    }
    
    // Function untuk menentukan apakah perlu update berdasarkan zoom
    function shouldUpdateOnZoom(oldZoom, newZoom) {
        const oldIsCluster = oldZoom <= ZOOM_SETTINGS.cluster.maxZoom;
        const newIsCluster = newZoom <= ZOOM_SETTINGS.cluster.maxZoom;
        
        // Update jika status clustering berubah atau zoom berubah signifikan (>1 level)
        return oldIsCluster !== newIsCluster || Math.abs(newZoom - oldZoom) > 1;
    }
    
    // Utility: Debounce function
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Function untuk menghitung jarak antara dua koordinat
    function getDistance(coord1, coord2) {
        const [lng1, lat1] = coord1;
        const [lng2, lat2] = coord2;
        return Math.sqrt(Math.pow(lng2 - lng1, 2) + Math.pow(lat2 - lat1, 2));
    }
    
    // Function untuk menentukan zoom level category
    function getZoomCategory(zoom) {
        if (zoom <= ZOOM_SETTINGS.cluster.maxZoom) return 'clustered';
        return 'individual';
    }
    
    // Function untuk limit data berdasarkan zoom level - DIPERBAIKI
    function limitDataByImportance(data, type) {
        // Jangan limit data, tapi prioritaskan berdasarkan importance
        if (data.length <= MAX_MARKERS_PER_TYPE) return data;
        
        // Prioritaskan data dengan count tertinggi
        return data
            .sort((a, b) => {
                const countA = parseInt(a.jumlah || a.jumlah_pendaftar_penjual || a.jumlah_pendaftar_pembeli || 0);
                const countB = parseInt(b.jumlah || b.jumlah_pendaftar_penjual || b.jumlah_pendaftar_pembeli || 0);
                return countB - countA;
            })
            .slice(0, MAX_MARKERS_PER_TYPE);
    }
    
    // Function untuk filter transaksi berdasarkan keyword
    function filterTransactionsByKeyword(keyword) {
        if (!keyword || keyword.trim() === '') {
            return [...transactions];
        }
        
        keyword = keyword.toLowerCase().trim();
        return transactions.filter(item => {
            if (!item.jenis) return false;
            return item.jenis.toLowerCase().includes(keyword);
        });
    }
    
    // PERBAIKAN: Function untuk membuat GeoJSON data yang konsisten
    function createConsistentGeoJSONData(data, countField, zoom) {
        // Limit data berdasarkan importance, bukan zoom
        const limitedData = limitDataByImportance(data, countField);
        
        // Gunakan clustering hanya jika zoom <= 13
        let processedData = limitedData;
        if (zoom <= ZOOM_SETTINGS.cluster.maxZoom) {
            const clusters = smartClusterData(limitedData, zoom);
            processedData = clusters.map(cluster => ({
                coordinates: cluster.coordinates,
                [countField]: cluster.count,
                clustered: cluster.clustered,
                clusterSize: cluster.items.length,
                originalData: cluster.items,
                ...cluster.items[0] // Ambil properties dari item pertama
            }));
        }

        return {
            type: 'FeatureCollection',
            features: processedData.map(item => ({
                type: 'Feature',
                properties: {
                    count: parseInt(item[countField] || 0),
                    clustered: item.clustered || false,
                    clusterSize: item.clusterSize || 1,
                    originalData: item.originalData || [item],
                    ...item
                },
                geometry: {
                    type: 'Point',
                    coordinates: item.coordinates
                }
            }))
        };
    }

    // PERBAIKAN: Function untuk menambahkan markers yang konsisten
    function addConsistentMarkers(type) {
        // Hapus marker lama
        clearMarkers();
        
        const currentZoomLevel = currentZoom;
        let totalVisibleMarkers = 0;
        
        // Update performance monitor
        performanceMonitor.updateZoomLevel(currentZoomLevel);
        performanceMonitor.updateRenderMode(
            currentZoomLevel <= ZOOM_SETTINGS.cluster.maxZoom ? 'Clustered' : 'Individual'
        );
        
        // Tambahkan data dengan clustering yang konsisten
        if (type === 'all' || type === 'transaction') {
            const count = addConsistentCircleLayers('transaction', filteredTransactions, 'jumlah', currentZoomLevel);
            totalVisibleMarkers += count;
        }
        
        if (type === 'all' || type === 'seller') {
            const count = addConsistentCircleLayers('seller', sellers, 'jumlah_pendaftar_penjual', currentZoomLevel);
            totalVisibleMarkers += count;
        }
        
        if (type === 'all' || type === 'buyer') {
            const count = addConsistentCircleLayers('buyer', buyers, 'jumlah_pendaftar_pembeli', currentZoomLevel);
            totalVisibleMarkers += count;
        }
        
        // Update performance monitoring
        performanceMonitor.updateVisibleMarkers(totalVisibleMarkers);
        performanceMonitor.updatePerformanceStatus(totalVisibleMarkers);
    }
    
    // Optimasi: Function untuk clear semua markers dan layers
    function clearMarkers() {
        // Hapus markers
        markers.forEach(m => m.remove());
        markers = [];
        
        // Hapus layers
        Object.values(sourceIds).forEach(id => {
            if (map.getSource(id)) {
                if (map.getLayer(`${id}-circles`)) {
                    map.removeLayer(`${id}-circles`);
                }
                map.removeSource(id);
            }
        });
        
        // Hapus count circles
        const existingCircles = document.querySelectorAll('.count-circle');
        existingCircles.forEach(circle => circle.remove());
    }
    
    // PERBAIKAN: Function untuk menambahkan circle layers yang konsisten
    function addConsistentCircleLayers(dataType, data, countField, zoom) {
        const sourceId = sourceIds[dataType === 'transaction' ? 'transactions' : dataType === 'seller' ? 'sellers' : 'buyers'];
        
        // Buat GeoJSON data yang konsisten
        const geoJsonData = createConsistentGeoJSONData(data, countField, zoom);
        
        if (geoJsonData.features.length === 0) return 0;
        
        // Warna berdasarkan tipe
        const colors = {
            transaction: '#a21caf',
            seller: '#2563eb', 
            buyer: '#22c55e'
        };
        
        // Tambahkan source dengan clustering otomatis Mapbox
        map.addSource(sourceId, {
            type: 'geojson',
            data: geoJsonData,
            cluster: zoom <= ZOOM_SETTINGS.cluster.maxZoom,
            clusterMaxZoom: ZOOM_SETTINGS.cluster.maxZoom,
            clusterRadius: ZOOM_SETTINGS.cluster.radius
        });
        
        // Layer untuk clusters (akan otomatis muncul saat zoom rendah)
        map.addLayer({
            id: `${sourceId}-clusters`,
            type: 'circle',
            source: sourceId,
            filter: ['has', 'point_count'],
            paint: {
                'circle-color': colors[dataType],
                'circle-radius': [
                    'step',
                    ['get', 'point_count'],
                    20, 5,    // radius 20 untuk cluster dengan <5 points
                    25, 10,   // radius 25 untuk cluster dengan 5-10 points
                    30, 20,   // radius 30 untuk cluster dengan 10-20 points
                    35        // radius 35 untuk cluster dengan 20+ points
                ],
                'circle-opacity': 0.8,
                'circle-stroke-width': 2,
                'circle-stroke-color': '#fff'
            }
        });
        
        // Layer untuk cluster count labels
        map.addLayer({
            id: `${sourceId}-cluster-count`,
            type: 'symbol',
            source: sourceId,
            filter: ['has', 'point_count'],
            layout: {
                'text-field': [
                    'case',
                    ['>=', ['get', 'point_count'], 1000],
                    [
                        'concat',
                        ['round', ['/', ['get', 'point_count'], 1000]],
                        'k'
                    ],
                    ['to-string', ['get', 'point_count']]
                ],
                'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                'text-size': 12,
                'text-anchor': 'center'
            },
            paint: {
                'text-color': '#ffffff'
            }
        });
        
        // Layer untuk individual points (akan muncul saat tidak di-cluster)
        map.addLayer({
            id: `${sourceId}-points`,
            type: 'circle',
            source: sourceId,
            filter: ['!', ['has', 'point_count']],
            paint: {
                'circle-radius': [
                    'interpolate', ['linear'], ['get', 'count'],
                    0, 8,
                    10, 12,
                    50, 16,
                    100, 20,
                    500, 24,
                    1000, 28
                ],
                'circle-color': colors[dataType],
                'circle-opacity': 0.8,
                'circle-stroke-width': 2,
                'circle-stroke-color': '#fff'
            }
        });
        
        // Layer untuk point labels (hanya tampil pada zoom tinggi)
        map.addLayer({
            id: `${sourceId}-point-labels`,
            type: 'symbol',
            source: sourceId,
            filter: ['!', ['has', 'point_count']],
            layout: {
                'text-field': [
                    'case',
                    ['>=', ['get', 'count'], 1000],
                    [
                        'concat',
                        ['round', ['/', ['get', 'count'], 1000]],
                        'k'
                    ],
                    ['to-string', ['get', 'count']]
                ],
                'text-font': ['DIN Offc Pro Medium', 'Arial Unicode MS Bold'],
                'text-size': [
                    'interpolate', ['linear'], ['zoom'],
                    12, 0,    // Tidak tampil pada zoom < 12
                    13, 10,   // Mulai tampil pada zoom 13
                    18, 12    // Size maksimal pada zoom 18
                ],
                'text-anchor': 'center'
            },
            paint: {
                'text-color': '#ffffff',
                'text-opacity': [
                    'interpolate', ['linear'], ['zoom'],
                    12, 0,    // Transparan pada zoom < 12
                    13, 1     // Opaque pada zoom >= 13
                ]
            }
        });
        
        // Setup event listeners untuk popup
        setupConsistentPopups(sourceId, dataType);
        
        // Return jumlah features yang ditampilkan
        return geoJsonData.features.length;
    }

    // PERBAIKAN: Function untuk setup popup yang lebih informatif
    function setupConsistentPopups(sourceId, dataType) {
        const popup = new mapboxgl.Popup({
            closeButton: true,
            closeOnClick: false,
            maxWidth: '300px'
        });
        
        const colors = {
            transaction: 'purple',
            seller: 'blue', 
            buyer: 'green'
        };
        
        // Event untuk clusters
        map.on('click', `${sourceId}-clusters`, (e) => {
            const features = map.queryRenderedFeatures(e.point, {
                layers: [`${sourceId}-clusters`]
            });
            
            const clusterId = features[0].properties.cluster_id;
            const pointCount = features[0].properties.point_count;
            const coordinates = features[0].geometry.coordinates.slice();
            
            // Popup untuk cluster dengan opsi expand
            const html = `
                <div class='p-3'>
                    <h3 class="font-bold text-${colors[dataType]}-600 mb-2">
                        ${dataType.charAt(0).toUpperCase() + dataType.slice(1)} Cluster
                    </h3>
                    <p class="mb-2">
                        <span class="font-semibold">Jumlah Lokasi:</span> ${pointCount}
                    </p>
                    <div class="flex space-x-2">
                        <button onclick="expandCluster('${sourceId}', ${clusterId}, [${coordinates}])" 
                                class="bg-${colors[dataType]}-600 text-white px-3 py-1 rounded text-sm hover:bg-${colors[dataType]}-700">
                            Zoom ke Detail
                        </button>
                        <button onclick="showClusterDetails('${sourceId}', ${clusterId})" 
                                class="bg-gray-600 text-white px-3 py-1 rounded text-sm hover:bg-gray-700">
                            Lihat List
                        </button>
                    </div>
                </div>
            `;
            
            popup.setLngLat(coordinates).setHTML(html).addTo(map);
        });
        
        // Event untuk individual points
        map.on('click', `${sourceId}-points`, (e) => {
            const properties = e.features[0].properties;
            const coordinates = e.features[0].geometry.coordinates.slice();
            
            let html = '';
            if (dataType === 'transaction') {
                html = `
                    <div class='p-3'>
                        <h3 class="font-bold text-purple-600 mb-2">Detail Transaksi</h3>
                        <div class="space-y-1">
                            <p><span class="font-semibold">Kecamatan:</span> ${properties.kecamatan}</p>
                            ${properties.desa ? `<p><span class="font-semibold">Desa:</span> ${properties.desa}</p>` : ''}
                            ${properties.jenis ? `<p><span class="font-semibold">Jenis:</span> ${properties.jenis}</p>` : ''}
                            <p class="font-bold text-purple-600 mt-2">Jumlah: ${properties.count}</p>
                        </div>
                        ${properties.clustered ? `<p class="text-xs text-gray-500 mt-2">Cluster dari ${properties.clusterSize} lokasi</p>` : ''}
                    </div>
                `;
            } else if (dataType === 'seller') {
                html = `
                    <div class='p-3'>
                        <h3 class="font-bold text-blue-600 mb-2">Detail Penjual</h3>
                        <div class="space-y-1">
                            <p><span class="font-semibold">Kecamatan:</span> ${properties.kecamatan}</p>
                            <p class="font-bold text-blue-600 mt-2">Jumlah Penjual: ${properties.count}</p>
                        </div>
                        ${properties.clustered ? `<p class="text-xs text-gray-500 mt-2">Cluster dari ${properties.clusterSize} lokasi</p>` : ''}
                    </div>
                `;
            } else if (dataType === 'buyer') {
                html = `
                    <div class='p-3'>
                        <h3 class="font-bold text-green-600 mb-2">Detail Pembeli</h3>
                        <div class="space-y-1">
                            <p><span class="font-semibold">Kecamatan:</span> ${properties.kecamatan}</p>
                            <p class="font-bold text-green-600 mt-2">Jumlah Pembeli: ${properties.count}</p>
                        </div>
                        ${properties.clustered ? `<p class="text-xs text-gray-500 mt-2">Cluster dari ${properties.clusterSize} lokasi</p>` : ''}
                    </div>
                `;
            }
            
            popup.setLngLat(coordinates).setHTML(html).addTo(map);
        });
        
        // Hover effects untuk visual feedback
        map.on('mouseenter', `${sourceId}-clusters`, () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        
        map.on('mouseenter', `${sourceId}-points`, () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        
        map.on('mouseleave', `${sourceId}-clusters`, () => {
            map.getCanvas().style.cursor = '';
        });
        
        map.on('mouseleave', `${sourceId}-points`, () => {
            map.getCanvas().style.cursor = '';
        });
        
        // Return jumlah features
        return geoJsonData.features.length;
    }
    
    // Helper function untuk expand cluster
    window.expandCluster = function(sourceId, clusterId, coordinates) {
        map.getSource(sourceId).getClusterExpansionZoom(clusterId, (err, zoom) => {
            if (err) return;
            map.easeTo({
                center: coordinates,
                zoom: zoom + 1, // Zoom sedikit lebih dalam
                duration: 1000
            });
        });
    };
    
    // Helper function untuk show cluster details
    window.showClusterDetails = function(sourceId, clusterId) {
        map.getSource(sourceId).getClusterLeaves(clusterId, Infinity, 0, (err, features) => {
            if (err) return;
            
            // Buat modal atau popup dengan list semua data dalam cluster
            const detailsList = features.map(feature => {
                const props = feature.properties;
                if (props.jenis) {
                    return `• ${props.kecamatan} - ${props.jenis} (${props.count})`;
                } else {
                    return `• ${props.kecamatan} (${props.count})`;
                }
            }).join('<br>');
            
            const detailPopup = new mapboxgl.Popup({
                closeButton: true,
                closeOnClick: true,
                maxWidth: '400px'
            });
            
            const html = `
                <div class='p-3 max-h-64 overflow-y-auto'>
                    <h3 class="font-bold mb-2">Detail Cluster (${features.length} lokasi)</h3>
                    <div class="text-sm">${detailsList}</div>
                </div>
            `;
            
            detailPopup.setLngLat(features[0].geometry.coordinates).setHTML(html).addTo(map);
        });
    };
    // PERBAIKAN: Handle zoom change yang lebih stabil
    const handleZoomChange = debounce(() => {
        const newZoom = map.getZoom();
        const oldZoom = currentZoom;
        
        currentZoom = newZoom;
        performanceMonitor.updateZoomLevel(newZoom);
        
        // Hanya update jika ada perubahan signifikan dalam clustering behavior
        if (shouldUpdateOnZoom(oldZoom, newZoom)) {
            const filterType = document.getElementById('filterType').value;
            addConsistentMarkers(filterType);
        }
    }, 200); // Lebih responsif

    function addMarkers(type) {
        // Panggil fungsi yang sudah diperbaiki
        addConsistentMarkers(type);
    }

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(position => {
            const { longitude, latitude } = position.coords;

            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [longitude, latitude],
                zoom: 12,
                // Optimasi performa map
                fadeDuration: 0,
                renderWorldCopies: false,
                maxZoom: 18,
                minZoom: 8,
                // Optimasi: Reduce map complexity
                antialias: false,
                preserveDrawingBuffer: false
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
                // Hide loading overlay
                document.getElementById('mapLoading').style.display = 'none';
                
                // Inisialisasi zoom level
                currentZoom = map.getZoom();
                
                // Tampilkan marker awal
                addConsistentMarkers('all');
                
                // Tambahkan legend
                addLegend();
                
                // Inisialisasi sidebar legend selection
                updateSidebarLegendSelection('all');
                
                // Optimasi: Event listener untuk zoom change
                map.on('zoom', handleZoomChange);
                
                // Optimasi: Event listener untuk move end (ketika user berhenti pan/zoom)
                map.on('moveend', debounce(() => {
                    // Hanya update jika zoom berubah signifikan
                    const newZoom = map.getZoom();
                    if (Math.abs(newZoom - currentZoom) > 0.5) {
                        const filterType = document.getElementById('filterType').value;
                        addConsistentMarkers(filterType);
                    }
                }, 300));
            });

            // Optimasi ketika peta digeser
            let filterActive = 'all';
            
            // Event filter by type (all, seller, buyer, transaction)
            document.getElementById('filterType').addEventListener('change', function() {
                filterActive = this.value;
                
                // Auto reset pencarian jika filter bukan "all" atau "transaction"
                if (filterActive !== 'all' && filterActive !== 'transaction') {
                    document.getElementById('searchJenis').value = '';
                    searchKeyword = '';
                    filteredTransactions = [...transactions];
                    document.getElementById('searchStatus').classList.add('hidden');
                }
                
                addConsistentMarkers(filterActive);
                updateSidebarLegendSelection(filterActive);
            });
            
            // Event listeners untuk legend items di sidebar
            setupSidebarLegendListeners();
            
            // Event filter by keyword untuk jenis penjualan
            const searchInput = document.getElementById('searchJenis');
            const searchButton = document.getElementById('searchButton');
            const resetSearchButton = document.getElementById('resetSearchButton');
            
            // Function untuk handle pencarian
            function handleSearch() {
                // Pastikan filter aktif sesuai untuk pencarian
                if (filterActive !== 'all' && filterActive !== 'transaction') {
                    // Otomatis ubah filter ke transaksi jika mencari jenis penjualan
                    document.getElementById('filterType').value = 'transaction';
                    filterActive = 'transaction';
                }
                
                searchKeyword = searchInput.value;
                
                // Filter transaksi berdasarkan keyword
                filteredTransactions = filterTransactionsByKeyword(searchKeyword);
                
                // Update status pencarian
                updateSearchStatus();
                
                // Jika tidak ada hasil, tampilkan alert
                if (filteredTransactions.length === 0 && searchKeyword.trim() !== '') {
                    alert(`Tidak ditemukan jenis penjualan "${searchKeyword}"`);
                    // Reset filter tapi tetap tampilkan keyword
                    filteredTransactions = [...transactions];
                }
                
                // Update tampilan map
                addConsistentMarkers(filterActive);
                
                // Jika ada hasil pencarian, zoom ke hasil pencarian pertama
                if (filteredTransactions.length > 0 && searchKeyword.trim() !== '') {
                    const firstResult = filteredTransactions[0];
                    if (firstResult.coordinates && firstResult.coordinates.length === 2) {
                        map.flyTo({
                            center: firstResult.coordinates,
                            zoom: 14,
                            essential: true
                        });
                    }
                }
            }
            
            // Event search button click
            searchButton.addEventListener('click', handleSearch);
            
            // Event search input enter key
            searchInput.addEventListener('keyup', function(event) {
                if (event.key === 'Enter') {
                    handleSearch();
                }
            });
            
            // Event reset search button
            resetSearchButton.addEventListener('click', resetSearch);
        });
    }
    
    // Function untuk menampilkan status pencarian
    function updateSearchStatus() {
        const statusElement = document.getElementById('searchStatus');
        if (!statusElement) return;
        
        if (searchKeyword && searchKeyword.trim() !== '') {
            statusElement.textContent = `Pencarian: "${searchKeyword}" (${filteredTransactions.length} hasil)`;
            statusElement.classList.remove('hidden');
        } else {
            statusElement.classList.add('hidden');
        }
    }
    
    // Function untuk setup event listeners legend di sidebar
    function setupSidebarLegendListeners() {
        // Get all legend items
        const legendItems = document.querySelectorAll('.legend-item');
        
        legendItems.forEach((item, index) => {
            let clickTimeout;
            
            item.addEventListener('click', function() {
                // Clear any existing timeout for double-click detection
                if (clickTimeout) {
                    clearTimeout(clickTimeout);
                    clickTimeout = null;
                    // Double click - reset to show all
                    document.getElementById('filterType').value = 'all';
                    filterActive = 'all';
                    addConsistentMarkers('all');
                    updateSidebarLegendSelection('all');
                    
                    // Visual feedback for double-click
                    this.style.transform = 'scale(1.05)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 200);
                    
                    return;
                }
                
                // Single click - set timeout for double-click detection
                clickTimeout = setTimeout(() => {
                    let filterValue;
                    
                    // Determine filter value based on index
                    switch(index) {
                        case 0: // Transaksi (purple)
                            filterValue = 'transaction';
                            break;
                        case 1: // Penjual (blue)
                            filterValue = 'seller';
                            break;
                        case 2: // Pembeli (green)
                            filterValue = 'buyer';
                            break;
                        default:
                            filterValue = 'all';
                    }
                    
                    // Update filter dropdown
                    document.getElementById('filterType').value = filterValue;
                    filterActive = filterValue;
                    
                    // Auto reset pencarian jika filter bukan "all" atau "transaction"
                    if (filterActive !== 'all' && filterActive !== 'transaction') {
                        document.getElementById('searchJenis').value = '';
                        searchKeyword = '';
                        filteredTransactions = [...transactions];
                        document.getElementById('searchStatus').classList.add('hidden');
                    }
                    
                    // Apply filter
                    addConsistentMarkers(filterActive);
                    
                    // Update visual selection
                    updateSidebarLegendSelection(filterActive);
                    
                    // Visual feedback
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                    
                    clickTimeout = null;
                }, 300); // 300ms delay for double-click detection
            });
            
            // Hover effects
            item.addEventListener('mouseenter', function() {
                if (!clickTimeout) { // Only hover if not in middle of click detection
                    this.style.transform = 'translateY(-2px)';
                }
            });
            
            item.addEventListener('mouseleave', function() {
                if (!clickTimeout) { // Only reset hover if not in middle of click detection
                    this.style.transform = '';
                }
            });
        });
        
        // Add instruction for double-click  
        const legendTitle = document.querySelector('h3:contains("Kategori Data")') || 
                           Array.from(document.querySelectorAll('h3')).find(h3 => h3.textContent.includes('Kategori Data'));
        if (legendTitle) {
            const legendContainer = legendTitle.closest('div.bg-white');
            if (legendContainer) {
                const doubleClickHint = document.createElement('div');
                doubleClickHint.className = 'mt-2 p-2 bg-gray-50 rounded text-xs text-gray-600 text-center border';
                doubleClickHint.innerHTML = '<i class="fas fa-mouse mr-1"></i> Double-click kategori untuk reset filter';
                legendContainer.appendChild(doubleClickHint);
            }
        }
    }
    
    // Function untuk update visual selection pada legend sidebar
    function updateSidebarLegendSelection(activeFilter) {
        const legendItems = document.querySelectorAll('.legend-item');
        
        legendItems.forEach((item, index) => {
            // Remove all selection states
            item.classList.remove('ring-2', 'ring-purple-400', 'ring-blue-400', 'ring-green-400');
            item.classList.remove('bg-purple-100', 'bg-blue-100', 'bg-green-100');
            
            // Add back original backgrounds
            switch(index) {
                case 0: // Transaksi
                    item.classList.add('bg-purple-50');
                    if (activeFilter === 'transaction') {
                        item.classList.add('ring-2', 'ring-purple-400', 'bg-purple-100');
                    }
                    break;
                case 1: // Penjual
                    item.classList.add('bg-blue-50');
                    if (activeFilter === 'seller') {
                        item.classList.add('ring-2', 'ring-blue-400', 'bg-blue-100');
                    }
                    break;
                case 2: // Pembeli
                    item.classList.add('bg-green-50');
                    if (activeFilter === 'buyer') {
                        item.classList.add('ring-2', 'ring-green-400', 'bg-green-100');
                    }
                    break;
            }
        });
    }
    
    // Function untuk reset pencarian
    function resetSearch() {
        document.getElementById('searchJenis').value = '';
        searchKeyword = '';
        filteredTransactions = [...transactions];
        addConsistentMarkers(filterActive);
        document.getElementById('searchStatus').classList.add('hidden');
    }
    
    // Function untuk menambahkan legend
    function addLegend() {
        const legend = document.createElement('div');
        legend.id = 'map-legend';
        legend.className = 'bg-white rounded-lg shadow-xl border border-gray-200 absolute bottom-5 right-5 max-w-xs';
        legend.style.zIndex = '1000';
        legend.innerHTML = `
            <div class="p-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-gray-800 text-sm flex items-center">
                        <i class="fas fa-palette mr-2 text-blue-600"></i>
                        Kategori Data
                    </h4>
                    <button id="toggle-legend" class="text-gray-400 hover:text-gray-600 text-xs">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>
                
                <div id="legend-content" class="space-y-3">
                    <!-- Transaksi -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-purple-50 hover:bg-purple-100 transition-colors">
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded-full bg-gradient-to-r from-purple-500 to-purple-700 mr-3 shadow-sm flex items-center justify-center">
                                <i class="fas fa-exchange-alt text-white text-xs"></i>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-800">Transaksi</span>
                                <div class="text-xs text-gray-500">Volume perdagangan</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-purple-700" id="legend-transactions">0</div>
                            <div class="text-xs text-gray-500">total</div>
                        </div>
                    </div>
                    
                    <!-- Penjual -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition-colors">
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded-full bg-gradient-to-r from-blue-500 to-blue-700 mr-3 shadow-sm flex items-center justify-center">
                                <i class="fas fa-store text-white text-xs"></i>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-800">Penjual</span>
                                <div class="text-xs text-gray-500">Pendaftar penjual</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-blue-700" id="legend-sellers">0</div>
                            <div class="text-xs text-gray-500">orang</div>
                        </div>
                    </div>
                    
                    <!-- Pembeli -->
                    <div class="flex items-center justify-between p-2 rounded-lg bg-green-50 hover:bg-green-100 transition-colors">
                        <div class="flex items-center">
                            <div class="w-5 h-5 rounded-full bg-gradient-to-r from-green-500 to-green-700 mr-3 shadow-sm flex items-center justify-center">
                                <i class="fas fa-shopping-cart text-white text-xs"></i>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-800">Pembeli</span>
                                <div class="text-xs text-gray-500">Pendaftar pembeli</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-bold text-green-700" id="legend-buyers">0</div>
                            <div class="text-xs text-gray-500">orang</div>
                        </div>
                    </div>
                </div>
                
                <hr class="my-3 border-gray-200">
                
                <div class="text-xs text-gray-500 space-y-1">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        <span>Zoom in untuk melihat detail</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-mouse-pointer mr-2 text-blue-500"></i>
                        <span>Klik cluster untuk zoom otomatis</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-layer-group mr-2 text-blue-500"></i>
                        <span>Data otomatis di-cluster pada zoom rendah</span>
                    </div>
                </div>
            </div>
        `;
        
        document.getElementById('map').appendChild(legend);
        
        // Setup toggle functionality untuk legend
        setupLegendToggle();
        
        // Update data di legend
        updateLegendData();
    }
    
    // Function untuk setup toggle legend
    function setupLegendToggle() {
        const toggleButton = document.getElementById('toggle-legend');
        const legendContent = document.getElementById('legend-content');
        let isCollapsed = false;
        
        toggleButton.addEventListener('click', () => {
            isCollapsed = !isCollapsed;
            
            if (isCollapsed) {
                legendContent.style.display = 'none';
                toggleButton.innerHTML = '<i class="fas fa-chevron-down"></i>';
                document.getElementById('map-legend').classList.add('cursor-pointer');
            } else {
                legendContent.style.display = 'block';
                toggleButton.innerHTML = '<i class="fas fa-chevron-up"></i>';
                document.getElementById('map-legend').classList.remove('cursor-pointer');
            }
        });
        
        // Klik pada legend header juga bisa toggle
        document.getElementById('map-legend').addEventListener('click', (e) => {
            if (isCollapsed && e.target.closest('#legend-content') === null) {
                toggleButton.click();
            }
        });
    }
    
    // Function untuk update data di legend
    function updateLegendData() {
        // Update dengan data yang sudah dihitung
        document.getElementById('legend-transactions').textContent = totalTransactions;
        document.getElementById('legend-sellers').textContent = totalSellers;
        document.getElementById('legend-buyers').textContent = totalBuyers;
    }
});
    </script>
</body>
</html>