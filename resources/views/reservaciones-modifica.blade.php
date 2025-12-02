<x-layouts.app>
    <div>
        <flux:heading size="xl">Modificar reservaciones</flux:heading>
    </div>

    <form method="POST" action="{{ route('reservaciones.update', $reservacion->id) }}" class="space-y-6 mt-4">
        @csrf
        <flux:select label="Mesa" wire:model="mesa_id">
            <option value="" disabled {{ empty($reservacion->mesa_id) ? 'selected' : '' }}>Seleccione una mesa</option>
            @foreach($mesas as $mesa)
                <option value="{{ $mesa->id }}" {{ $mesa->id == $reservacion->mesa_id ? 'selected' : '' }}>
                    Mesa {{ $mesa->id }}
                </option>
            @endforeach
        </flux:select>
        <flux:select label="Cliente" wire:model="user_id">
            <option value="" disabled {{ empty($reservacion->user_id) ? 'selected' : '' }}>Seleccione un cliente</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $reservacion->user_id ? 'selected' : '' }}>
                    {{ $user->name ?? $user->id }}
                </option>
            @endforeach
        </flux:select>
        <flux:input 
            label="Fecha y hora" 
            placeholder="Fecha y hora" 
            type="datetime-local"
            wire:model="fecha_hora"
            value="{{ $reservacion->fecha_hora }}"
        />
        <flux:input 
            label="Número de personas" 
            placeholder="Número de personas" 
            type="number"
            wire:model="numero_personas"
            value="{{ $reservacion->numero_personas }}"
        />
        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</x-layouts.app>