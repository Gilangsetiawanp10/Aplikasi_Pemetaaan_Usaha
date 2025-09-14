<?php

namespace App\Http\Controllers;

use App\Services\ScrapingService;
use App\Services\GeocodingService;
use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function index(ScrapingService $scrapingService)
    {
        $transactions = $scrapingService->getTransaksi();
        $sellers = $scrapingService->getPenjual();
        $buyers = $scrapingService->getPembeli();

        $geo = new GeocodingService();

        $set_kota = 'Bandung';  // ganti sesuai kebutuhan
        $set_provinsi = 'Jawa Barat';  // ganti sesuai kebutuhan

        // Optimasi: Batching geocoding dan caching
        $geocodingCache = [];
        
        // Function helper untuk get coordinates dengan cache
        $getCoordinatesWithCache = function($kecamatan, $desa = null) use ($geo, $set_kota, $set_provinsi, &$geocodingCache) {
            $cacheKey = $kecamatan . '_' . ($desa ?? 'null');
            
            if (!isset($geocodingCache[$cacheKey])) {
                $geocodingCache[$cacheKey] = $geo->getCoordinates(
                    $kecamatan,
                    $desa,
                    $set_kota,
                    $set_provinsi
                );
            }
            
            return $geocodingCache[$cacheKey];
        };

        // Optimasi: tambah koordinat dan filter data yang valid
        foreach ($transactions as $i => $transaction) {
            $coordinates = $getCoordinatesWithCache(
                $transaction['kecamatan'],
                $transaction['desa'] ?? null
            );
            
            // Hanya simpan jika koordinat valid dan jumlah > 0
            if ($coordinates && (int)($transaction['jumlah'] ?? 0) > 0) {
                $transactions[$i]['coordinates'] = $coordinates;
            } else {
                unset($transactions[$i]); // Hapus data yang tidak valid
            }
        }

        foreach ($sellers as $i => $seller) {
            $coordinates = $getCoordinatesWithCache(
                $seller['kecamatan'],
                $seller['desa'] ?? null
            );
            
            // Hanya simpan jika koordinat valid dan jumlah > 0
            if ($coordinates && (int)($seller['jumlah_pendaftar_penjual'] ?? 0) > 0) {
                $sellers[$i]['coordinates'] = $coordinates;
            } else {
                unset($sellers[$i]); // Hapus data yang tidak valid
            }
        }

        foreach ($buyers as $i => $buyer) {
            $coordinates = $getCoordinatesWithCache(
                $buyer['kecamatan'],
                $buyer['desa'] ?? null
            );
            
            // Hanya simpan jika koordinat valid dan jumlah > 0  
            if ($coordinates && (int)($buyer['jumlah_pendaftar_pembeli'] ?? 0) > 0) {
                $buyers[$i]['coordinates'] = $coordinates;
            } else {
                unset($buyers[$i]); // Hapus data yang tidak valid
            }
        }

        // Optimasi: Re-index array setelah unset
        $transactions = array_values($transactions);
        $sellers = array_values($sellers);
        $buyers = array_values($buyers);

        // Optimasi: Sort data berdasarkan jumlah (descending) untuk prioritas rendering
        usort($transactions, function($a, $b) {
            return (int)($b['jumlah'] ?? 0) - (int)($a['jumlah'] ?? 0);
        });
        
        usort($sellers, function($a, $b) {
            return (int)($b['jumlah_pendaftar_penjual'] ?? 0) - (int)($a['jumlah_pendaftar_penjual'] ?? 0);
        });
        
        usort($buyers, function($a, $b) {
            return (int)($b['jumlah_pendaftar_pembeli'] ?? 0) - (int)($a['jumlah_pendaftar_pembeli'] ?? 0);
        });

        return view('maps.index', compact('transactions', 'sellers', 'buyers'));
    }

    public function geocodeLocation($name)
    {
        $accessToken = env('MAPBOX_TOKEN');
        $query = urlencode($name . ', Kota Bandung, Indonesia');
        $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/{$query}.json?access_token={$accessToken}&limit=1";

        $response = Http::get($url);
        $data = $response->json();

        if (isset($data['features'][0]['center'])) {
            return $data['features'][0]['center']; // [longitude, latitude]
        }
        return null;
    }
}
