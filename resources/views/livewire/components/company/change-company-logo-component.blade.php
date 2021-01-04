<div class="bg-white">
    <img class="h-16" src="{{ auth()->user()->company->logo_path }}" alt="">
    @if($formOpen)
        <form wire:submit.prevent="save">
            <input type="file" wire:model="photo">

            @error('photo') <span class="error text-red-600">{{ $message }}</span> @enderror

            <button class="p-4 bg-green-400 rounded shadow text-white" type="submit">Save Photo</button>
        </form>
    @else
        <button class="underline cursor-pointer" wire:click="toggleForm">Upload picture here</button>
    @endif

    <div wire:loading wire:target="photo">Uploading...</div>
</div>
