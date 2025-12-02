<x-layouts.app>
    <div class="space-y-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <h2 class="text-3xl font-bold">Platillos</h2>
            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                <form method="POST" action="{{ route('platillos.importar') }}" enctype="multipart/form-data" class="flex items-center gap-2 w-full md:w-auto">
                    @csrf
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" class="block text-sm text-gray-500 max-w-[150px] md:max-w-none truncate" />
                    <flux:button type="submit" icon="import" title="Subir excel" class="bg-black-food [&_svg]:text-white hover:!bg-zinc-700 transition-colors cursor-pointer flex-shrink-0"></flux:button>
                </form>

                <form method="GET" action="{{ route('platillos.export') }}">
                    <flux:button type="submit" icon="export" title="Descargar excel" class="bg-black-food [&_svg]:text-white hover:!bg-zinc-700 transition-colors cursor-pointer"></flux:button>
                </form>
                
                {{-- AQUI AGREGAN LA FUNCIONALIDAD DE DESCARGAR EL MENU --}}
                <flux:button icon="download" title="Descargar menú" class="bg-green-600 [&_svg]:text-white hover:!bg-green-700 transition-colors cursor-pointer"/>

                <flux:modal.trigger name="edit-platillo">
                    <flux:button icon="plus" title="Agregar platillo" class="bg-black-food [&_svg]:text-white hover:!bg-zinc-700 transition-colors cursor-pointer"/>
                </flux:modal.trigger>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($platillos as $platillo)
                <flux:modal.trigger name="platillo-{{ $platillo->id }}">
                    <div class="bg-white dark:bg-zinc-900 rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 cursor-pointer shadow hover:shadow-xl transition-shadow">
                        <img src="{{ $platillo->imagen }}" alt="{{ $platillo->nombre }}" class="w-full h-60 object-cover">
                        
                        <div class="p-4 space-y-2">
                            <div>
                                <flux:heading size="xl">{{ $platillo->nombre }}</flux:heading>
                                <flux:badge size="sm" color="lime" class="mt-1 text-black">{{ $platillo->categoria }}</flux:badge>
                            </div>
                            
                            <flux:text class="line-clamp-2">{{ $platillo->descripcion }}</flux:text>
                            
                            <flux:heading size="lg" class="text-green-700">${{ number_format($platillo->precio, 2) }}</flux:heading>
                            
                            <div class="flex gap-2 pt-2 items-end justify-self-end">
                                <flux:button href="{{ route('platillos.show', $platillo->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black hover:!bg-green-600 transition-colors" size="sm"></flux:button>
                                <form method="POST" action="{{ route('platillos.delete', $platillo->id) }}" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <flux:button type="submit" icon="trash" class="bg-black-food [&_svg]:text-white cursor-pointer hover:!bg-zinc-700 transition-colors" size="sm"></flux:button>
                                </form>
                            </div>
                        </div>
                    </div>
                </flux:modal.trigger>
            @endforeach
        </div>
    </div>

    @foreach($platillos as $platillo)
    <flux:modal name="platillo-{{ $platillo->id }}" class="md:w-3/4">
        <div class="space-y-6 px-10">
            <img src="{{ $platillo->imagen }}" class="w-full h-56 object-cover rounded-lg" />

            <flux:heading size="xl">{{ $platillo->nombre }}</flux:heading>

            <flux:text>{{ $platillo->descripcion }}</flux:text>

            <flux:badge size="sm" color="lime" class="mt-1 text-black">{{ $platillo->categoria }}</flux:badge>


            <flux:heading size="xl" class="text-green-700">
                ${{ number_format($platillo->precio, 2) }}
            </flux:heading>

            <div class="flex gap-2 pt-2">
                <flux:button href="{{ route('platillos.show', $platillo->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black hover:!bg-green-600 transition-colors" size="sm"></flux:button>
                <form method="POST" action="{{ route('platillos.delete', $platillo->id) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <flux:button type="submit" icon="trash" class="bg-black-food [&_svg]:text-white cursor-pointer hover:!bg-zinc-700 transition-colors" size="sm"></flux:button>

                </form>
            </div>
        </div>
    </flux:modal>
    @endforeach

    <flux:modal name="edit-platillo" class="md:w-96">
        <div class="space-y-6">
            @if(session('status'))
                <div class="p-3 bg-green-50 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="p-3 bg-red-50 text-red-800 rounded">{{ session('error') }}</div>
            @endif
            <div>
                <flux:heading size="lg">Agregar platillos</flux:heading>
                <flux:text class="mt-2">Agrega un platillo nuevo</flux:text>
            </div>
        </div>
    </flux:modal>

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
                <flux:select label="Categoría" wire:model="categoria">
                    @foreach($categorias as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </flux:select>
                <flux:input label="Imagen" placeholder="Imagen" wire:model='imagen'/>

                <div class="flex">
                    <flux:spacer />
                    <flux:button type="submit" variant="primary">Guardar</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</x-layouts.app>