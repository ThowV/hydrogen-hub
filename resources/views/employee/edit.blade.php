@extends('layouts.app')

@section('content')
<div class="flex h-full flex-col">

    <div class="h-24 grid grid-col-2 grid-rows-2">
        <div class="col-start-1 flex items-baseline py-8 xxl:py-10">
            <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Personal settings</h1>
            <h2 class="font-bold text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
        </div>

        <div class="col-start-2 flex justify-end py-4 xxl:py-10">
            <h3 class="font-bold text-xs sm:text-xxs xxl:text-xl text-gray-600 py-6">Monday 23 November 2020 | 16:20:23</h3>
            
            <div class="opacity-25 transform scale-50 pt-1 transaction hover:opacity-100 duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" width="124.01" height="99.208" viewBox="0 0 124.01 99.208">
                    <path id="Logo" d="M163.744,94.3V91.931a.9.9,0,0,0-.9-.9h-3.163a.889.889,0,0,0-.549.193h0l-.289.394a.89.89,0,0,0-.058.31v18.613a.9.9,0,0,0,.9.9h3.163a.9.9,0,0,0,.9-.9v-1.367l19.9,12.859v12.4h-31v-18.6l-43.4-24.8-37.2,24.8v49.6L104.4,187.017v2.329a.9.9,0,0,0,.9.9h3.163a.89.89,0,0,0,.523-.171l.256.171v-.461a.887.887,0,0,0,.118-.436V170.732a.9.9,0,0,0-.9-.9H105.3a.9.9,0,0,0-.9.9v2.105l-19.963-13.6v-12.4h31v18.18l43.4,25.224,37.2-24.8v-49.6Zm19.9,64.94-24.8,17.447-31-17.715V127.031H130.5a.9.9,0,0,0,.9-.9v-3.163a.9.9,0,0,0-.9-.9h-18.32a.9.9,0,0,0-.9.9v3.163a.9.9,0,0,0,.9.9h3.263v7.407h-31v-12.4l24.815-17.447,30.989,17.447-.033,31.464h-3.037a.9.9,0,0,0-.9.9v3.163a.9.9,0,0,0,.9.9h18.32a.9.9,0,0,0,.9-.9V154.4a.9.9,0,0,0-.9-.9h-2.882l.033-6.662h31Z" 
                    transform="translate(-72.038 -91.034)" fill="#003399"/>
                </svg>
            </div>
        </div>
    </div>

    <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">

        <div class="flex min-h-full">

            <div class="flex flex-col justify-between rounded-lg px-10 w-full bg-white text-gray-700">

                <div class="h-24 md:h-20 xxl:h-32 grid grid-rows-1">
                    <h2 class="grid items-center text-xl md:text-base xxl:text-3xl font-bold">Personal settings</h2>
                </div>

                <div class="grid grid-rows-5 md:grid-rows-3 grid-cols-6 sm:grid-rows-3 sm:items-center">
                    <div class=" w-full row-span-5 col-span-2 grid justify-center items-center sm:col-span-6 sm:row-span-1 md:row-span-3">
                        @livewire('components.employees.change-picture-component')
                    </div>

                    <div class="col-span-4 row-start-2 md:row-start-1 col-start-3 sm:col-span-6 sm:row-span-1 sm:row-start-2 sm:col-start-1">
                        @livewire('components.employees.edit', ["employee"=>$employee])
                    </div>

                    <div class="col-span-4 row-start-4 md:row-start-3 col-start-3 sm:col-span-6 sm:row-span-1 sm:row-start-3 sm:col-start-1">
                        @livewire('components.login.password-reset-component')
                    </div>
                </div> 

                <div class="grid grid-cols-6 pb-10 px-10 md:pt-12 xl:pt-20 xxl:pt-32">

                    <div class="grid col-span-3">
                        <h2 class="text-lg xxl:text-4xl font-bold sm:text-sm md:text-sm">Activity</h2>
                        <div class="grid gap-2 lg:gap-4 xl:gap-4 xxl:gap-8 py-5 sm:text-xs md:text-sm lg:text-sm xl:text-base xxl:text-2xl">
                            <p>Bought <b>50.000/h</b> for <b>2 weeks</b> of <b>Green Hydrogen</b> at the price of <b>€4,312</b><p> 
                            <p>Sold <b>2.000/h</b> for <b>1 week</b> of <b>Blue Hydrogen</b> at the price of <b>€2,456</b><p>
                            <p>Placed a bid for <b>20.000/h</b> for <b>2 weeks</b> of <b>Green Hydrogen</b> at the price of <b>€4,312</b><p>
                            <p>Bought <b>50.000/h</b> for <b>2 weeks</b> of <b>Green Hydrogen</b> at the price of <b>€4,312</b><p> 
                        </div>
                    </div>
                    
                    <div class="grid col-start-5">
                        <h2 class="text-lg xxl:text-4xl font-bold sm:text-sm md:text-sm">Stats</h2>
                        <div class="flex flex-row gap-5 py-5 sm:text-xs md:text-sm lg:text-sm xl:text-base xxl:text-2xl">
                            <div class="grid gap-2 lg:gap-4 xl:gap-4 xxl:gap-8">
                                <p>Total trades:<p/>
                                <p>Total offers:<p/>
                                <p>Total bids:<p/>
                                <p>Total sold:<p/>
                            </div>
                            <div class="grid gap-2 lg:gap-4 xl:gap-4 xxl:gap-4 font-bold">
                                <p>653<p>
                                <p>412<p>
                                <p>129<p>
                                <p>123<p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection()
