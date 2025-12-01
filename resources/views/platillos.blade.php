<x-layouts.app>
    <h2>Platillos</h2>
    <div>
        <flux:modal.trigger name="edit-platillo">
            <flux:button>Agregar</flux:button>
        </flux:modal.trigger>
    </div>

    <div>
        <table>
            <thead>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Imagen</th>
            </thead>
            <tbody>
                @foreach($platillos as $platillo)
                <tr>
                    <td>{{$platillo->id}}</td>
                    <td>{{$platillo->nombre}}</td>
                    <td>{{$platillo->descripcion}}</td>
                    <td>{{$platillo->precio}}</td>
                    <td>{{$platillo->categoria}}</td>
                    <td><img src="{{ $platillo->imagen }}" alt="{{ $platillo->nombre }}" style="max-width: 100px; height: auto;"></td>
                    <td>
                        <form method="POST" action="{{ route('platillos.delete', $platillo->id) }}">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit">Eliminar</flux:button>
                        </form>
                        <flux:brand href="{{ route('platillos.show', $platillo->id) }}" name="Modificar" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
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