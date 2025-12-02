<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $base;
    protected $key;
    protected $units;
    protected $lang;
    protected $ttl;

    public function __construct()
    {
        $this->base = config('weather.base_url');
        $this->key = config('weather.key');
        $this->units = config('weather.units');
        $this->lang = config('weather.lang');
        $this->ttl = (int) config('weather.cache_ttl', 3600);
    }

    /**
     * Obtener clima actual por ciudad (OpenWeatherMap format)
     * Retorna el arreglo decodificado de la respuesta o null si falla.
     */
    public function getCurrentByCity(string $city)
    {
        if (empty($this->key)) {
            return null;
        }

        $cacheKey = 'weather_current_' . strtolower(str_replace(' ', '_', $city));

        return Cache::remember($cacheKey, $this->ttl, function () use ($city) {
            $params = [
                'q' => $city,
                'appid' => $this->key,
                'units' => $this->units,
                'lang' => $this->lang,
            ];

            $response = $this->httpRequest($this->base . '/weather', $params);

            if ($response && $response->ok()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Obtener el forecast (5 días / cada 3 horas) por ciudad.
     * Retorna el arreglo decodificado o null.
     */
    public function getForecastByCity(string $city)
    {
        if (empty($this->key)) {
            return null;
        }

        $cacheKey = 'weather_forecast_' . strtolower(str_replace(' ', '_', $city));

        return Cache::remember($cacheKey, $this->ttl, function () use ($city) {
            $params = [
                'q' => $city,
                'appid' => $this->key,
                'units' => $this->units,
                'lang' => $this->lang,
            ];

            $response = $this->httpRequest($this->base . '/forecast', $params);

            if ($response && $response->ok()) {
                return $response->json();
            }

            // registrar para depuración y propagar un objeto con detalles
            $status = $response ? $response->status() : 0;
            $body = $response ? $response->body() : 'no response';
            Log::error('Weather API forecast error', [
                'city' => $city,
                'status' => $status,
                'body' => $body,
            ]);

            return [
                '__error' => true,
                'status' => $status,
                'body' => $body,
            ];
        });
    }

    /**
     * Ejecuta la petición HTTP considerando entorno local (desactivar verify solo en local)
     * Retorna la instancia de respuesta de la petición o null si falla.
     */
    private function httpRequest(string $url, array $params)
    {
        try {
            if (app()->environment('local') || config('app.debug')) {
                return Http::withOptions(['verify' => false])->get($url, $params);
            }

            return Http::get($url, $params);
        } catch (\Exception $e) {
            Log::error('Weather HTTP request failed', ['url' => $url, 'error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Busca en el forecast la entrada más cercana a la fecha dada.
     * $datetime puede ser una cadena ISO (ej. 2025-12-01T14:30) o timestamp.
     * Retorna el bloque de forecast o null si no se encuentra.
     */
    public function getForecastForDate(string $city, $datetime)
    {
        $forecast = $this->getForecastByCity($city);

        // propagar error si getForecastByCity devolvió detalles de fallo
        if (is_array($forecast) && isset($forecast['__error']) && $forecast['__error'] === true) {
            return $forecast;
        }

        if (!$forecast || empty($forecast['list'])) {
            return null;
        }

        // convertir datetime a timestamp
        $target = is_numeric($datetime) ? (int) $datetime : strtotime($datetime);
        if ($target === false) {
            return null;
        }

        $closest = null;
        $closestDiff = PHP_INT_MAX;

        foreach ($forecast['list'] as $entry) {
            // cada entrada tiene 'dt' (timestamp UTC)
            $entryTs = $entry['dt'] ?? null;
            if (!$entryTs) continue;

            $diff = abs($entryTs - $target);
            if ($diff < $closestDiff) {
                $closestDiff = $diff;
                $closest = $entry;
            }
        }

        return $closest;
    }
}
