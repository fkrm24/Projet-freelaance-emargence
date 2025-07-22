<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class SireneController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        if (!$query || strlen($query) < 3) {
            return response()->json([]);
        }
        // Appel API publique SIRENE
        $url = 'https://recherche-entreprises.api.gouv.fr/search?q=' . urlencode($query) . '&page=1&per_page=10';
        $response = Http::get($url);
        if (!$response->ok()) {
            return response()->json([]);
        }
        $results = [];
        foreach (($response->json()['results'] ?? []) as $item) {
            $etab = $item['etablissement'] ?? [];
            \Log::info('SIRENE ITEM: ' . json_encode($item)); // Pour debug
            $results[] = [
                'nom' => $item['nom_raison_sociale'] ?? $item['nom_complet'] ?? '',
                'adresse' => $item['siege']['geo_adresse'] ?? $item['siege']['adresse'] ?? '',
                'siren' => $etab['siren'] ?? $item['siren'] ?? '',
                'code_naf' => $item['siege']['activite_principale'] ?? '',
            ];
        }
        return response()->json($results);
    }
}
