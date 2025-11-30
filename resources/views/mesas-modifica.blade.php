<x-layouts.app>
    <div>
        <flux:heading size="lg">Modificar mesa</flux:heading>
        <flux:text class="mt-2">Modifica la mesa seleccionada</flux:text>
    </div>
    <form method="POST" action="{{ route('mesas.update', $mesa->id) }}">
        @csrf
        <flux:input label="Capacidad" placeholder="Capacidad" wire:model='capacidad' value="{{ $mesa->capacidad }}"/>
        <flux:input label="Ubicacion" placeholder="Ubicación" wire:model='ubicacion' value="{{ $mesa->ubicacion }}"/>
        <flux:input label="Estado" placeholder="Estado" wire:model='estado' value="{{ $mesa->estado }}"/>
        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</x-layouts.app>