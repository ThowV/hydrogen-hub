@extends('layouts.app')

@section('content')
    <div class="flex w-full h-full flex-col">
        <!--Trade info modal-->
        @livewire('components.company.trade-and-listing-info-modal-component')

        <!--Header-->
        <div class="w-full h-24 grid grid-col-2 grid-rows-2">
            <div class="col-start-1 flex flex-row items-baseline py-8 xxl:py-10">
                <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Company portfolio</h1>
                <h2 class="font-bold text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
            </div>
            <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
                <h3 class="font-bold text-xs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
            </div>
        </div>

        <!--Content-->
        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="rounded-lg px-10 mr-4 w-full sm:w-full sm:mr-0 md:w-2/4 bg-white text-gray-700">
                <div class="w-2/3">
                    @livewire('components.company.chart-overview')
                </div>
            </div>
        </div>
        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex flex-row flex-nowrap min-h-full sm:flex-col">
                <div class="rounded-lg px-10 mr-4 w-3/6 sm:w-full sm:mr-0 md:w-2/4 bg-white text-gray-700">
                    @livewire('components.company.trades-component')
                </div>

                <div class="rounded-lg px-10 ml-4 w-2/6 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white text-gray-700">
                    @livewire('components.company.offers-requests-component')
                </div>

                <div class="rounded-lg px-10 ml-4 w-1/6 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white text-gray-700">
                    @livewire('components.company.financials-component')
                </div>
            </div>
        </div>
    </div>
@endsection()
