<x-layouts.app>
    <div>
        <flux:heading size="xl" class="font-bold">Modificar platillo</flux:heading>
    </div>
    <form method="POST" action="{{ route('platillos.update', $platillo->id) }}" class="space-y-6 mt-4">
        @csrf
        <flux:input label="Nombre" placeholder="Nombre" wire:model='nombre' value="{{ $platillo->nombre }}" class="border-green-700 focus:border-green-700 focus:ring-green-700"/>
        <flux:textarea label="Descripción" placeholder="Descripción" wire:model='descripcion' class="border-green-700 focus:border-green-700 focus:ring-green-700">{{ $platillo->descripcion }}</flux:textarea>
        <flux:input label="Precio" placeholder="Precio" type="number" step="0.01" wire:model='precio' value="{{ $platillo->precio }}" class="border-green-700 focus:border-green-700 focus:ring-green-700"/>
        <flux:select label="Categoría" wire:model="categoria" class="border-green-700 focus:border-green-700 focus:ring-green-700">
            @foreach($categorias as $value => $label)
                <option value="{{ $value }}" {{ $value == $platillo->categoria ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </flux:select>
        <flux:input label="Imagen" placeholder="Imagen" wire:model='imagen' value="{{ $platillo->imagen }}" class="border-green-700 focus:border-green-700 focus:ring-green-700"/>

        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</x-layouts.app>