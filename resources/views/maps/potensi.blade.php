<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Potensi Usaha</title>
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
        .loading-spinner {
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .result-card {
            transform: translateY(10px);
            opacity: 0;
            animation: slideIn 0.5s ease-out forwards;
        }
        @keyframes slideIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .map-container {
            position: relative;
            height: 500px;
        }
        .analysis-panel {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
            max-width: 350px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-green-600 to-green-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-white text-xl font-bold">
                                <i class="fas fa-chart-line mr-2"></i>
                                Analisis Potensi Usaha
                            </h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" class="text-white hover:text-green-200 transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i>
                            Kembali ke Peta Utama
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Info -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        <i class="fas fa-location-dot text-green-600 mr-2"></i>
                        Temukan Potensi Usaha di Lokasi Anda
                    </h2>
                    <p class="text-gray-600">
                        Analisis mendalam tentang peluang usaha berdasarkan data transaksi, penjual, dan pembeli di sekitar lokasi Anda
                    </p>
                </div>
            </div>

            <!-- Map and Analysis Panel -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="map-container">
                    <div id="map" class="w-full h-full"></div>
                    
                    <!-- Analysis Panel -->
                    <div class="analysis-panel">
                        <div class="bg-white rounded-lg shadow-lg p-4">
                            <button id="analyzeButton" 
                                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-md">
                                <i class="fas fa-search-location mr-2"></i>
                                <span id="buttonText">Potensi Usaha di Lokasi Anda</span>
                                <div id="loadingSpinner" class="loading-spinner ml-2 hidden inline-block"></div>
                            </button>
                            
                            <!-- Location Info -->
                            <div id="locationInfo" class="mt-4 hidden">
                                <div class="bg-blue-50 rounded-lg p-3">
                                    <h4 class="font-semibold text-blue-800 mb-1">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        Lokasi Anda
                                    </h4>
                                    <p id="currentAddress" class="text-blue-700 text-sm"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analysis Results -->
            <div id="analysisResults" class="mt-6 hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Business Recommendations -->
                    <div class="result-card">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                                Rekomendasi Usaha
                            </h3>
                            <div id="businessRecommendations" class="space-y-3">
                                <!-- Recommendations will be populated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Market Analysis -->
                    <div class="result-card">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-chart-bar text-blue-500 mr-2"></i>
                                Analisis Pasar
                            </h3>
                            <div id="marketAnalysis" class="space-y-3">
                                <!-- Market analysis will be populated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Competition Analysis -->
                    <div class="result-card">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-users text-purple-500 mr-2"></i>
                                Analisis Kompetisi
                            </h3>
                            <div id="competitionAnalysis" class="space-y-3">
                                <!-- Competition analysis will be populated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Location Advantages -->
                    <div class="result-card">
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-star text-green-500 mr-2"></i>
                                Keunggulan Lokasi
                            </h3>
                            <div id="locationAdvantages" class="space-y-3">
                                <!-- Location advantages will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Statistics -->
                <div class="result-card mt-6">
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-chart-pie text-indigo-500 mr-2"></i>
                            Statistik Detail Wilayah
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-blue-600 font-medium">Total Transaksi</p>
                                        <p id="totalTransactions" class="text-2xl font-bold text-blue-800">-</p>
                                    </div>
                                    <i class="fas fa-exchange-alt text-blue-500 text-2xl"></i>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-green-600 font-medium">Total Penjual</p>
                                        <p id="totalSellers" class="text-2xl font-bold text-green-800">-</p>
                                    </div>
                                    <i class="fas fa-store text-green-500 text-2xl"></i>
                                </div>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-purple-600 font-medium">Total Pembeli</p>
                                        <p id="totalBuyers" class="text-2xl font-bold text-purple-800">-</p>
                                    </div>
                                    <i class="fas fa-users text-purple-500 text-2xl"></i>
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
        const locations = @json($locations);
        const transactions = @json($transactions);
        const sellers = @json($sellers);
        const buyers = @json($buyers);

        let map;
        let userLocation = null;
        let currentMarker = null;

        document.addEventListener('DOMContentLoaded', function() {
            initializeMap();
            setupEventListeners();
        });

        function initializeMap() {
            map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [107.6191, -6.9175], // Default to Bandung
                zoom: 12
            });

            map.addControl(new mapboxgl.NavigationControl());
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserHeading: true
            }));
        }

        function setupEventListeners() {
            document.getElementById('analyzeButton').addEventListener('click', analyzeLocation);
        }

        async function analyzeLocation() {
            const button = document.getElementById('analyzeButton');
            const buttonText = document.getElementById('buttonText');
            const spinner = document.getElementById('loadingSpinner');

            // Show loading state
            button.disabled = true;
            buttonText.textContent = 'Menganalisis...';
            spinner.classList.remove('hidden');

            try {
                // Get user's current location
                const position = await getCurrentPosition();
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                // Update map center to user location
                map.flyTo({
                    center: [userLocation.lng, userLocation.lat],
                    zoom: 14,
                    duration: 2000
                });

                // Add marker for user location
                if (currentMarker) {
                    currentMarker.remove();
                }

                currentMarker = new mapboxgl.Marker({
                    color: '#ef4444'
                })
                .setLngLat([userLocation.lng, userLocation.lat])
                .setPopup(new mapboxgl.Popup().setHTML('<strong>Lokasi Anda</strong>'))
                .addTo(map);

                // Get address from coordinates
                const address = await getAddressFromCoordinates(userLocation.lng, userLocation.lat);
                document.getElementById('currentAddress').textContent = address;
                document.getElementById('locationInfo').classList.remove('hidden');

                // Perform analysis
                await performBusinessAnalysis(userLocation);

                // Show results
                document.getElementById('analysisResults').classList.remove('hidden');

            } catch (error) {
                console.error('Error analyzing location:', error);
                alert('Gagal mendapatkan lokasi Anda. Pastikan izin lokasi telah diberikan.');
            } finally {
                // Reset button state
                button.disabled = false;
                buttonText.textContent = 'Analisis Ulang';
                spinner.classList.add('hidden');
            }
        }

        function getCurrentPosition() {
            return new Promise((resolve, reject) => {
                if (!navigator.geolocation) {
                    reject(new Error('Geolocation is not supported'));
                    return;
                }

                navigator.geolocation.getCurrentPosition(resolve, reject, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 60000
                });
            });
        }

        async function getAddressFromCoordinates(lng, lat) {
            try {
                const response = await fetch(
                    `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}&limit=1`
                );
                const data = await response.json();
                
                if (data.features && data.features.length > 0) {
                    return data.features[0].place_name;
                }
                return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            } catch (error) {
                return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }
        }

        async function performBusinessAnalysis(location) {
            // Find nearest areas based on user location
            const nearbyData = findNearbyBusinessData(location);

            // Generate business recommendations
            generateBusinessRecommendations(nearbyData);

            // Generate market analysis
            generateMarketAnalysis(nearbyData);

            // Generate competition analysis
            generateCompetitionAnalysis(nearbyData);

            // Generate location advantages
            generateLocationAdvantages(nearbyData);

            // Update statistics
            updateStatistics(nearbyData);
        }

        function findNearbyBusinessData(location, radiusKm = 5) {
            const nearbyTransactions = [];
            const nearbySellers = [];
            const nearbyBuyers = [];

            // Filter transactions within radius
            transactions.forEach(transaction => {
                if (transaction.coordinates && transaction.coordinates.length === 2) {
                    const distance = calculateDistance(
                        location.lat, location.lng,
                        transaction.coordinates[1], transaction.coordinates[0]
                    );
                    if (distance <= radiusKm) {
                        nearbyTransactions.push({...transaction, distance});
                    }
                }
            });

            // Filter sellers within radius
            sellers.forEach(seller => {
                if (seller.coordinates && seller.coordinates.length === 2) {
                    const distance = calculateDistance(
                        location.lat, location.lng,
                        seller.coordinates[1], seller.coordinates[0]
                    );
                    if (distance <= radiusKm) {
                        nearbySellers.push({...seller, distance});
                    }
                }
            });

            // Filter buyers within radius
            buyers.forEach(buyer => {
                if (buyer.coordinates && buyer.coordinates.length === 2) {
                    const distance = calculateDistance(
                        location.lat, location.lng,
                        buyer.coordinates[1], buyer.coordinates[0]
                    );
                    if (distance <= radiusKm) {
                        nearbyBuyers.push({...buyer, distance});
                    }
                }
            });

            return {
                transactions: nearbyTransactions,
                sellers: nearbySellers,
                buyers: nearbyBuyers
            };
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Earth's radius in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        function generateBusinessRecommendations(nearbyData) {
            const recommendations = document.getElementById('businessRecommendations');
            
            // Analyze transaction types to recommend businesses
            const transactionTypes = {};
            nearbyData.transactions.forEach(transaction => {
                const type = transaction.jenis || 'Lainnya';
                transactionTypes[type] = (transactionTypes[type] || 0) + parseInt(transaction.jumlah || 0);
            });

            // Sort by frequency
            const sortedTypes = Object.entries(transactionTypes)
                .sort(([,a], [,b]) => b - a)
                .slice(0, 5);

            let html = '';
            if (sortedTypes.length === 0) {
                html = '<p class="text-gray-500">Belum ada data transaksi di area sekitar untuk analisis yang mendalam.</p>';
            } else {
                sortedTypes.forEach(([type, count], index) => {
                    const recommendation = getBusinessRecommendation(type, count);
                    html += `
                        <div class="border-l-4 border-green-500 bg-green-50 p-3 rounded-r-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-100 text-green-600 font-bold text-sm">
                                        ${index + 1}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <h4 class="font-semibold text-green-800">${recommendation.title}</h4>
                                    <p class="text-sm text-green-700">${recommendation.description}</p>
                                    <p class="text-xs text-green-600 mt-1">
                                        <i class="fas fa-chart-line mr-1"></i>
                                        ${count} transaksi ${type} di area sekitar
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
            
            recommendations.innerHTML = html;
        }

        function getBusinessRecommendation(type, count) {
            const recommendations = {
                'Makanan': {
                    title: 'Usaha Kuliner & Restoran',
                    description: 'Peluang bagus untuk membuka warung makan, katering, atau food truck mengingat tingginya permintaan makanan di area ini.'
                },
                'Minuman': {
                    title: 'Kafe & Kedai Minuman',
                    description: 'Pertimbangkan membuka kafe, juice bar, atau kedai kopi untuk melayani permintaan minuman yang tinggi.'
                },
                'Pakaian': {
                    title: 'Toko Fashion & Butik',
                    description: 'Usaha fashion, butik, atau toko pakaian online memiliki potensi baik di lokasi ini.'
                },
                'Elektronik': {
                    title: 'Toko Elektronik & Gadget',
                    description: 'Service elektronik, toko gadget, atau aksesoris teknologi bisa menjadi pilihan usaha yang menguntungkan.'
                },
                'default': {
                    title: `Usaha ${type}`,
                    description: `Berdasarkan data transaksi, usaha terkait ${type} menunjukkan aktivitas yang baik di area sekitar.`
                }
            };

            return recommendations[type] || recommendations['default'];
        }

        function generateMarketAnalysis(nearbyData) {
            const analysis = document.getElementById('marketAnalysis');
            
            const totalTransactions = nearbyData.transactions.reduce((sum, t) => sum + parseInt(t.jumlah || 0), 0);
            const totalSellers = nearbyData.sellers.reduce((sum, s) => sum + parseInt(s.jumlah_pendaftar_penjual || 0), 0);
            const totalBuyers = nearbyData.buyers.reduce((sum, b) => sum + parseInt(b.jumlah_pendaftar_pembeli || 0), 0);

            const demandSupplyRatio = totalBuyers / (totalSellers || 1);
            
            let marketCondition = '';
            let marketColor = '';
            
            if (demandSupplyRatio > 2) {
                marketCondition = 'Permintaan Tinggi';
                marketColor = 'text-green-600';
            } else if (demandSupplyRatio > 1) {
                marketCondition = 'Seimbang';
                marketColor = 'text-yellow-600';
            } else {
                marketCondition = 'Persaingan Tinggi';
                marketColor = 'text-red-600';
            }

            const html = `
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-blue-700 font-medium">Kondisi Pasar</span>
                        <span class="font-bold ${marketColor}">${marketCondition}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-gray-700 font-medium">Rasio Pembeli vs Penjual</span>
                        <span class="font-bold text-gray-800">${demandSupplyRatio.toFixed(1)}:1</span>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-lg">
                        <h5 class="font-semibold text-indigo-800 mb-2">Insight Pasar:</h5>
                        <p class="text-sm text-indigo-700">
                            ${getMarketInsight(demandSupplyRatio, totalTransactions)}
                        </p>
                    </div>
                </div>
            `;
            
            analysis.innerHTML = html;
        }

        function getMarketInsight(ratio, transactions) {
            if (ratio > 2) {
                return 'Pasar menunjukkan permintaan yang tinggi dengan persaingan rendah. Ini adalah waktu yang baik untuk memulai usaha baru di area ini.';
            } else if (ratio > 1) {
                return 'Pasar dalam kondisi seimbang. Fokus pada diferensiasi produk dan pelayanan untuk menonjol dari kompetitor.';
            } else if (transactions > 50) {
                return 'Meskipun persaingan tinggi, volume transaksi yang besar menunjukkan pasar yang aktif. Pertimbangkan niche market atau inovasi produk.';
            } else {
                return 'Pasar dengan persaingan tinggi dan volume transaksi rendah. Perlu strategi khusus dan riset mendalam sebelum memulai usaha.';
            }
        }

        function generateCompetitionAnalysis(nearbyData) {
            const competition = document.getElementById('competitionAnalysis');
            
            // Group sellers by district
            const sellersByDistrict = {};
            nearbyData.sellers.forEach(seller => {
                const district = seller.kecamatan || 'Tidak Diketahui';
                sellersByDistrict[district] = (sellersByDistrict[district] || 0) + parseInt(seller.jumlah_pendaftar_penjual || 0);
            });

            const topDistricts = Object.entries(sellersByDistrict)
                .sort(([,a], [,b]) => b - a)
                .slice(0, 3);

            let html = '<div class="space-y-3">';
            
            if (topDistricts.length === 0) {
                html += '<p class="text-gray-500">Belum ada data kompetitor di area sekitar.</p>';
            } else {
                html += '<div class="mb-3"><h5 class="font-semibold text-purple-800 mb-2">Area dengan Kompetitor Terbanyak:</h5></div>';
                topDistricts.forEach(([district, count], index) => {
                    const percentage = ((count / nearbyData.sellers.reduce((sum, s) => sum + parseInt(s.jumlah_pendaftar_penjual || 0), 0)) * 100).toFixed(1);
                    html += `
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                            <div>
                                <span class="font-medium text-purple-800">${district}</span>
                                <span class="text-sm text-purple-600 block">${count} penjual (${percentage}%)</span>
                            </div>
                            <div class="w-16 bg-purple-200 rounded-full h-2">
                                <div class="bg-purple-500 h-2 rounded-full" style="width: ${percentage}%"></div>
                            </div>
                        </div>
                    `;
                });

                html += `
                    <div class="p-3 bg-yellow-50 rounded-lg border-l-4 border-yellow-400">
                        <h6 class="font-semibold text-yellow-800 mb-1">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Strategi Kompetisi:
                        </h6>
                        <p class="text-sm text-yellow-700">
                            ${getCompetitionStrategy(topDistricts.length, topDistricts[0]?.[1] || 0)}
                        </p>
                    </div>
                `;
            }
            
            html += '</div>';
            competition.innerHTML = html;
        }

        function getCompetitionStrategy(districtCount, topCompetitorCount) {
            if (topCompetitorCount > 50) {
                return 'Persaingan sangat ketat. Fokus pada spesialisasi produk, pelayanan unggul, atau target market yang berbeda.';
            } else if (topCompetitorCount > 20) {
                return 'Persaingan moderat. Pertimbangkan untuk menawarkan nilai tambah atau lokasi strategis yang belum tergarap.';
            } else {
                return 'Persaingan relatif rendah. Peluang baik untuk masuk pasar dengan strategi penetrasi yang agresif.';
            }
        }

        function generateLocationAdvantages(nearbyData) {
            const advantages = document.getElementById('locationAdvantages');
            
            // Calculate various location metrics
            const avgDistance = nearbyData.transactions.length > 0 ? 
                nearbyData.transactions.reduce((sum, t) => sum + t.distance, 0) / nearbyData.transactions.length : 0;
            
            const businessDensity = nearbyData.transactions.length + nearbyData.sellers.length + nearbyData.buyers.length;
            
            const uniqueDistricts = new Set([
                ...nearbyData.transactions.map(t => t.kecamatan),
                ...nearbyData.sellers.map(s => s.kecamatan),
                ...nearbyData.buyers.map(b => b.kecamatan)
            ]).size;

            const locationAdvantagesList = [];

            if (avgDistance < 2) {
                locationAdvantagesList.push({
                    icon: 'fas fa-walking',
                    title: 'Aksesibilitas Tinggi',
                    description: 'Lokasi sangat mudah dijangkau dengan jarak rata-rata aktivitas bisnis kurang dari 2km.'
                });
            }

            if (businessDensity > 10) {
                locationAdvantagesList.push({
                    icon: 'fas fa-city',
                    title: 'Area Bisnis Aktif',
                    description: 'Berada di zona dengan aktivitas bisnis yang tinggi dan arus pelanggan potensial yang baik.'
                });
            }

            if (uniqueDistricts > 3) {
                locationAdvantagesList.push({
                    icon: 'fas fa-map',
                    title: 'Jangkauan Luas',
                    description: 'Dapat melayani pelanggan dari berbagai kecamatan sekitar dengan mudah.'
                });
            }

            // Add some general advantages
            locationAdvantagesList.push({
                icon: 'fas fa-chart-line',
                title: 'Data Historis Tersedia',
                description: 'Lokasi memiliki data transaksi historis yang dapat digunakan untuk perencanaan bisnis.'
            });

            if (nearbyData.buyers.length > nearbyData.sellers.length) {
                locationAdvantagesList.push({
                    icon: 'fas fa-users',
                    title: 'Permintaan Tinggi',
                    description: 'Jumlah pembeli potensial lebih banyak dibanding penjual eksisting di area sekitar.'
                });
            }

            let html = '<div class="space-y-3">';
            locationAdvantagesList.forEach(advantage => {
                html += `
                    <div class="flex items-start p-3 bg-green-50 rounded-lg">
                        <div class="flex-shrink-0 mt-1">
                            <i class="${advantage.icon} text-green-600"></i>
                        </div>
                        <div class="ml-3">
                            <h5 class="font-semibold text-green-800">${advantage.title}</h5>
                            <p class="text-sm text-green-700">${advantage.description}</p>
                        </div>
                    </div>
                `;
            });
            html += '</div>';

            advantages.innerHTML = html;
        }

        function updateStatistics(nearbyData) {
            const totalTransactions = nearbyData.transactions.reduce((sum, t) => sum + parseInt(t.jumlah || 0), 0);
            const totalSellers = nearbyData.sellers.reduce((sum, s) => sum + parseInt(s.jumlah_pendaftar_penjual || 0), 0);
            const totalBuyers = nearbyData.buyers.reduce((sum, b) => sum + parseInt(b.jumlah_pendaftar_pembeli || 0), 0);

            document.getElementById('totalTransactions').textContent = totalTransactions.toLocaleString();
            document.getElementById('totalSellers').textContent = totalSellers.toLocaleString();
            document.getElementById('totalBuyers').textContent = totalBuyers.toLocaleString();
        }
    </script>
</body>
</html>
