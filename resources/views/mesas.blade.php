<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Mesas</h2>
            <flux:modal.trigger name="edit-mesa">
                <flux:button icon="plus" class="bg-black-food [&_svg]:text-white hover:bg-zinc-700 transition-colors"/>
            </flux:modal.trigger>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Capacidad</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Ubicación</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Estado</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($mesas as $mesa)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $mesa->id }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $mesa->capacidad }} personas</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $mesa->ubicacion }}</td>
                            <td class="px-6 py-4 text-sm">
                                <flux:badge 
                                    :color="$mesa->estado === 'disponible' ? 'green' : ($mesa->estado === 'ocupada' ? 'red' : 'yellow')"
                                    size="sm"
                                >
                                    {{ ucfirst($mesa->estado) }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <flux:button href="{{ route('mesas.show', $mesa->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black" size="sm"></flux:button>
                                    <form method="POST" action="{{ route('mesas.delete', $mesa->id) }}">
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