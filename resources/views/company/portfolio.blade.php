@extends('layouts.app')

@section('content')
    <div class="flex flex-col h-full">
        <!--Chart overview selection modal-->
        @livewire('components.company.chart-overview-selection-modal-component')

        <!--Trade and listing info modal-->
        @livewire('components.company.trade-and-listing-info-modal-component')

        <!--Header-->
        @include('layouts.header', ['title' => 'Company portfolio'])

        <!--Graphs-->
        <div class="flex-auto px-10 xxl:px-20 pb-5 xxl:pb-20 xxl:pt-10">
            <div class="rounded-lg p-10 w-full bg-white text-gray-700">
                <div class="max-w-full">
                    @livewire('components.company.chart-overview-component')
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="flex-auto w-full h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex w-full h-full sm:flex-col text-gray-700">
                <div class="rounded-lg p-10 pb-5 mr-2 w-3/6 sm:w-full sm:mr-0 bg-white">
                    @livewire('components.company.trades-and-listings-component', ['componentType' => 'trades'])
                </div>

                <div class="rounded-lg p-10 pb-5 mr-2 ml-3 w-2/6 sm:w-full sm:ml-0 sm:mt-4 bg-white">
                    @livewire('components.company.trades-and-listings-component', ['componentType' => 'listings'])
                </div>

                <div class="rounded-lg p-10 ml-3 w-1/6 sm:w-full sm:ml-0 sm:mt-4 bg-white">
                    @livewire('components.company.financials-component')
                </div>
            </div>
        </div>
    </div>
@endsection()
