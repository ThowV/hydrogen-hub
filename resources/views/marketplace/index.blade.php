@extends('layouts.app')

@section('content')
    <div class="flex w-full h-full flex-col">
        <!--Trade info modal-->
        @livewire('components.market.create-listing-modal-component')

        <!--Trade info modal-->
        @livewire('components.market.show-listing-modal-component')

        <!--Header-->
        <div class="w-full h-24 grid grid-col-2 grid-rows-2">
            <div class="col-start-1 flex flex-row items-baseline py-8 xxl:py-10">
                <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Marketplace</h1>
                <h2 class="font-bold text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
            </div>
            <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
                <h3 class="font-bold text-xs sm:text-xxs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
            </div>
        </div>

        <!--Content-->
        @livewire('components.market.listings-component')
    </div>
@endsection()
