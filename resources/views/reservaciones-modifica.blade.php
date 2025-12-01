<x-layouts.app>
    <div>
        <flux:heading size="lg">Modificar reservaciones</flux:heading>
        <flux:text class="mt-2">Modifica todos los detalles de las reservaciones</flux:text>
    </div>
    <form method="POST" action="{{ route('reservaciones.update', $sala->id) }}">
            @csrf
            <flux:select label="Mesa" wire:model="mesa_id">
                <option value="" disabled {{ empty($reservacion->mesa_id) ? 'selected' : '' }}>Seleccione una mesa</option>
                @foreach($mesas as $mesa)
                    <option value="{{ $reservacion->mesa_id }}" {{ $mesa->id === $reservacion->mesa_id ? 'selected' : '' }}>
                        Mesa {{ $mesa->id }}
                    </option>
                @endforeach
            </flux:select>
            <flux:select label="Cliente" wire:model="user_id">
                <option value="" disabled {{ empty($reservacion->user_id) ? 'selected' : '' }}>Seleccione un cliente</option>
                @foreach($users as $user)
                    <option value="{{ $reservacion->user_id }}" {{ $user->id === $reservacion->user_id ? 'selected' : '' }}>
                        {{ $user->id }}
                    </option>
                @endforeach
            </flux:select>
            <flux:input label="Fecha y hora" placeholder="Fecha y hora" type="datetime-local" wire:model='fecha_hora' value={{ $reservacion->fecha_hora }}/>
            <flux:input label="Número de personas" placeholder="Número de personas" type="number" wire:model='numero_personas' value={{ $reservacion->numero_personas }}/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
</x-layouts.app>