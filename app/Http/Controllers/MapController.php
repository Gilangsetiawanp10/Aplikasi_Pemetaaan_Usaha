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

        // tambah kordinat setiap wilayah $transactions, $sellers, $buyers
        foreach ($transactions as $i => $transaction) {
            // Simpan kordinat ke dalam transaksi
            $transactions[$i]['coordinates'] = $geo->getCoordinates(
                $transaction['kecamatan'],
                $transaction['desa'] ?? null,
                $set_kota,
                $set_provinsi
            );
        }

        foreach ($sellers as $i => $seller) {
            // Simpan kordinat ke dalam seller
            $sellers[$i]['coordinates'] = $geo->getCoordinates(
                $seller['kecamatan'],
                $seller['desa'] ?? null,
                $set_kota,
                $set_provinsi
            );
        }

        foreach ($buyers as $i => $buyer) {
            // Simpan kordinat ke dalam buyer
            $buyers[$i]['coordinates'] = $geo->getCoordinates(
                $buyer['kecamatan'],
                $buyer['desa'] ?? null,
                $set_kota,
                $set_provinsi
            );
        }

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
