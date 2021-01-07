<div class="grid grid-cols-4">

    <div class="flex flex-col gap-3">
        <h1 class="font-bold text-sm sm:text-xs xxl:text-xl">First name:<h1>
        <input wire:dirty.class="border-red-500" class="form-control rounded-xl bg-gray-200 w-4/5 px-4  py-1 text-base xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl"
               wire:model="employee.first_name" type="text">
        @error('employee.first_name') <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col gap-3">
        <h1 class="font-bold text-sm sm:text-xs xxl:text-xl">Last name:<h1>
        <input wire:dirty.class="border-red-500" class="form-control rounded-xl bg-gray-200 w-4/5 px-4  py-1 text-base xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl"
               wire:model="employee.last_name" type="text">
        @error('employee.last_name') <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div class="flex flex-col gap-3">
        <h1 class="font-bold text-sm sm:text-xs xxl:text-xl">Email:<h1>
        <input wire:dirty.class="border-red-500" class="form-control rounded-xl bg-gray-200 w-full px-4  py-1 text-base xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl"
               wire:model.debounce.10000ms="employee.email" type="text">
        @error('employee.email') <span class="error text-red-500 text-sm">{{ $message }}</span> @enderror
        <p class="text-xxs xxl:text-sm font-medium mt-3 px-4">If you change your email, the verify email procedure starts over.</p>
    </div>

    <div class="flex justify-center items-center sm:items-start">
        <button wire:click="save" class="bg-hovBlue text-white px-6 py-1 rounded sm:text-xxs md:text-xs lg:text-xs xl:text-sm xxl:text:lg hover:bg-nav transaction duration-300">
        Save
        </button>
    </div>

</div>
