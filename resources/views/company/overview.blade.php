@extends('layouts.app')

@section('content')
    <div class="flex h-full flex-col">
        <!--Header-->
    @include('layouts.header', ['title' => 'Company overview'])

        <!-- Company stats -->
        <div class="px-10 xxl:px-20 pb-5 xxl:pb-10 xxl:pt-10">
            <div class="flex h-vh10">
                <div class="rounded-lg px-10 xxl:px-24 w-full bg-white text-gray-700">
                    <div class="h-full flex flex-row flex-wrap justify-between items-center">

                        <h2 class="xxl:text-3xl font-bold">Statistics</h2>

                        <div class="flex flex-row items-center text-center gap-4 text-sm xxl:text-2xl">
                            @can('company.settings.update')
                                @livewire('components.company.change-company-logo-component')
                            @endcan
                            <p class="font-bold">{{ auth()->user()->company->name }}</p>
                        </div>

                        <div class="flex gap-4 text-sm xxl:text-2xl">
                            <p>Total volumes traded:</p>
                            <p class="font-bold">17.234.324</p>
                        </div>

                        <div class="flex gap-4 text-sm xxl:text-2xl">
                            <p>Total trades:</p>
                            <p class="font-bold">1.625</p>
                        </div>

                        <div class="flex gap-4 text-sm xxl:text-2xl">
                            <p>Total employees:</p>
                            <p class="font-bold">4</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company employees -->
        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex h-full">
                <div class="rounded-lg p-10 xxl:px-24 xxl:py-24 bg-white text-gray-700">
                    <div class="w-full h-full">
                        @livewire('components.company.overview-component')
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection()
