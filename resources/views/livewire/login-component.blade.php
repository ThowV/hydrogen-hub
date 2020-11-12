<div class="w-full max-w-xs">
    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" wire:submit.prevent="submit">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                email
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" wire:model="email" id="email" type="text" placeholder="email">
            @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror

        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                Password
            </label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" wire:model="password" id="password" type="password" placeholder="******************">
            @error('password') <span class="error text-red-500">{{ $message }}</span> @enderror

        </div>
        <div class="flex items-center justify-around mb-2">
            @error('credentials') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="flex items-center justify-between">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                Sign In
            </button>
            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">
                Forgot Password?
            </a>
        </div>
    </form>
    <p class="text-center text-gray-500 text-xs">
        &copy;2020 Hydrogenhub. All rights reserved.
    </p>
</div>
