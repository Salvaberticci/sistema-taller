<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    public static function getBcvRate()
    {
        return Cache::remember('bcv_rate', 3600, function () {
            try {
                $response = Http::get('https://ve.dolarapi.com/v1/dolares/oficial');
                if ($response->successful()) {
                    return $response->json()['promedio'] ?? 36.50; // Fallback if API fails
                }
            } catch (\Exception $e) {
                // Log error if needed
            }
            return 36.50; // Default fallback
        });
    }

    public static function formatDual($amountUsd)
    {
        $rate = self::getBcvRate();
        $amountVes = $amountUsd * $rate;
        
        return [
            'usd' => '$' . number_format($amountUsd, 2),
            'ves' => 'Bs. ' . number_format($amountVes, 2),
            'rate' => $rate
        ];
    }
}
