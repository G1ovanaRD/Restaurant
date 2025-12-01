<x-layouts.app>
    <h2>Reservaciones</h2>
    <div>
        <flux:modal.trigger name="edit-reservacion">
            <flux:button>Agregar</flux:button>
        </flux:modal.trigger>
    </div>

    <div>
        <table>
            <thead>
                <th>Id</th>
                <th>Id mesa</th>
                <th>Id cliente</th>
                <th>Nombre cliente</th>
                <th>Fecha y hora</th>
                <th>Personas</th>
            </thead>
            <tbody>
                @foreach($reservaciones as $reservacion)
                <tr>
                    <td>{{$reservacion->id}}</td>
                    <td>{{$reservacion->mesa_id}}</td>
                    <td>{{$reservacion->user_id}}</td>
                    @foreach ($users as $user)
                        @if ($user->id === $reservacion->user_id)
                            <td>{{$user->name}}</td>
                        @endif
                    @endforeach
                    <td>{{$reservacion->fecha_hora}}</td>
                    <td>{{$reservacion->numero_personas}}</td>
                    <td>
                        <form method="POST" action="{{ route('reservaciones.delete', $reservacion->id) }}">
                            @csrf
                            @method('DELETE')
                            <flux:button type="submit">Eliminar</flux:button>
                        </form>
                        <flux:brand href="{{ route('reservaciones.show', $reservacion->id) }}" name="Modificar" />
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<flux:modal name="edit-reservacion" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Agregar reservaciones</flux:heading>
            <flux:text class="mt-2">Agrega una reservación nueva</flux:text>
        </div>
        <form method="POST" action="{{ route('reservaciones.save') }}">
            @csrf
            <flux:select label="Mesa" wire:model="mesa_id">
                <option value="" disabled selected>Seleccione una mesa</option>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}">Mesa {{ $mesa->id }}</option>
                @endforeach
            </flux:select>
            <flux:select label="Cliente" wire:model="user_id">
                <option value="" disabled selected>Seleccione un cliente</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </flux:select>
            <flux:input label="Fecha y hora" placeholder="Fecha y hora" type="datetime-local" wire:model='fecha_hora'/>
            <flux:input label="Número de personas" placeholder="Número de personas" type="number" wire:model='numero_personas'/>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
</div>
</flux:modal>
</x-layouts.app>