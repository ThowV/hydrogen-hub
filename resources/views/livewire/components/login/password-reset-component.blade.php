<div>
    <form wire:submit.prevent="submit">
        <input class=" p-2 m-2" type="password" placeholder="password" wire:model="password">
        <input class=" p-2 m-2" type="password" placeholder="password confirmation" wire:model="password_confirmation">
        <input type="submit" value="submit">
        @error('password') <span class="error text-red-500">{{ $message }}</span> @enderror
    </form>
    @if($success)
        <h1 class="text-gray-700 text-2xl">Succes</h1>
    @endif
</div>
