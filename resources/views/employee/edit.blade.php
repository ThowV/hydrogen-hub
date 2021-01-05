@extends('layouts.app')

@section('content')
<div class="flex h-full flex-col">

    <div class="h-24 grid grid-col-2 grid-rows-2">

        <div class="col-start-1 flex items-baseline py-8 xxl:py-10 font-bold ">
            <h1 class="text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Settings</h1>
            <h2 class="text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
        </div>
        
        <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
            <h3 class="font-bold text-xs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
        </div>

    </div>

    <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">

        <div class="flex min-h-full">

            <div class="rounded-lg px-10 bg-white text-gray-700">

                <div class="h-24 md:h-20 xxl:h-32 grid grid-rows-1">
                    <h2 class="grid items-center text-xl md:text-base xxl:text-3xl font-bold">Personal settings</h2>
                </div>

                <div class="grid grid-rows-5 md:grid-rows-4 grid-cols-6 sm:grid-rows-3 sm:items-center">
                    <div class="row-span-4 col-span-2 grid justify-center items-center sm:col-span-6 sm:row-span-1">
                        @livewire('components.employees.change-picture-component')
                    </div>

                    <div class="col-span-4 row-start-2 col-start-3 sm:col-span-6 sm:row-span-1 sm:row-start-2 sm:col-start-1">
                        @livewire('components.employees.edit', ["employee"=>$employee])
                    </div>

                    <div class="col-span-4 row-start-4 col-start-3 sm:col-span-6 sm:row-span-1 sm:row-start-3 sm:col-start-1">
                        @livewire('components.login.password-reset-component')
                    </div>
                </div> 

                <div class="grid grid-cols-6 xl:pt-20 xxl:pt-32">

                    <div class="grid col-span-3">
                        <h2 class="text-xl xxl:text-4xl font-bold sm:text-sm md:text-base">Activity</h2>
                        <div class="grid gap-2 lg:gap-4 xl:gap-4 xxl:gap-8 py-5 sm:text-xs md:text-sm lg:text-sm xl:text-base xxl:text-2xl">
                            <p>Bought <b>50.000/h</b> for <b>2 weeks</b> of <b>Green Hydrogen</b> at the price of <b>€4,312</b><p> 
                            <p>Sold <b>2.000/h</b> for <b>1 week</b> of <b>Blue Hydrogen</b> at the price of <b>€2,456</b><p>
                            <p>Placed a bid for <b>20.000/h</b> for <b>2 weeks</b> of <b>Green Hydrogen</b> at the price of <b>€4,312</b><p>
                            <p>Bought <b>50.000/h</b> for <b>2 weeks</b> of <b>Green Hydrogen</b> at the price of <b>€4,312</b><p> 
                        </div>
                    </div>
                    
                    <div class="grid col-start-5">
                        <h2 class="text-xl xxl:text-4xl font-bold sm:text-sm md:text-base">Stats</h2>
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
