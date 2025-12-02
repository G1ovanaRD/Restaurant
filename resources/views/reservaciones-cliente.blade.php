<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Reservaciones</h2>
            <flux:modal.trigger name="edit-reservacion">
                <flux:button icon="plus" class="bg-black-food [&_svg]:text-white hover:bg-zinc-700 transition-colors"/>
            </flux:modal.trigger>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Número de mesa</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Fecha y hora</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Número de personas</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($reservaciones as $reservacion)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $reservacion->mesa_id }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $reservacion->fecha_hora }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $reservacion->numero_personas }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <flux:button href="{{ route('reservacionesCliente.show', $reservacion->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black" size="sm"></flux:button>
                                    <form method="POST" action="{{ route('reservaciones.delete', $reservacion->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" icon="trash" class="bg-black-food [&_svg]:text-white" size="sm"></flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<flux:modal name="edit-reservacion" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Reservar mesa</flux:heading>
        </div>
        <form method="POST" action="{{ route('reservacionesCliente.save', auth()->user()->id) }}">
            @csrf
            <flux:select label="Mesa" wire:model="mesa_id">
                <option value="" disabled selected>Seleccione una mesa</option>
                @foreach($mesas as $mesa)
                    <option value="{{ $mesa->id }}">Mesa {{ $mesa->id }}</option>
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

