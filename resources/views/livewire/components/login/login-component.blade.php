<div class="grid grid-cols-4 grid-row-3 justify-center bg-white w-full h-screen overflow-hidden">

    <div class="relative col-start-1 w-3/4 h-full row-span-3 transition duration-500 ease-in-out transform origin-left hover:scale-150">

        <div class="absolute inset-0 bg-auto bg-center"
            style="background-image: url(https://media-exp1.licdn.com/dms/image/C561BAQHxE9SHfKz_6g/company-background_10000/0?e=2159024400&v=beta&t=XlVltuksEsDRsDWMCskgcScmTKixqgUePDTBuqqbEYE)"></div>

        <div class="absolute inset-0 bg-nav opacity-75 h-full"></div>

        <div class="relative flex-col w-full h-full flex items-center justify-center text-center text-white font-bold">

            <div class="mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="124.01" height="99.208" viewBox="0 0 124.01 99.208">
                    <path id="Logo" d="M163.744,94.3V91.931a.9.9,0,0,0-.9-.9h-3.163a.889.889,0,0,0-.549.193h0l-.289.394a.89.89,0,0,0-.058.31v18.613a.9.9,0,0,0,.9.9h3.163a.9.9,0,0,0,.9-.9v-1.367l19.9,12.859v12.4h-31v-18.6l-43.4-24.8-37.2,24.8v49.6L104.4,187.017v2.329a.9.9,0,0,0,.9.9h3.163a.89.89,0,0,0,.523-.171l.256.171v-.461a.887.887,0,0,0,.118-.436V170.732a.9.9,0,0,0-.9-.9H105.3a.9.9,0,0,0-.9.9v2.105l-19.963-13.6v-12.4h31v18.18l43.4,25.224,37.2-24.8v-49.6Zm19.9,64.94-24.8,17.447-31-17.715V127.031H130.5a.9.9,0,0,0,.9-.9v-3.163a.9.9,0,0,0-.9-.9h-18.32a.9.9,0,0,0-.9.9v3.163a.9.9,0,0,0,.9.9h3.263v7.407h-31v-12.4l24.815-17.447,30.989,17.447-.033,31.464h-3.037a.9.9,0,0,0-.9.9v3.163a.9.9,0,0,0,.9.9h18.32a.9.9,0,0,0,.9-.9V154.4a.9.9,0,0,0-.9-.9h-2.882l.033-6.662h31Z" 
                    transform="translate(-72.038 -91.034)" fill="#fff"/>
                </svg>
            </div>

            <div class="md:text-xl lg:text-3xl xl:text-4xl xxl:text-6xl">
            HYDROGEN HUB
            </div>

            <div class="sm:text-xxs md:text-xs lg:text-sm xl:text-base xxl:text-xl">
            GRONINGEN SEAPORTS
            </div>

        </div>

    </div>

    <h1 class="col-start-3 row-start-1 items-end text-nav font-bold text-6xl sm:text-xl md:text-3xl lg:text-5xl flex justify-center">
        Log in
    </h1>

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
            <a class="inline-block font-bold text-sm sm:text-xxs xxl:text-xl text-gray-600 hover:text-blue-800 underline"
               href="{{route('login.forgotpassword')}}">
                Forgot password?
            </a>
        </div>
        <div class="flex justify-center">
            <button
                class="bg-nav hover:bg-hovBlue text-white text-xs xxl:text-2xl py-2 px-8 rounded-lg focus:outline-none focus:shadow-outline mt-12 transition duration-200 ease-in-out"
                type="submit">
                Login
            </button>
        </div>
    </form>

    <div class="col-start-3 row-start-3 grid justify-center items-end">
        <a href="{{route('company.register')}}"
           class="text-gray-600 underline font-bold text-sm sm:text-xxs xxl:text-xl pb-4 cursor-pointer hover:text-blue-800 duration-200">
            Don't have an account? Get onboard here!
        </a>
    </div>

    <p class="col-start-4 row-start-3 grid justify-end items-end text-gray-500 text-xs sm:text-xxs xxl:text-xl  p-2">
        &copy;2020 Hydrogenhub. All rights reserved.
    </p>

</div>
