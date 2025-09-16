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
                                    <h4 class="font-semibold text-blue-800 mb-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>
                                        Detail Lokasi Anda
                                    </h4>
                                    <div class="space-y-2 text-sm">
                                        <div id="locationDetails" class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Latitude:</span>
                                                <span id="currentLat" class="text-blue-800 text-right">-</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Longitude:</span>
                                                <span id="currentLng" class="text-blue-800 text-right">-</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Kelurahan/Desa:</span>
                                                <span id="currentVillage" class="text-blue-800 text-right">-</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Kecamatan:</span>
                                                <span id="currentDistrict" class="text-blue-800 text-right">-</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Kota/Kabupaten:</span>
                                                <span id="currentCity" class="text-blue-800 text-right">-</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Provinsi:</span>
                                                <span id="currentProvince" class="text-blue-800 text-right">-</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-blue-600 font-medium">Kode Pos:</span>
                                                <span id="currentPostalCode" class="text-blue-800 text-right">-</span>
                                            </div>
                                        </div>
                                        <div class="mt-2 pt-2 border-t border-blue-200">
                                            <p id="currentAddress" class="text-blue-700 text-xs italic"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analysis Results -->
            <div id="analysisResults" class="mt-6 hidden">
                <!-- Location-Based Analysis -->
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow-lg p-6 mb-6">
                        <h2 class="text-2xl font-bold text-white mb-2">
                            <i class="fas fa-map-location-dot mr-2"></i>
                            Analisis Berdasarkan Lokasi Anda
                        </h2>
                        <p class="text-indigo-100">
                            Data bisnis di kecamatan dan desa Anda saat ini
                        </p>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Sellers in Your District -->
                        <div class="result-card">
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    <i class="fas fa-store text-blue-500 mr-2"></i>
                                    Penjual di Kecamatan Anda
                                </h3>
                                <div id="sellersInDistrict" class="space-y-3">
                                    <!-- Sellers data will be populated here -->
                                </div>
                            </div>
                        </div>

                        <!-- Buyers in Your District -->
                        <div class="result-card">
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    <i class="fas fa-users text-green-500 mr-2"></i>
                                    Pembeli di Kecamatan Anda
                                </h3>
                                <div id="buyersInDistrict" class="space-y-3">
                                    <!-- Buyers data will be populated here -->
                                </div>
                            </div>
                        </div>

                        <!-- Transactions in Your Village -->
                        <div class="result-card">
                            <div class="bg-white rounded-lg shadow-lg p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    <i class="fas fa-exchange-alt text-purple-500 mr-2"></i>
                                    Transaksi di Desa Anda
                                </h3>
                                <div id="transactionsInVillage" class="space-y-3">
                                    <!-- Transactions data will be populated here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                const locationDetails = await getAddressFromCoordinates(userLocation.lng, userLocation.lat);
                document.getElementById('locationInfo').classList.remove('hidden');

                // Perform general business analysis
                await performBusinessAnalysis(userLocation);

                // Perform location-specific analysis
                await performLocationSpecificAnalysis(locationDetails);

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
                    `https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}&limit=1&types=address,place,locality,neighborhood,district,region,postcode`
                );
                const data = await response.json();
                
                if (data.features && data.features.length > 0) {
                    const feature = data.features[0];
                    const context = feature.context || [];
                    
                    // Extract location components
                    const locationDetails = {
                        address: feature.place_name,
                        village: '',
                        district: '',
                        city: '',
                        province: '',
                        postalCode: ''
                    };

                    // Parse context for Indonesian administrative divisions
                    context.forEach(item => {
                        const itemText = item.text || '';
                        
                        if (item.id.includes('locality') || item.id.includes('neighborhood')) {
                            locationDetails.village = itemText;
                        } else if (item.id.includes('place')) {
                            // For Indonesian locations, place usually contains specific district (kecamatan)
                            // The more specific location should be district/kecamatan
                            if (!locationDetails.district) {
                                locationDetails.district = itemText;
                            }
                        } else if (item.id.includes('district')) {
                            // District in Mapbox is usually more specific (kecamatan level)
                            locationDetails.district = itemText;
                        } else if (item.id.includes('region')) {
                            // Region could be province or city depending on level
                            if (itemText.toLowerCase().includes('jawa') || itemText.toLowerCase().includes('sumatera') || 
                                itemText.toLowerCase().includes('kalimantan') || itemText.toLowerCase().includes('sulawesi') ||
                                itemText.toLowerCase().includes('bali') || itemText.toLowerCase().includes('nusa') ||
                                itemText.toLowerCase().includes('maluku') || itemText.toLowerCase().includes('papua') ||
                                itemText.toLowerCase().includes('west java') || itemText.toLowerCase().includes('east java') ||
                                itemText.toLowerCase().includes('central java') || itemText.toLowerCase().includes('jakarta')) {
                                locationDetails.province = itemText;
                            } else if (itemText.toLowerCase().includes('kota') || itemText.toLowerCase().includes('kabupaten') ||
                                     itemText.toLowerCase().includes('bandung') || itemText.toLowerCase().includes('jakarta') ||
                                     itemText.toLowerCase().includes('surabaya') || itemText.toLowerCase().includes('medan')) {
                                // This should be the city/regency level
                                locationDetails.city = itemText;
                            }
                        } else if (item.id.includes('postcode')) {
                            locationDetails.postalCode = itemText;
                        }
                    });

                    // Enhanced parsing from place_name if context parsing is insufficient
                    if (!locationDetails.district || !locationDetails.city) {
                        const parts = feature.place_name.split(', ');
                        
                        // For address like "Lengkong, Bandung, West Java 40263, Indonesia"
                        if (parts.length >= 2) {
                            // First part is usually village/kelurahan
                            if (!locationDetails.village && parts[0]) {
                                locationDetails.village = parts[0].trim();
                            }
                            
                            // Second part could be district/kecamatan or city
                            if (parts[1]) {
                                const secondPart = parts[1].trim();
                                // If it's a generic city name like "Bandung", it's likely the city
                                if (secondPart.toLowerCase() === 'bandung' || 
                                    secondPart.toLowerCase() === 'jakarta' || 
                                    secondPart.toLowerCase() === 'surabaya') {
                                    if (!locationDetails.city) {
                                        locationDetails.city = `Kota ${secondPart}`;
                                    }
                                    // Use the first part as district if it's different from village
                                    if (!locationDetails.district && locationDetails.village !== parts[0]) {
                                        locationDetails.district = parts[0].trim();
                                    }
                                } else {
                                    // Otherwise, second part is likely district
                                    if (!locationDetails.district) {
                                        locationDetails.district = secondPart;
                                    }
                                }
                            }
                            
                            // Look for city in later parts
                            for (let i = 2; i < parts.length; i++) {
                                const part = parts[i].trim();
                                if (part.toLowerCase().includes('kota') || 
                                    part.toLowerCase().includes('kabupaten') ||
                                    part.toLowerCase().includes('bandung')) {
                                    if (!locationDetails.city) {
                                        locationDetails.city = part;
                                    }
                                    break;
                                }
                            }
                        }
                    }

                    // Set smart defaults for Indonesian context
                    if (!locationDetails.province) {
                        locationDetails.province = 'Jawa Barat';
                    }
                    if (!locationDetails.city) {
                        // Try to infer city from district or use default
                        if (locationDetails.district && locationDetails.district.toLowerCase().includes('bandung')) {
                            locationDetails.city = 'Kota Bandung';
                        } else {
                            locationDetails.city = 'Kota Bandung';
                        }
                    }
                    
                    // Fix district if it's too generic
                    if (locationDetails.district && locationDetails.district.toLowerCase() === 'bandung' && locationDetails.village) {
                        locationDetails.district = locationDetails.village;
                    }

                    // Update UI with location details
                    document.getElementById('currentLat').textContent = lat.toFixed(6);
                    document.getElementById('currentLng').textContent = lng.toFixed(6);
                    document.getElementById('currentVillage').textContent = locationDetails.village || 'Tidak diketahui';
                    document.getElementById('currentDistrict').textContent = locationDetails.district || 'Tidak diketahui';
                    document.getElementById('currentCity').textContent = locationDetails.city || 'Tidak diketahui';
                    document.getElementById('currentProvince').textContent = locationDetails.province || 'Tidak diketahui';
                    document.getElementById('currentPostalCode').textContent = locationDetails.postalCode || 'Tidak diketahui';
                    document.getElementById('currentAddress').textContent = locationDetails.address;

                    return locationDetails;
                }
                
                // Fallback with better defaults
                const fallback = {
                    address: `${lat.toFixed(6)}, ${lng.toFixed(6)}`,
                    village: 'Tidak diketahui',
                    district: 'Tidak diketahui',
                    city: 'Kota Bandung',
                    province: 'Jawa Barat',
                    postalCode: 'Tidak diketahui'
                };
                
                document.getElementById('currentLat').textContent = lat.toFixed(6);
                document.getElementById('currentLng').textContent = lng.toFixed(6);
                document.getElementById('currentVillage').textContent = fallback.village;
                document.getElementById('currentDistrict').textContent = fallback.district;
                document.getElementById('currentCity').textContent = fallback.city;
                document.getElementById('currentProvince').textContent = fallback.province;
                document.getElementById('currentPostalCode').textContent = fallback.postalCode;
                document.getElementById('currentAddress').textContent = fallback.address;
                
                return fallback;
            } catch (error) {
                console.error('Error getting address:', error);
                const errorDetails = {
                    address: `${lat.toFixed(6)}, ${lng.toFixed(6)}`,
                    village: 'Tidak diketahui',
                    district: 'Tidak diketahui', 
                    city: 'Kota Bandung',
                    province: 'Jawa Barat',
                    postalCode: 'Tidak diketahui'
                };
                
                document.getElementById('currentLat').textContent = lat.toFixed(6);
                document.getElementById('currentLng').textContent = lng.toFixed(6);
                document.getElementById('currentVillage').textContent = errorDetails.village;
                document.getElementById('currentDistrict').textContent = errorDetails.district;
                document.getElementById('currentCity').textContent = errorDetails.city;
                document.getElementById('currentProvince').textContent = errorDetails.province;
                document.getElementById('currentPostalCode').textContent = errorDetails.postalCode;
                document.getElementById('currentAddress').textContent = errorDetails.address;
                
                return errorDetails;
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

            // Check if there's any data to analyze
            if (totalTransactions === 0 && totalSellers === 0 && totalBuyers === 0) {
                analysis.innerHTML = `
                    <div class="text-center p-6">
                        <i class="fas fa-chart-bar text-gray-300 text-4xl mb-3"></i>
                        <h4 class="font-semibold text-gray-600 mb-2">Tidak Ada Data Pasar</h4>
                        <p class="text-gray-500 text-sm mb-4">
                            Belum ada data transaksi, penjual, atau pembeli di area sekitar lokasi Anda (radius 5km)
                        </p>
                        <div class="bg-blue-50 rounded-lg p-3">
                            <p class="text-xs text-blue-600">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Ini bisa menjadi peluang untuk menjadi pionir di area yang belum terjamah!
                            </p>
                        </div>
                    </div>
                `;
                return;
            }

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

            // Only add advantages if there's actual data to support them
            if (nearbyData.transactions.length > 0 && avgDistance < 2) {
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

            // Only add historical data advantage if there are actual transactions
            if (nearbyData.transactions.length > 0) {
                locationAdvantagesList.push({
                    icon: 'fas fa-chart-line',
                    title: 'Data Historis Tersedia',
                    description: 'Lokasi memiliki data transaksi historis yang dapat digunakan untuk perencanaan bisnis.'
                });
            }

            if (nearbyData.buyers.length > nearbyData.sellers.length && nearbyData.buyers.length > 0) {
                locationAdvantagesList.push({
                    icon: 'fas fa-users',
                    title: 'Permintaan Tinggi',
                    description: 'Jumlah pembeli potensial lebih banyak dibanding penjual eksisting di area sekitar.'
                });
            }

            // If no advantages found, show empty state
            if (locationAdvantagesList.length === 0) {
                advantages.innerHTML = `
                    <div class="text-center p-6">
                        <i class="fas fa-map-location text-gray-300 text-4xl mb-3"></i>
                        <h4 class="font-semibold text-gray-600 mb-2">Belum Ada Data Keunggulan</h4>
                        <p class="text-gray-500 text-sm mb-4">
                            Tidak ditemukan data bisnis yang cukup untuk menganalisis keunggulan lokasi ini
                        </p>
                        <div class="bg-green-50 rounded-lg p-3">
                            <h5 class="font-semibold text-green-800 mb-2">
                                <i class="fas fa-seedling mr-1"></i>
                                Potensi Tersembunyi:
                            </h5>
                            <ul class="text-xs text-green-700 space-y-1 text-left">
                                <li>• Area virgin untuk bisnis baru</li>
                                <li>• Tidak ada kompetisi yang signifikan</li>
                                <li>• Peluang menjadi market leader</li>
                                <li>• Potensi untuk menciptakan demand baru</li>
                            </ul>
                        </div>
                    </div>
                `;
                return;
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

        async function performLocationSpecificAnalysis(locationDetails) {
            // Analyze data based on user's specific location
            analyzeSellersInDistrict(locationDetails.district);
            analyzeBuyersInDistrict(locationDetails.district);
            analyzeTransactionsInVillage(locationDetails.village);
        }

        function analyzeSellersInDistrict(userDistrict) {
            const sellersContainer = document.getElementById('sellersInDistrict');
            
            if (!userDistrict || userDistrict === 'Tidak diketahui') {
                sellersContainer.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-2"></i>
                        <p class="text-gray-500">Lokasi kecamatan tidak dapat dideteksi dengan akurat</p>
                    </div>
                `;
                return;
            }

            // Find sellers in the same district
            const sellersInSameDistrict = sellers.filter(seller => {
                const sellerDistrict = seller.kecamatan?.toLowerCase().trim();
                const targetDistrict = userDistrict.toLowerCase().trim();
                return sellerDistrict && sellerDistrict.includes(targetDistrict);
            });

            if (sellersInSameDistrict.length === 0) {
                sellersContainer.innerHTML = `
                    <div class="text-center p-6">
                        <i class="fas fa-search text-gray-400 text-3xl mb-3"></i>
                        <h4 class="font-semibold text-gray-600 mb-2">Belum Ada Penjual Terdaftar</h4>
                        <p class="text-sm text-gray-500 mb-4">di Kecamatan ${userDistrict}</p>
                        <div class="bg-blue-50 rounded-lg p-3">
                            <p class="text-xs text-blue-600">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Peluang emas untuk menjadi pioneer di area ini!
                            </p>
                        </div>
                    </div>
                `;
                return;
            }

            // Calculate total sellers
            const totalSellersInDistrict = sellersInSameDistrict.reduce((sum, seller) => 
                sum + parseInt(seller.jumlah_pendaftar_penjual || 0), 0
            );

            // Create simplified, clean layout
            let html = `
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-blue-600 text-white mb-3">
                        <span class="text-2xl font-bold">${totalSellersInDistrict}</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Penjual Terdaftar</h4>
                    <p class="text-sm text-gray-600">di Kecamatan ${userDistrict}</p>
                </div>
            `;

            // Only show detailed breakdown if there are multiple entries or it's useful
            if (sellersInSameDistrict.length > 1) {
                html += `
                    <div class="bg-blue-50 rounded-lg p-4">
                        <h5 class="font-semibold text-blue-800 mb-3 text-center">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Detail Distribusi
                        </h5>
                `;
                
                sellersInSameDistrict.forEach(seller => {
                    const sellerCount = parseInt(seller.jumlah_pendaftar_penjual || 0);
                    const percentage = ((sellerCount / totalSellersInDistrict) * 100).toFixed(1);
                    
                    html += `
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                                <span class="text-sm text-gray-700">${seller.kecamatan}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-blue-700">${sellerCount}</span>
                                <span class="text-xs text-gray-500 ml-1">(${percentage}%)</span>
                            </div>
                        </div>
                    `;
                });
                
                html += `</div>`;
            }

            // Add insights based on the data
            html += `
                <div class="mt-4 p-3 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-2"></i>
                        <div>
                            <p class="text-sm text-blue-700">
                                ${getSellersInsight(totalSellersInDistrict, sellersInSameDistrict.length)}
                            </p>
                        </div>
                    </div>
                </div>
            `;

            sellersContainer.innerHTML = html;
        }

        function getSellersInsight(totalSellers, dataPoints) {
            if (totalSellers > 50) {
                return `Kompetisi cukup ketat dengan ${totalSellers} penjual terdaftar. Pertimbangkan diferensiasi produk atau layanan untuk bersaing.`;
            } else if (totalSellers > 20) {
                return `Persaingan moderat dengan ${totalSellers} penjual. Masih ada ruang untuk bisnis baru dengan strategi yang tepat.`;
            } else if (totalSellers > 0) {
                return `Peluang bagus! Hanya ${totalSellers} penjual terdaftar di area ini, masih banyak space untuk berkembang.`;
            }
            return 'Area potensial untuk memulai bisnis baru!';
        }

        function analyzeBuyersInDistrict(userDistrict) {
            const buyersContainer = document.getElementById('buyersInDistrict');
            
            if (!userDistrict || userDistrict === 'Tidak diketahui') {
                buyersContainer.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-2"></i>
                        <p class="text-gray-500">Lokasi kecamatan tidak dapat dideteksi dengan akurat</p>
                    </div>
                `;
                return;
            }

            // Find buyers in the same district
            const buyersInSameDistrict = buyers.filter(buyer => {
                const buyerDistrict = buyer.kecamatan?.toLowerCase().trim();
                const targetDistrict = userDistrict.toLowerCase().trim();
                return buyerDistrict && buyerDistrict.includes(targetDistrict);
            });

            if (buyersInSameDistrict.length === 0) {
                buyersContainer.innerHTML = `
                    <div class="text-center p-6">
                        <i class="fas fa-search text-gray-400 text-3xl mb-3"></i>
                        <h4 class="font-semibold text-gray-600 mb-2">Belum Ada Pembeli Terdaftar</h4>
                        <p class="text-sm text-gray-500 mb-4">di Kecamatan ${userDistrict}</p>
                        <div class="bg-green-50 rounded-lg p-3">
                            <p class="text-xs text-green-600">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Peluang emas untuk mengembangkan basis pelanggan baru!
                            </p>
                        </div>
                    </div>
                `;
                return;
            }

            // Calculate total buyers
            const totalBuyersInDistrict = buyersInSameDistrict.reduce((sum, buyer) => 
                sum + parseInt(buyer.jumlah_pendaftar_pembeli || 0), 0
            );

            // Create simplified, clean layout
            let html = `
                <div class="text-center mb-6">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-r from-green-500 to-green-600 text-white mb-3">
                        <span class="text-2xl font-bold">${totalBuyersInDistrict}</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-1">Pembeli Potensial</h4>
                    <p class="text-sm text-gray-600">di Kecamatan ${userDistrict}</p>
                </div>
            `;

            // Only show detailed breakdown if there are multiple entries or it's useful
            if (buyersInSameDistrict.length > 1) {
                html += `
                    <div class="bg-green-50 rounded-lg p-4">
                        <h5 class="font-semibold text-green-800 mb-3 text-center">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Detail Distribusi
                        </h5>
                `;
                
                buyersInSameDistrict.forEach(buyer => {
                    const buyerCount = parseInt(buyer.jumlah_pendaftar_pembeli || 0);
                    const percentage = ((buyerCount / totalBuyersInDistrict) * 100).toFixed(1);
                    
                    html += `
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                                <span class="text-sm text-gray-700">${buyer.kecamatan}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold text-green-700">${buyerCount}</span>
                                <span class="text-xs text-gray-500 ml-1">(${percentage}%)</span>
                            </div>
                        </div>
                    `;
                });
                
                html += `</div>`;
            }

            // Add insights based on the data
            html += `
                <div class="mt-4 p-3 bg-gradient-to-r from-emerald-50 to-green-50 rounded-lg border border-green-200">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-green-500 mt-1 mr-2"></i>
                        <div>
                            <p class="text-sm text-green-700">
                                ${getBuyersInsight(totalBuyersInDistrict, buyersInSameDistrict.length)}
                            </p>
                        </div>
                    </div>
                </div>
            `;

            buyersContainer.innerHTML = html;
        }

        function getBuyersInsight(totalBuyers, dataPoints) {
            if (totalBuyers > 100) {
                return `Pasar yang menjanjikan! ${totalBuyers} pembeli potensial terdaftar di area ini menunjukkan demand yang tinggi.`;
            } else if (totalBuyers > 50) {
                return `Market size yang solid dengan ${totalBuyers} pembeli potensial. Peluang bagus untuk berbagai jenis bisnis.`;
            } else if (totalBuyers > 20) {
                return `Base pelanggan yang moderate dengan ${totalBuyers} pembeli. Cocok untuk bisnis dengan target market spesifik.`;
            } else if (totalBuyers > 0) {
                return `${totalBuyers} pembeli terdaftar di area ini. Fokus pada strategi customer acquisition yang tepat sasaran.`;
            }
            return 'Potensi untuk membangun customer base dari nol!';
        }

        function analyzeTransactionsInVillage(userVillage) {
            const transactionsContainer = document.getElementById('transactionsInVillage');
            
            if (!userVillage || userVillage === 'Tidak diketahui') {
                transactionsContainer.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-500 text-2xl mb-2"></i>
                        <p class="text-gray-500">Lokasi desa/kelurahan tidak dapat dideteksi dengan akurat</p>
                    </div>
                `;
                return;
            }

            // Find transactions in the same village
            const transactionsInSameVillage = transactions.filter(transaction => {
                const transactionVillage = transaction.desa?.toLowerCase().trim();
                const targetVillage = userVillage.toLowerCase().trim();
                return transactionVillage && transactionVillage.includes(targetVillage);
            });

            if (transactionsInSameVillage.length === 0) {
                transactionsContainer.innerHTML = `
                    <div class="text-center p-4">
                        <i class="fas fa-search text-gray-400 text-2xl mb-2"></i>
                        <p class="text-gray-500 mb-1">Belum ada data transaksi</p>
                        <p class="text-sm text-gray-400">di Desa/Kelurahan ${userVillage}</p>
                        <div class="mt-3 p-2 bg-purple-50 rounded-lg">
                            <p class="text-xs text-purple-600">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Kesempatan untuk menjadi yang pertama di area ini!
                            </p>
                        </div>
                    </div>
                `;
                return;
            }

            // Sort by transaction count (highest first)
            const sortedTransactions = transactionsInSameVillage
                .map(transaction => ({
                    ...transaction,
                    jumlahInt: parseInt(transaction.jumlah || 0)
                }))
                .sort((a, b) => b.jumlahInt - a.jumlahInt);

            let html = `
                <div class="mb-4 p-3 bg-purple-50 rounded-lg">
                    <h4 class="font-semibold text-purple-800 mb-1">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Desa/Kelurahan ${userVillage}
                    </h4>
                    <p class="text-sm text-purple-600">Ditemukan ${sortedTransactions.length} jenis transaksi</p>
                </div>
            `;

            sortedTransactions.forEach((transaction, index) => {
                const isTop = index < 3;
                const badgeColor = isTop ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600';
                const rankIcon = index === 0 ? 'fas fa-crown' : index === 1 ? 'fas fa-medal' : index === 2 ? 'fas fa-award' : 'fas fa-circle';
                
                html += `
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg ${isTop ? 'bg-gradient-to-r from-yellow-50 to-orange-50' : ''}">
                        <div class="flex items-center">
                            <div class="mr-3">
                                <i class="${rankIcon} ${isTop ? 'text-yellow-600' : 'text-gray-400'}"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">${transaction.jenis}</p>
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-1"></i>
                                    ${transaction.desa}, ${transaction.kecamatan}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="px-2 py-1 rounded-full ${badgeColor} text-sm font-semibold">
                                ${transaction.jumlahInt} transaksi
                            </div>
                            ${isTop ? '<div class="text-xs text-yellow-600 mt-1">Top Performer</div>' : ''}
                        </div>
                    </div>
                `;
            });

            const totalTransactionsInVillage = sortedTransactions.reduce((sum, transaction) => sum + transaction.jumlahInt, 0);
            const topTransaction = sortedTransactions[0];

            html += `
                <div class="mt-4 space-y-3">
                    <div class="p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-purple-800">Total Transaksi</p>
                                <p class="text-sm text-purple-600">di desa/kelurahan Anda</p>
                            </div>
                            <div class="text-2xl font-bold text-purple-700">${totalTransactionsInVillage}</div>
                        </div>
                    </div>
                    ${topTransaction ? `
                    <div class="p-3 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-lg border border-yellow-200">
                        <h5 class="font-semibold text-amber-800 mb-1">
                            <i class="fas fa-star mr-1"></i>
                            Jenis Usaha Paling Populer
                        </h5>
                        <div class="flex items-center justify-between">
                            <span class="text-amber-700">${topTransaction.jenis}</span>
                            <span class="font-bold text-amber-800">${topTransaction.jumlahInt} transaksi</span>
                        </div>
                        <p class="text-xs text-amber-600 mt-1">Peluang terbesar di lokasi Anda saat ini</p>
                    </div>
                    ` : ''}
                </div>
            `;

            transactionsContainer.innerHTML = html;
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
