<div class="bg-white">
    <img class="h-16" src="{{ auth()->user()->company->logo_path }}" alt="">
    @if($formOpen)
        <form wire:submit.prevent="save" class="flex flex-col">
            <input type="file" wire:model="photo">

            @error('photo') <span class="error text-red-600">{{ $message }}</span> @enderror

            <button class="m-auto bg-hovBlue text-white px-6 py-1 rounded sm:text-xxs md:text-xs lg:text-xs xl:text-xs xxl:text:lg hover:bg-nav transaction duration-300" type="submit">Save Photo</button>
        </form>
    @else
        <button class="underline cursor-pointer" wire:click="toggleForm">Upload picture here</button>
    @endif

    <div wire:loading wire:target="photo">Uploading...</div>
</div>
