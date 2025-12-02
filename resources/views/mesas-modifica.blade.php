<x-layouts.app>
    <div>
        <flux:heading size="xl">Modificar mesa</flux:heading>
    </div>
    <form method="POST" action="{{ route('mesas.update', $mesa->id) }}" class="space-y-6 mt-4">
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