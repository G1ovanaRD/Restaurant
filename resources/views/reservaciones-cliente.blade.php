<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Reservaciones</h2>
            <flux:modal.trigger name="edit-reservacion">
                <flux:button icon="plus" class="bg-black-food [&_svg]:text-white hover:bg-zinc-700 transition-colors"/>
            </flux:modal.trigger>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Número de mesa</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Fecha y hora</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Número de personas</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($reservaciones as $reservacion)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $reservacion->mesa_id }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $reservacion->fecha_hora }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $reservacion->numero_personas }}</td>
                            <td class="px-6 py-4 text-sm">
                                                <div class="flex gap-2">
                                                    <flux:button href="{{ route('reservacionesCliente.show', $reservacion->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black" size="sm"></flux:button>
                                                    <flux:button href="{{ route('reservaciones.ticket', $reservacion->id) }}" icon="download" class="bg-zinc-100 text-black" size="sm" title="Generar ticket PDF"></flux:button>
                                                    <form method="POST" action="{{ route('reservaciones.delete', $reservacion->id) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <flux:button type="submit" icon="trash" class="bg-black-food [&_svg]:text-white" size="sm"></flux:button>
                                                    </form>
                                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<flux:modal name="edit-reservacion" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Reservar mesa</flux:heading>
        </div>
        <form method="POST" action="{{ route('reservacionesCliente.save', auth()->user()->id) }}">
            @csrf
            <flux:select label="Mesa" wire:model="mesa_id">
                <option value="" disabled selected>Seleccione una mesa</option>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}">Mesa {{ $mesa->id }}</option>
                @endforeach
            </flux:select>
            <flux:input label="Fecha y hora" placeholder="Fecha y hora" type="datetime-local" wire:model='fecha_hora' name="fecha_hora"/>
            <div id="weather-preview" class="text-sm text-gray-600"></div>
            <flux:input label="Número de personas" placeholder="Número de personas" type="number" wire:model='numero_personas' name="numero_personas"/>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
    </div>
</flux:modal>
</x-layouts.app>
@if(session('download_ticket'))
    <script>
        (function(){
            var url = {!! json_encode(session('download_ticket')) !!};
            try { window.open(url, '_blank'); } catch(e) { console.warn('No se pudo abrir el ticket automáticamente:', e); }
        })();
    </script>
@endif

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
               
                if(!json){ showError('Respuesta vacía de la API'); return; }
                if(json.__error || json.error || json.status >= 400){
                    var body = json.body ? json.body : (json.error ? json.error : 'Error al consultar API');
                    showError('Error consultando API: ' + body);
                    return;
                }

                var entry = null;
                if(json.list && Array.isArray(json.list)){
                    if(json.dt) entry = json;
                    else if(json.list && json.list.length && json.list.length === 1) entry = json.list[0];
                    else {
                     
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

