<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        // Inisialisasi array kosong untuk lokasi
        $locations = [];
        
        return view('maps.index', compact('locations'));
    }
}
