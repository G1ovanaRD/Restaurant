<x-layouts.app>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-3xl font-bold">Usuarios</h2>
            <flux:modal.trigger name="edit-user">
                <flux:button icon="plus" class="bg-black-food [&_svg]:text-white hover:bg-zinc-700 transition-colors"/>
            </flux:modal.trigger>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-lg overflow-hidden border border-zinc-200 dark:border-zinc-700">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Nombre</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Rol</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-zinc-900 dark:text-zinc-100">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        @foreach($users as $user)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $user->id }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-zinc-900 dark:text-zinc-100">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <flux:badge 
                                    :color="$user->rol === 'admin' ? 'blue' : 'green'"
                                    size="sm"
                                >
                                    {{ ucfirst($user->rol) }}
                                </flux:badge>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <flux:button href="{{ route('users.show', $user->id) }}" icon="pencil" class="bg-green-food [&_svg]:text-black" size="sm"></flux:button>
                                    <form method="POST" action="{{ route('users.delete', $user->id) }}">
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

<flux:modal name="edit-user" class="md:w-96">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">Agregar usuario</flux:heading>
        </div>
        <form method="POST" action="{{ route('users.save') }}">
            @csrf
            <flux:input label="Nombre" placeholder="Nombre" wire:model='name'/>
            <flux:input label="Email" placeholder="Email" type="email" wire:model='email'/>
            <flux:input label="Contraseña" placeholder="Contraseña" type="password" wire:model='password'/>
            <flux:select label="Rol" wire:model='rol'>
                <option value="admin">Admin</option>
                <option value="cliente">Cliente</option>
            </flux:select>
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
</div>
</flux:modal>
</x-layouts.app>