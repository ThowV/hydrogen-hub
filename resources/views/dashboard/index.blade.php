@extends('layouts.app')

@section('content')
<div class="flex w-full h-full flex-col">
    @include('layouts.header', ['title' => 'Dashboard'])

    <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10 grid-cols-2 grid-rows-2">
        <div class="flex flex-row flex-nowrap min-h-full sm:flex-col">
            <div class="rounded-lg px-10 mr-4 w-full sm:w-full sm:mr-0 md:w-2/4 bg-white text-gray-700">
                @livewire('components.dashboard.overview-component')
            </div>
        </div>
    </div>

    <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10 grid-cols-2 grid-rows-2">
        <div class="flex flex-row flex-nowrap min-h-full sm:flex-col">
            <div class="rounded-lg px-10 ml-4 w-3/5 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white text-gray-700">
                @livewire('components.dashboard.trades-component')
            </div>

            <div class="rounded-lg px-10 ml-4 w-2/5 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white text-gray-700">
                @livewire('components.dashboard.portfolio-positions-component')
            </div>
        </div>
    </div>
</div>
@endsection
