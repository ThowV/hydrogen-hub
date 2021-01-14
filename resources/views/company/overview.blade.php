@extends('layouts.app')

@section('content')
    <div class="flex h-full flex-col">
        <!--Header-->
        <div class="h-24 grid grid-col-2 grid-rows-2 font-bold">
            <div class="col-start-1 flex items-baseline py-8 xxl:py-10">
                <h1 class="font-bold text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Company overview</h1>
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

                        @livewire('components.company.statistics-component', ['company'=>auth()->user()->company])
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
