<x-layouts.app>
    <div>
        <flux:heading size="lg">Modificar platillo</flux:heading>
        <flux:text class="mt-2">Modifica el platillo seleccionado</flux:text>
    </div>
    <form method="POST" action="{{ route('platillos.update', $platillo->id) }}">
        @csrf
        <flux:input label="Nombre" placeholder="Nombre" wire:model='nombre' value="{{ $platillo->nombre }}"/>
        <flux:input label="Descripción" placeholder="Descripción" wire:model='descripcion' value="{{ $platillo->descripcion }}"/>
        <flux:input label="Precio" placeholder="Precio" wire:model='precio' value="{{ $platillo->precio }}"/>
        <flux:input label="Categoría" placeholder="Categoría" wire:model='categoria' value="{{ $platillo->categoria }}"/>
        <flux:input label="Imagen" placeholder="Imagen" wire:model='imagen' value="{{ $platillo->imagen }}"/>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</x-layouts.app>