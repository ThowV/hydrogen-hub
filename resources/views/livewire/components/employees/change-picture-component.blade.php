<div class="flex flex-col justify-center items-center">
    @if ($photo)
        Photo Preview:
        @php
            $url = null;
              try {
                 $url = $photo->temporaryUrl();
                 $photoStatus = true;
              }catch (RuntimeException $exception){
                  $this->photoStatus =  false;
              }
        @endphp
        @if($photoStatus)
            <img class="w-24 h-24 max-w-24 max-h-24 rounded-full mb-5 object-fill" src=" {{ $url }}">
        @else
            <span class="error text-red-500">Something went wrong while uploading the file.</span>
        @endif
    @endif
    <img class="w-24 h-24 max-w-24 max-h-24 rounded-full mb-5 object-fill" src="{{auth()->user()->picture_url}}" alt="">


    <form class="flex flex-col text-center gap-20" wire:submit.prevent="save">

        <div wire:loading wire:target="photo">Uploading...</div>

        <p class="xxl:text-lg">Select your new profile picture</p>

        <input class="text-xxs xxl:text-base" type="file" accept="image/*" wire:model="photo">

        @error('photo') <span class="error text-red-500">{{ $message }}</span> @enderror

        <button
            class="col-start-1 col-span-4 m-auto row-start-6 bg-hovBlue text-white px-6 py-1 rounded sm:text-xxs md:text-xs lg:text-xs xl:text-xs xxl:text:lg hover:bg-nav transaction duration-300"
            type="submit">Save
        </button>
    </form>


</div>
