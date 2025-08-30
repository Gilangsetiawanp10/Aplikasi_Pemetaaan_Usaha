<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingService
{
  protected string $base = 'https://sijuling.wirausaha.web.id/module';

  /**
   * Ambil isi tabel dari sebuah endpoint
   */
  protected function scrapeTable(string $endpoint, string $tableId = 'default_tabel'): array
  {
    $url = $this->base . '/' . $endpoint;

    // retry 3x, timeout 30 detik
    $response = Http::retry(3, 5000)
      ->timeout(30)
      ->get($url);

    if (!$response->successful()) {
      return [];
    }

    $crawler = new Crawler($response->body());

    $cells = $crawler->filter("tbody td")->each(function ($cell) {
      // dd($cell->text());
      return trim($cell->text());
    });

    return $cells;
  }

  public function getTransaksi(): array
  {
    $scraper = $this->scrapeTable('cek_transaksi.php');
    $results = [];
    // group per 4 kolom
    foreach (array_chunk($scraper, 4) as $chunk) {
      if (count($chunk) === 4) {
        // Abaikan jika kecamatan "Tidak Diketahui"
        if (trim($chunk[0]) === 'Tidak Diketahui') {
          continue;
        }
        $results[] = [
          'kecamatan' => $chunk[0],
          'desa'      => $chunk[1],
          'jenis'     => $chunk[2],
          'jumlah'    => $chunk[3],
        ];
      }
    }

    return $results;
  }

  public function getPembeli(): array
  {
    $scraper = $this->scrapeTable('cek_pembeli.php');
    $results = [];
    // group per 2 kolom
    foreach (array_chunk($scraper, 2) as $chunk) {
      if (count($chunk) === 2) {
        $results[] = [
          'jumlah_pendaftar_pembeli' => $chunk[0],
          'kecamatan' => $chunk[1],
        ];
      }
    }

    return $results;
  }

  public function getPenjual(): array
  {
    $scraper = $this->scrapeTable('cek_penjual.php');
    $results = [];
    // group per 2 kolom
    foreach (array_chunk($scraper, 2) as $chunk) {
      if (count($chunk) === 2) {
        $results[] = [
          'jumlah_pendaftar_penjual' => $chunk[0],
          'kecamatan' => $chunk[1],
        ];
      }
    }

    return $results;
  }
}
