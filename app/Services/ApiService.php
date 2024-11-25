<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    public function fetchData()
    {
        $response = Http::get('https://pokeapi.co/api/v2/pokemon/1');

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
