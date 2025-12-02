<x-layouts.app>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Reservaciones</h1>
            <div>
                <flux:modal.trigger name="edit-reservacion">
                    <flux:button variant="primary">Agregar reservación</flux:button>
                </flux:modal.trigger>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 rounded">{{ session('status') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-50 text-red-800 rounded">{{ session('error') }}</div>
        @endif
        @if(isset($weather) && $weather)
            <div class="mb-6 bg-white shadow-sm rounded-lg p-4 flex items-center gap-4">
                <div class="text-sm text-gray-600">Clima en <span class="font-medium">{{ $weather_city ?? ($weather['name'] ?? '') }}</span></div>
                <div class="text-sm text-gray-700">{{ $weather['weather'][0]['description'] ?? '' }}</div>
                <div class="text-lg font-semibold ml-auto">{{ $weather['main']['temp'] ?? '' }} °C</div>
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
                <div class="text-sm text-gray-700">Listado de reservaciones ({{ $reservaciones->count() }})</div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mesa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha y hora</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Personas</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($reservaciones as $reservacion)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reservacion->id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">Mesa {{ $reservacion->mesa_id }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                @php $cliente = $users->firstWhere('id', $reservacion->user_id); @endphp
                                {{ $cliente?->name ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reservacion->fecha_hora }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $reservacion->numero_personas }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('reservaciones.delete', $reservacion->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" variant="danger">Eliminar</flux:button>
                                    </form>
                                    <flux:brand href="{{ route('reservaciones.show', $reservacion->id) }}" name="Modificar" />
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <flux:modal name="edit-reservacion" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Agregar reservación</flux:heading>
                    <flux:text class="mt-2">Completa los datos para crear una reservación.</flux:text>
                </div>
                <form method="POST" action="{{ route('reservaciones.save') }}">
                    @csrf
                    <div class="grid grid-cols-1 gap-3">
                        <flux:select label="Mesa" wire:model="mesa_id" name="mesa_id">
                            <option value="" disabled selected>Seleccione una mesa</option>
                            @foreach($mesas as $mesa)
                                @php $ocupada = strtolower($mesa->estado) === 'ocupado'; @endphp
                                <option value="{{ $mesa->id }}" {{ $ocupada ? 'disabled' : '' }}>
                                    Mesa {{ $mesa->id }} ({{ $mesa->capacidad }} personas) {{ $ocupada ? ' — Ocupada' : '' }}
                                </option>
                            @endforeach
                        </flux:select>

                        <flux:select label="Cliente" wire:model="user_id" name="user_id">
                            <option value="" disabled selected>Seleccione un cliente</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Fecha y hora" placeholder="Fecha y hora" type="datetime-local" wire:model='fecha_hora' name="fecha_hora"/>
                        <div id="weather-preview" class="text-sm text-gray-600"></div>

                        <flux:input label="Número de personas" placeholder="Número de personas" type="number" wire:model='numero_personas' name="numero_personas"/>

                        @if ($errors->any())
                            <div class="text-sm text-red-600">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="flex justify-end">
                            <flux:button type="submit" variant="primary">Guardar</flux:button>
                        </div>
                    </div>
                </form>
            </div>
        </flux:modal>
    </div>

    <script>
        (function(){
            function findDateInput(){
                var selectors = [
                    'input[wire\\:model="fecha_hora"]',
                    'input[wire\\:model=\'fecha_hora\']',
                    'input[name="fecha_hora"]',
                    'input[id="fecha_hora"]',
                    'input[placeholder="Fecha y hora"]',
                    'input[type="datetime-local"]'
                ];
                for(var i=0;i<selectors.length;i++){
                    try{ var el = document.querySelector(selectors[i]); if(el) return el; }catch(e){}
                }
                var all = document.querySelectorAll('input[type="datetime-local"]');
                return all && all.length ? all[0] : null;
            }

            var dtInput = findDateInput();
            var preview = document.getElementById('weather-preview');
            var defaultCity = '{{ config("weather.default_city") }}';

            function safe(v, fallback){ return (typeof v !== 'undefined' && v !== null) ? v : fallback; }

            function buildCardHtml(entry){
                if(!entry) return '';

                var icon = (entry.weather && entry.weather[0] && entry.weather[0].icon) ? entry.weather[0].icon : null;
                var desc = (entry.weather && entry.weather[0] && entry.weather[0].description) ? entry.weather[0].description : '';
                var temp = entry.main && typeof entry.main.temp !== 'undefined' ? Math.round(entry.main.temp) : '';
                var feels = entry.main && typeof entry.main.feels_like !== 'undefined' ? Math.round(entry.main.feels_like) : '';
                var humidity = entry.main && typeof entry.main.humidity !== 'undefined' ? entry.main.humidity : '';
                var wind = entry.wind && typeof entry.wind.speed !== 'undefined' ? entry.wind.speed : '';
                var dtTxt = entry.dt_txt ? entry.dt_txt : (entry.dt ? new Date(entry.dt * 1000).toLocaleString() : '');

                var iconUrl = icon ? 'https://openweathermap.org/img/wn/' + icon + '@2x.png' : '';

                return '\n' +
                    '<div class="mt-2 p-3 bg-white dark:bg-zinc-900 rounded-lg shadow flex items-center gap-4">' +
                        (iconUrl ? '<img src="' + iconUrl + '" alt="' + desc + '" class="w-16 h-16" />' : '') +
                        '<div class="flex-1">' +
                            '<div class="text-xs text-gray-500">' + dtTxt + '</div>' +
                            '<div class="text-2xl font-semibold text-gray-800 dark:text-white">' + temp + ' °C</div>' +
                            '<div class="text-sm text-gray-600 dark:text-gray-300 capitalize">' + desc + '</div>' +
                            '<div class="text-xs text-gray-400 mt-1">Sensación: ' + feels + ' °C · Humedad: ' + humidity + '% · Viento: ' + wind + ' m/s</div>' +
                        '</div>' +
                    '</div>';
            }

            function showLoading(){ if(preview) preview.innerHTML = '<div class="p-2 text-sm text-gray-600">Consultando pronóstico...</div>'; }
            function showError(msg){ if(preview) preview.innerHTML = '<div class="p-3 bg-red-50 text-red-700 rounded">' + msg + '</div>'; }
            function clearPreview(){ if(preview) preview.innerHTML = ''; }

            function fetchForecastFor(datetime){
                if(!datetime) { clearPreview(); return; }
                var city = defaultCity || '';
                if(!city){ showError('Configura la ciudad por defecto en `WEATHER_DEFAULT_CITY`.'); return; }

                var dt = datetime;
                var url = '/weather?city=' + encodeURIComponent(city) + '&date=' + encodeURIComponent(dt);
                showLoading();

                fetch(url).then(function(res){
                    if(!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                }).then(function(json){
                    // la API devuelve un objeto de error con keys 'status'/'body' o el bloque del forecast
                    if(!json){ showError('Respuesta vacía de la API'); return; }
                    if(json.__error || json.error || json.status >= 400){
                        var body = json.body ? json.body : (json.error ? json.error : 'Error al consultar API');
                        showError('Error consultando API: ' + body);
                        return;
                    }

                    // si la respuesta viene con la estructura completa (forecast/list) buscamos el entry
                    var entry = null;
                    if(json.list && Array.isArray(json.list)){
                        // si el controller devolvió directamente la única entrada, quizá viene en json (ya tratada)
                        // Si el controller devolvió la entrada encontrada, la usamos
                        // En cualquier caso, si json tiene 'dt' usamos json
                        if(json.dt) entry = json;
                        else if(json.list && json.list.length && json.list.length === 1) entry = json.list[0];
                        else {
                            // si el controlador devolvió la lista completa, elegir la primera o la más cercana
                            entry = json.list[0];
                        }
                    } else if(json.forecast) {
                        entry = json.forecast;
                    } else {
                        entry = json;
                    }

                    if(!entry){ showError('Pronóstico no disponible'); return; }
                    if(preview) preview.innerHTML = buildCardHtml(entry);
                }).catch(function(err){
                    showError('Error consultando API');
                    console.error('Weather fetch error:', err);
                });
            }

            if(dtInput){
                dtInput.addEventListener('change', function(e){ var value = e.target.value; if(!value){ clearPreview(); return; } fetchForecastFor(value); });
                if(dtInput.value){ fetchForecastFor(dtInput.value); }
            }
        })();
    </script>
</x-layouts.app>