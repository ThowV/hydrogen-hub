<div>
    <form class="grid grid-cols-4" wire:submit.prevent="submit">

        <div class="flex flex-col gap-3">
            <h1 class="font-bold text-sm sm:text-xs xxl:text-xl">Old password:</h1>
            <input class="rounded-xl bg-gray-200 w-4/5 px-4 py-1 text-base xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" type="password" placeholder="old password" wire:model="password_old">
            @error('password_old') <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex flex-col gap-3">
            <h1 class="font-bold text-sm sm:text-xs xxl:text-xl">New password:<h1>
            <input class="rounded-xl bg-gray-200 w-4/5 px-4 py-1 text-base xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" type="password" placeholder="password" wire:model="password">
        </div>

        <div class="flex flex-col gap-3">
            <h1 class="font-bold text-sm sm:text-xs xxl:text-xl">Confirm password:<h1>
        <input class="rounded-xl bg-gray-200 w-full px-4 py-1 text-base xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" type="password" placeholder="password confirmation" wire:model="password_confirmation">
        </div>

        <div class="flex flex-col justify-center items-center">
            <input type="submit" value="Save" class="bg-hovBlue text-white px-6 py-1 rounded sm:text-xxs md:text-xs lg:text-xs xl:text-sm xxl:text:lg hover:bg-nav transaction duration-300 cursor-pointer">
            @error('password') <span class="error text-red-500 text-sm text-center">{{ $message }}</span> @enderror
        </div>
        
    </form>

    @if($success)
        <h1 class="text-green-500 text-2xl">Success</h1>
    @endif

</div>
