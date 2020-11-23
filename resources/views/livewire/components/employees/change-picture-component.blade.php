<div>
    @if ($photo)
        Photo Preview:
        <img class="w-25 max-w-xl" src="{{ $photo->temporaryUrl() }}">
    @endif

    <form wire:submit.prevent="save">
        <input type="file" wire:model="photo">

        @error('photo') <span class="error">{{ $message }}</span> @enderror

        <div wire:loading wire:target="photo">Uploading...</div>
        <button type="submit">Save Photo</button>
    </form>

    <img class="rounded-full shadow max-w-xs" src="{{auth()->user()->picture_url}}" alt="">
</div>
