<div class="bg-white">
    @if($formOpen)
        <form wire:submit.prevent="save" class="flex flex-col">
            <input type="file" wire:model="photo">

            <div wire:loading wire:target="photo">Uploading...</div>

            <button
                class="m-auto bg-hovBlue text-white px-6 py-1 rounded sm:text-xxs md:text-xs lg:text-xs xl:text-xs xxl:text:lg hover:bg-nav transaction duration-300"
                type="submit">Save Photo
            </button>
        </form>
    @else
        @if(isset(auth()->user()->company->logo_path))
            <img wire:click="toggleForm" class="h-16 w-16 rounded-full cursor-pointer"
                 src="{{ auth()->user()->company->logo_path }}" alt="">
        @else
            <button class="underline cursor-pointer" wire:click="toggleForm">Upload picture here</button>
        @endif
    @endif

    @error('photo') <span class="error text-red-600">{{ $message }}</span> @enderror
</div>
