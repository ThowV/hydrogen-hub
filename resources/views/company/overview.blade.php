@extends('layouts.app')

@section('content')
    <div class="flex w-full h-full flex-col">
        <!--Header-->
        <div class="w-full h-24 grid grid-col-2 grid-rows-2">
            <div class="col-start-1 flex flex-row items-baseline py-8 xxl:py-10">
                <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Company overview</h1>
                <h2 class="font-bold text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
            </div>
            <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
                <h3 class="font-bold text-xs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
            </div>
        </div>

        <!-- Company stats -->
        <div class="px-10 xxl:px-20 pb-5 xxl:pb-10 xxl:pt-10">
            <div class="flex flex-row flex-nowrap h-vh10">
                <div class="rounded-lg px-10 xxl:px-24 w-full bg-white text-gray-700">
                    <div class="w-full h-full flex flex-row flex-wrap justify-between items-center">

                        <h2 class="text-base xxl:text-3xl font-bold">Statistics</h2>

                        <div class="flex flex-row items-center text-center gap-4 text-sm xxl:text-2xl">
                            @can('company.settings.update')
                                @livewire('components.company.change-company-logo-component')
                            @endcan
                            <p class="font-bold">{{ auth()->user()->company->name }}</p>
                        </div>

                        <div class="flex flex-row gap-4 text-sm xxl:text-2xl">
                            <p>Total volumes traded:</p>
                            <p class="font-bold">17.234.324</p>
                        </div>

                        <div class="flex flex-row gap-4 text-sm xxl:text-2xl">
                            <p>Total trades:</p>
                            <p class="font-bold">1.625</p>
                        </div>

                        <div class="flex flex-row gap-4 text-sm xxl:text-2xl">
                            <p>Total employees:</p>
                            <p class="font-bold">4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company employees -->
        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex flex-row flex-nowrap h-full">
                <div class="rounded-lg p-10 xxl:px-24 xxl:py-24 w-full bg-white text-gray-700">
                    <div class="w-full h-full">
                        @livewire('components.company.overview-component')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection()
