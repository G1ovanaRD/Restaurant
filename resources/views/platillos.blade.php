<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Platillos</h2>
            <flux:modal.trigger name="edit-platillo">
                <flux:button>Agregar Platillo</flux:button>
            </flux:modal.trigger>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($platillos as $platillo)
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
                <img src="{{ $platillo->imagen }}" alt="{{ $platillo->nombre }}" class="w-full h-60 object-cover">
                
                <div class="p-4 space-y-3">
                    <div>
                        <flux:heading size="lg">{{ $platillo->nombre }}</flux:heading>
                        <flux:badge size="sm" class="mt-1 bg-green-food text-white">{{ $platillo->categoria }}</flux:badge>
                    </div>
                    
                    <flux:text class="line-clamp-2">{{ $platillo->descripcion }}</flux:text>
                    
                    <flux:heading size="xl" class="text-green-food">${{ number_format($platillo->precio, 2) }}</flux:heading>
                    
                    <div class="flex gap-2 pt-2">
                        <flux:button href="{{ route('platillos.show', $platillo->id) }}" variant="ghost" size="sm" class="flex-1">
                            Editar
                        </flux:button>
                        <form method="POST" action="{{ route('platillos.delete', $platillo->id) }}" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit" variant="danger" size="sm" class="w-full">
                                Eliminar
                            </flux:button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

<flux:modal name="edit-platillo" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Agregar platillos</flux:heading>
            <flux:text class="mt-2">Agrega un platillo nuevo</flux:text>
        </div>
        <form method="POST" action="{{ route('platillos.save') }}">
            @csrf
            <flux:input label="Nombre" placeholder="Nombre" wire:model='nombre'/>
            <flux:textarea label="Descripcion" placeholder="Descripción" wire:model='descripcion'/>
            <flux:input label="Precio" placeholder="Precio" type="number" step="0.01" wire:model='precio'/>
            <flux:input label="Categoría" placeholder="Categoría" wire:model='categoria'/>
            <flux:input label="Imagen" placeholder="Imagen" wire:model='imagen'/>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
</div>
</flux:modal>
</x-layouts.app>