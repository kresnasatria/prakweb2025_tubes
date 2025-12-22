<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{
    public function getLocation(Request $request)
    {
        // Dapatkan IP user (atau gunakan IP tertentu)
        // Gunakan IP publik untuk testing di localhost
        $ip = $request->get('ip', $request->ip()); // IP user asli

        // Panggil API ip-api.com
        $response = Http::get("http://ip-api.com/json/{$ip}");

        // Ambil data lokasi
        $location = $response->json();

        // Kirim ke view
        return view('location.show', compact('location'));
    }
}