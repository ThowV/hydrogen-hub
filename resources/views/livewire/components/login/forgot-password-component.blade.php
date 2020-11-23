<div class="h-full">
    <div class="grid grid-cols-4 grid-row-3 justify-center bg-white w-full h-full overflow-hidden">

        <div
            class="relative col-start-1 w-3/4 h-full row-span-3 transition duration-500 ease-in-out transform origin-left hover:scale-150 hover:text-red">

            <div class="absolute inset-0 bg-auto bg-center"
                 style="background-image: url(https://news.blr.com/app/uploads/sites/2/2017/04/powerplant4.jpg)"></div>

            <div class="absolute inset-0 bg-nav opacity-75 h-full"></div>

            <div
                class="relative w-full h-full flex items-center justify-center text-center text-white font-bold md:text-xl lg:text-3xl xl:text-4xl xxl:text-6xl">
                GRONINGEN SEAPORTS
            </div>

        </div>

        <div class="col-start-3 row-start-1 flex flex-col justify-end">
            <h1 class="text-nav font-bold text-6xl sm:text-4xl  text-center">Retrieve password</h1>
            <p class="text-center text-sm xxl:text-2xl sm:text-xxs">Enter your email and we'll send instructions on how
                to reset your password.
            <p>
        </div>


        <form class="col-start-3 row-start-2 flex flex-col justify-center px-20 sm:px-1 md:px-1 text-nav"
              wire:submit.prevent="submit">


            <div class="mb-8">
                <input
                    class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                    wire:model="email" id="email" type="text" placeholder="Email">
                @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-center">
                @error('error') <span class="error text-red-500">{{ $message }}</span> @enderror

                @isset($status)
                    {{$status}}
                @endisset
            </div>

            <div class="flex justify-center">
                <button
                    class="bg-nav hover:bg-hovBlue text-white text-xs xxl:text-2xl py-2 xxl:py-4 px-8 rounded-lg focus:outline-none focus:shadow-outline mt-12 transition duration-200 ease-in-out"
                    type="submit">
                    Retrieve password
                </button>
            </div>
        </form>


        <div class="col-start-3 row-start-3 grid justify-center items-end">
            <a href="{{ route('login') }}"
               class="text-gray-600 underline font-bold text-xs sm:text-xxs xxl:text-xl pb-4 cursor-pointer hover:text-blue-800">
                Already have an account? Log in here!
            </a>
        </div>

        <p class="col-start-4 row-start-3 grid justify-end items-end text-gray-500 text-xs sm:text-xxs xxl:text-xl p-2">
            &copy;2020 Hydrogenhub. All rights reserved.
        </p>

    </div>
</div>
