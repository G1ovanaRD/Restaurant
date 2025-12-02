<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(WeatherService $weather)
    {
        $this->weather = $weather;
    }

    /**
     * Retorna JSON con el clima actual para la ciudad solicitada.
     * Ruta pensada para consultas AJAX o API internas.
     */
    public function current(Request $request, $city = null)
    {
        $city = $city ?? $request->query('city', null);
        if (!$city) {
            // usar la ciudad por defecto si existe
            $city = config('weather.default_city') ?: null;
        }

        if (!$city) {
            return response()->json(['error' => 'City required'], 422);
        }

        // verificar si existe la clave de API
        if (empty(config('weather.key'))) {
            return response()->json(['error' => 'API key missing (set WEATHER_API_KEY in .env)'], 500);
        }

        // si se solicita una fecha, devolver el forecast para ese día/hora
        $date = $request->query('date', null);
        if ($date) {
            $forecast = $this->weather->getForecastForDate($city, $date);

            // si el servicio devolvió un objeto de error con detalles, reenviarlo
            if (is_array($forecast) && isset($forecast['__error']) && $forecast['__error'] === true) {
                return response()->json([
                    'error' => 'Upstream API error',
                    'status' => $forecast['status'] ?? null,
                    'body' => $forecast['body'] ?? null,
                ], 502);
            }

            if (!$forecast) {
                return response()->json(['error' => 'No forecast available (API returned no data for this city/date)'], 502);
            }

            // enriquecer respuesta con nombre de la ciudad si está disponible
            $resp = [
                'city' => $city,
                'forecast' => $forecast,
            ];

            return response()->json($resp);
        }

        $data = $this->weather->getCurrentByCity($city);

        if (!$data) {
            return response()->json(['error' => 'No data or API key missing'], 502);
        }

        return response()->json($data);
    }
}
