<x-layouts.app>
    <h2>Mesas</h2>
    <div>
        <flux:modal.trigger name="edit-mesa">
            <flux:button>Agregar</flux:button>
        </flux:modal.trigger>
    </div>

    <div>
        <table>
            <thead>
                <th>Id</th>
                <th>Capacidad</th>
                <th>Ubicacion</th>
                <th>Estado</th>
            </thead>
            <tbody>
                @foreach($mesas as $mesa)
                <tr>
                    <td>{{$mesa->id}}</td>
                    <td>{{$mesa->capacidad}}</td>
                    <td>{{$mesa->ubicacion}}</td>
                    <td>{{$mesa->estado}}</td>
                    <td>
                        <form method="POST" action="{{ route('mesas.delete', $mesa->id) }}">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit">Eliminar</flux:button>
                        </form>
                        <flux:brand href="{{ route('mesas.show', $mesa->id) }}" name="Modificar" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<flux:modal name="edit-mesa" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Agregar mesa</flux:heading>
            <flux:text class="mt-2">Agrega una mesa nueva</flux:text>
        </div>
        <form method="POST" action="{{ route('mesas.save') }}">
            @csrf
            <flux:input label="Capacidad" placeholder="Capacidad" wire:model='capacidad'/>
            <flux:input label="Ubicacion" placeholder="Ubicación" wire:model='ubicacion'/>
            <flux:input label="Estado" placeholder="Estado" wire:model='estado'/>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
</div>
</flux:modal>
</x-layouts.app>