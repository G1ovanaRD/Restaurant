<?php

return [
    'provider' => env('WEATHER_PROVIDER', 'openweathermap'),
    'key' => env('WEATHER_API_KEY', ''),
    'units' => env('WEATHER_UNITS', 'metric'),
    'lang' => env('WEATHER_LANG', 'es'),
    'base_url' => env('WEATHER_BASE_URL', 'https://api.openweathermap.org/data/2.5'),
    // cache TTL en segundos
    'cache_ttl' => env('WEATHER_CACHE_TTL', 3600),
    // ciudad por defecto para mostrar pronóstico si no se especifica otra
    // Por defecto se fija en San Luis Potosi (puedes cambiarla en .env con WEATHER_DEFAULT_CITY)
    'default_city' => env('WEATHER_DEFAULT_CITY', 'San Luis Potosi'),
];
