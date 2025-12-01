<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Reservaciones activas</h2>
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
                                    <flux:button href="{{ route('reservaciones.show', $reservacion->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black" size="sm"></flux:button>
                                    <form method="POST" action="{{ route('reservaciones.delete', $reservacion->id) }}">
                                        @csrf
                                        @method('DELETE')
                                    <flux:button href="{{ route('reservaciones.show', $reservacion->id) }}" icon="trash" class="bg-black-food [&_svg]:text-white" size="sm"></flux:button>
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

<flux:modal name="edit-mesa" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Agregar mesa</flux:heading>
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