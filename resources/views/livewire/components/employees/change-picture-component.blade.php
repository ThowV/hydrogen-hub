<div class="flex flex-col justify-center items-center">

    @if ($photo)
        Photo Preview:
        <img class="w-24 h-24 max-w-24 max-h-24 rounded-full mb-5 object-fill" src="{{ $photo->temporaryUrl() }}">
    @endif

    <form class="flex flex-col text-center gap-20" wire:submit.prevent="save">

        <div wire:loading wire:target="photo">Uploading...</div>

        <p class="xxl:text-lg">Select your new profile picture</p>

        <input class="text-xxs xxl:text-base" type="file" wire:model="photo">

        @error('photo') <span class="error">{{ $message }}</span> @enderror

        <button class="col-start-1 col-span-4 m-auto row-start-6 bg-hovBlue text-white px-8 py-2 rounded sm:text-xxs md:text-xxs lg:text-xs xl:text-sm xxl:text:lg hover:bg-nav transaction duration-300" type="submit">Save</button>
    </form>

    <img class="rounded-full shadow max-w-xs" src="{{auth()->user()->picture_url}}" alt="">
    
</div>
