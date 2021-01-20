@extends('layouts.app')

@section('content')
<div class="flex w-full h-full flex-col text-gray-700">
    @include('layouts.header', ['title' => 'Dashboard'])

    <div class="flex flex-none w-full px-10 xxl:px-20 pb-5 xxl:pb-20 xxl:pt-10 grid-cols-2 grid-rows-2">
        <div class="flex min-h-full w-full sm:flex-col">
            <div class="rounded-lg p-10 w-full bg-white">
                @livewire('components.dashboard.overview-component')
            </div>
        </div>
    </div>

    <div class="flex flex-auto h-full w-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10 grid-cols-2 grid-rows-2">
        <div class="flex min-h-full w-full sm:flex-col">
            <div class="rounded-lg px-10 pt-10 w-2/3 sm:w-full sm:mt-4 bg-white text-gray-700">
                @livewire('components.dashboard.trades-component')
            </div>

            <div class="rounded-lg p-10 w-1/3 sm:w-full sm:ml-0 sm:mt-4 bg-white text-gray-700 ml-5">
                @livewire('components.dashboard.portfolio-positions-component')
            </div>
        </div>
    </div>
</div>
@endsection
