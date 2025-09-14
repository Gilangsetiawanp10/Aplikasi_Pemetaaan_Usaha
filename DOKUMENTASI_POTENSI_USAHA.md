# Dokumentasi Halaman Analisis Potensi Usaha

## Deskripsi

Halaman baru yang telah dibuat untuk menganalisis potensi usaha berdasarkan lokasi pengguna. Halaman ini memberikan insight mendalam tentang peluang bisnis di area sekitar pengguna.

## Fitur Utama

### 1. **Peta Interaktif**

-   Menggunakan Mapbox GL JS
-   Menampilkan lokasi pengguna secara real-time
-   Kontrol navigasi dan geolokasi

### 2. **Button "Potensi Usaha di Lokasi Anda"**

-   Meminta izin akses lokasi pengguna
-   Menampilkan loading indicator saat proses analisis
-   Menampilkan alamat lengkap pengguna

### 3. **Analisis Komprehensif**

#### a. Rekomendasi Usaha

-   Analisis berdasarkan jenis transaksi yang paling sering terjadi di area sekitar
-   Memberikan saran usaha spesifik (kuliner, fashion, elektronik, dll.)
-   Menampilkan volume transaksi untuk setiap kategori

#### b. Analisis Pasar

-   Menghitung rasio pembeli vs penjual
-   Menentukan kondisi pasar (Permintaan Tinggi/Seimbang/Persaingan Tinggi)
-   Memberikan insight strategis berdasarkan kondisi pasar

#### c. Analisis Kompetisi

-   Menampilkan area dengan kompetitor terbanyak
-   Visualisasi persentase kompetitor per kecamatan
-   Strategi kompetisi yang disesuaikan dengan kondisi persaingan

#### d. Keunggulan Lokasi

-   Evaluasi aksesibilitas lokasi
-   Analisis kepadatan aktivitas bisnis
-   Penilaian jangkauan pasar
-   Identifikasi keunggulan kompetitif lokasi

### 4. **Statistik Detail**

-   Total transaksi di area sekitar (radius 5km)
-   Total penjual terdaftar
-   Total pembeli potensial
-   Visualisasi data dengan ikon dan warna yang menarik

## Teknologi yang Digunakan

### Backend

-   **Laravel Framework**: Routing dan controller logic
-   **Mapbox Geocoding API**: Konversi koordinat ke alamat
-   **Model Location**: Akses data lokasi dari database
-   **ScrapingService**: Pengambilan data transaksi, penjual, dan pembeli

### Frontend

-   **Mapbox GL JS**: Peta interaktif
-   **Tailwind CSS**: Styling dan responsive design
-   **Font Awesome**: Icons
-   **JavaScript ES6+**: Logic analisis dan interaktivitas

## Cara Mengakses

1. **Dari Halaman Utama**: Klik button "Analisis Potensi Usaha" di navbar
2. **URL Langsung**: `/potensi`
3. **Route Name**: `maps.potensi`

## Algoritma Analisis

### 1. Pencarian Data Terdekat

-   Menggunakan formula Haversine untuk menghitung jarak
-   Radius default: 5km dari lokasi pengguna
-   Filter data transaksi, penjual, dan pembeli dalam radius

### 2. Analisis Rekomendasi Bisnis

-   Menghitung frekuensi per jenis transaksi
-   Sorting berdasarkan volume terbesar
-   Mapping jenis transaksi ke rekomendasi usaha spesifik

### 3. Evaluasi Kondisi Pasar

-   Rasio = Total Pembeli / Total Penjual
-   Rasio > 2: Permintaan Tinggi
-   Rasio 1-2: Seimbang
-   Rasio < 1: Persaingan Tinggi

### 4. Analisis Kompetisi

-   Grouping penjual berdasarkan kecamatan
-   Perhitungan persentase distribusi kompetitor
-   Strategi disesuaikan dengan tingkat persaingan

## File yang Dimodifikasi/Dibuat

1. **resources/views/maps/potensi.blade.php** (Baru)
2. **routes/web.php** (Modified - tambah route)
3. **app/Http/Controllers/MapController.php** (Modified - tambah method potensi())
4. **resources/views/maps/index.blade.php** (Modified - tambah link navigation)

## Penggunaan Data

### Sumber Data

-   **Transaksi**: Data dari ScrapingService (sijuling.wirausaha.web.id)
-   **Penjual**: Data pendaftar penjual per kecamatan
-   **Pembeli**: Data pendaftar pembeli per kecamatan
-   **Lokasi**: Database table `locations` untuk koordinat kecamatan/desa

### Flow Data

1. Controller mengambil data dari ScrapingService dan database
2. GeocodingService menambahkan koordinat ke setiap data
3. Frontend JavaScript melakukan analisis berdasarkan lokasi user
4. Hasil analisis ditampilkan dalam bentuk card terstruktur

## Keunggulan

1. **User-Centric**: Analisis berdasarkan lokasi real pengguna
2. **Data-Driven**: Menggunakan data transaksi aktual
3. **Interactive**: Peta yang responsif dan intuitif
4. **Comprehensive**: Analisis multi-aspek (pasar, kompetisi, lokasi)
5. **Actionable**: Rekomendasi yang spesifik dan dapat diimplementasikan
6. **Responsive Design**: Tampilan optimal di desktop dan mobile

## Pengembangan Selanjutnya

1. **Cache Mechanism**: Menyimpan hasil analisis untuk mengurangi load time
2. **Advanced Filtering**: Filter berdasarkan kategori usaha, modal, dll.
3. **Historical Trends**: Analisis tren data historis
4. **Export Feature**: Export hasil analisis ke PDF/Excel
5. **Notification System**: Notifikasi peluang usaha baru
6. **Social Features**: Sharing hasil analisis ke social media
