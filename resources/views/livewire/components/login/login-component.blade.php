<div class="grid grid-cols-4 grid-row-3 justify-center bg-white w-full h-screen overflow-hidden">

    <div
        class="relative col-start-1 w-3/4 h-full row-span-3 transition duration-500 ease-in-out transform origin-left hover:scale-150 hover:text-red">

        <div class="absolute inset-0 bg-auto bg-center"
             style="background-image: url(https://media-exp1.licdn.com/dms/image/C561BAQHxE9SHfKz_6g/company-background_10000/0?e=2159024400&v=beta&t=XlVltuksEsDRsDWMCskgcScmTKixqgUePDTBuqqbEYE)"></div>

        <div class="absolute inset-0 bg-nav opacity-75 h-full"></div>

        <div
            class="relative w-full h-full flex items-center justify-center text-center text-white font-bold md:text-xl lg:text-3xl xl:text-4xl xxl:text-6xl">
            GRONINGEN SEAPORTS
        </div>

    </div>

    <h1 class="col-start-3 row-start-1 items-end text-nav font-bold text-6xl sm:text-4xl flex justify-center">Log
        in</h1>

    <form class="col-start-3 row-start-2 flex flex-col justify-center px-20 sm:px-1 md:px-1 text-nav"
          wire:submit.prevent="submit">

        <div class="mb-8">
            <input
                class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                wire:model="email" id="email" type="text" placeholder="Email">
            @error('email') <span class="error text-red-500">{{ $message }}</span> @enderror

        </div>
        <div class="mb-1">
            <input
                class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                wire:model="password" id="password" type="password" placeholder="******************">
            @error('password') <span class="error text-red-500">{{ $message }}</span> @enderror

        </div>
        <div class="flex items-center justify-around mb-2">
            @error('credentials') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>
        <div class="flex justify-end">
            <a class="inline-block font-bold text-sm sm:text-xxs xxl:text-xl  text-gray-600 hover:text-blue-800 underline"
               href="{{route('login.forgotpassword')}}">
                Forgot password?
            </a>
        </div>
        <div class="flex justify-center">
            <button
                class="bg-nav hover:bg-hovBlue text-white text-xs xxl:text-2xl  py-2 px-8 rounded-lg focus:outline-none focus:shadow-outline mt-12 transition duration-200 ease-in-out"
                type="submit">
                Login
            </button>
        </div>
    </form>

    <div class="col-start-3 row-start-3 grid justify-center items-end">
        <a href="{{route('company.register')}}"
           class="text-gray-600 underline font-bold text-xs sm:text-xxs xxl:text-xl  pb-4 cursor-pointer hover:text-blue-800">
            Don't have an account? Get onboard here!
        </a>
    </div>

    <p class="col-start-4 row-start-3 grid justify-end items-end text-gray-500 text-xs sm:text-xxs xxl:text-xl  p-2">
        &copy;2020 Hydrogenhub. All rights reserved.
    </p>

</div>
