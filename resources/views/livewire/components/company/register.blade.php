<div class="grid grid-cols-4 grid-row-3 justify-center bg-white w-full h-screen overflow-hidden">

    <div class="relative col-start-1 w-3/4 h-full row-span-3 transition duration-500 ease-in-out transform origin-left hover:scale-150">
    
        <div class="absolute inset-0 bg-auto bg-center" style="background-image: url(https://beeldbank.groningen-seaports.com/wp-content/uploads/IMG_9625.jpg)"></div>
                
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

    <div class="col-start-3 row-start-1 flex flex-col justify-end">
        <h1 class="text-nav font-bold text-6xl sm:text-2xl md:text-3xl lg:text-5xl text-center">Register</h1>
        <p class="text-center text-sm xxl:text-2xl sm:text-xxs md:text-xs">To use this platform you need permission from “Groningen Seaports”<P>
    </div>
  

    <form class="col-start-3 row-start-2 flex flex-col justify-center px-20 sm:px-1 md:px-1 text-nav" wire:submit.prevent="submit">
        @if($success)
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded mb-3" role="alert">
                <svg class="fill-current w-4 h-4 mr-2 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path
                        d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/>
                </svg>
                <p>Your request has succesfully been processed. You will get notified shortly. </p>
            </div>
        @endif

        <div class="mb-12">
            <input class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200" 
                wire:model="company_name" id="inline-company-name" type="text" placeholder="Company name">
                @error('company_name') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-12">
            <input class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"                 
                wire:model="company_admin_email"id="inline-email" type="email" placeholder="Administrator mail">
                @error('company_admin_email') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-12">
            <input class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                wire:model="company_admin_first_name" id="inline-first-name" type="text" placeholder="Administrator first name">
                @error('company_admin_first_name') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-12">
            <input class="border-b-2 w-full py-2 font-bold xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                wire:model="company_admin_last_name" id="inline-last-name" type="text" placeholder="Administrator last name">
                @error('company_admin_last_name') <span class="error text-red-500">{{ $message }}</span> @enderror
        </div>
        @error('error') <span class="error text-red-500 mb-3">{{ $message }}</span> @enderror

        <div class="w-full flex justify-center items-center mb-12">
            <label class="px-8 py-2 bg-gray-200 flex justify-center items-center w-2/4 lg:w-3/4 md:w-3/4 sm:w-full rounded-md hover:font-bold transition duration-200 ease-in-out">
                <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600 rounded">
                <span class="ml-4 text-gray-600 text-sm xxl:text-xl">I am not a robot</span>
            </label>
        </div>

        <div class="w-full flex justify-center items-center">
            <a href="/" class="text-gray-600 underline font-bold text-xs sm:text-xxs md:text-xs xxl:text-xl cursor-pointer hover:text-blue-800">
                By clicking “Send request”, you agree to the terms of use.
            </a>
        </div>

        <div class="flex justify-center">
            <button class="bg-nav hover:bg-hovBlue text-white text-xs xxl:text-2xl py-2 xxl:py-4 px-8 rounded-lg focus:outline-none focus:shadow-outline mt-12 transition duration-200 ease-in-out" type="submit">
                Send request
            </button>
        </div>

    </form>
   

    <div class="col-start-3 row-start-3 grid justify-center items-end">
        <a href="/" class="text-gray-600 underline font-bold text-xs sm:text-xxs xxl:text-xl  pb-4 cursor-pointer hover:text-blue-800">
            Already have an account? Log in here!
        </a>
    </div>

    <p class="col-start-4 row-start-3 grid justify-end items-end text-gray-500 text-xs sm:text-xxs xxl:text-xl  p-2">
        &copy;2020 Hydrogenhub. All rights reserved.
    </p>

</div>