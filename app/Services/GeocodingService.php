<?php

namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Http;

class GeocodingService
{
  public function getCoordinates(string $district, ?string $village = null, ?string $city = null, ?string $province = null): ?array
  {
    $query = $village ? "$village, Kecamatan $district" : $district;

    // Cek di database dulu
    $location = Location::where('district', $district)
      ->when($village, fn($q) => $q->where('village', $village))
      ->when($city, fn($q) => $q->where('city', $city))
      ->when($province, fn($q) => $q->where('province', $province))
      ->first();

    if ($location && $location->latitude && $location->longitude) {
      return [$location->longitude, $location->latitude];
    }

    // Jika belum ada, geocoding ke Mapbox
    $accessToken = env('MAPBOX_TOKEN');
    $search = urlencode($query . ', ' . ($city ?? '') . ', ' . ($province ?? '') . ', Indonesia');
    $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/{$search}.json?access_token={$accessToken}&limit=1";
    $response = Http::get($url)->json();

    if (isset($response['features'][0]['center'])) {
      [$lng, $lat] = $response['features'][0]['center'];
      // Simpan ke database
      Location::updateOrCreate(
        [
          'district' => $district,
          'village' => $village,
          'city' => $city,
          'province' => $province
        ],
        [
          'latitude' => $lat,
          'longitude' => $lng
        ]
      );
      return [$lng, $lat];
    }
    return null;
  }
}
