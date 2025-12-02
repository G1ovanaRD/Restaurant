<x-layouts.app>
    <div>
        <flux:heading size="xl">Modificar usuario</flux:heading>
    </div>
    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6 mt-4">
        @csrf
        <flux:input label="Nombre" placeholder="Nombre" wire:model='name' value="{{ $user->name }}"/>
        <flux:input label="Email" placeholder="Email" type="email" wire:model='email' value="{{ $user->email }}"/>
        <flux:input label="Contraseña" placeholder="Dejar en blanco para mantener la actual" type="password" wire:model='password'/>
        <flux:select label="Rol" wire:model='rol'>
            <option value="admin" {{ $user->rol === 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="cliente" {{ $user->rol === 'cliente' ? 'selected' : '' }}>Cliente</option>
        </flux:select>
        <div class="flex">
            <flux:spacer />
            <flux:button type="submit" variant="primary">Guardar</flux:button>
        </div>
    </form>
</x-layouts.app>