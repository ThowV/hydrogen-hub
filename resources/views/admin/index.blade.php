@extends('layouts.app')


@section('content')
<div class="flex h-full flex-col">
    <div class="h-24 grid grid-col-2 grid-rows-2">
        <div class="col-start-1 flex items-baseline py-8 xxl:py-10 font-bold">
            <h1 class="text-2xl xxl:text-4xl mr-4 pl-10 xxl:pl-20">Admin</h1>
            <h2 class="text-xs xxl:text-xl text-gray-600">Short Term Trading</h2>
        </div>
        <div class="col-start-2 grid justify-end py-4 px-10 xxl:py-8">
            <h3 class="font-bold text-xs xxl:text-xl text-gray-600">Monday 23 November 2020 | 16:20:23</h3>
        </div>
    </div>
    <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
        <div class="flex flex-nowrap min-h-full sm:flex-col text-gray-700">
            <div class="rounded-lg px-10 mr-4 w-2/3 sm:w-full sm:mr-0 md:w-2/4 bg-white">
                @livewire('components.admin.companies')
            </div>
            <div class="rounded-lg px-10 pb-6 ml-4 w-1/3 sm:w-full sm:ml-0 sm:mt-4 md:w-2/4 bg-white">
                @livewire('components.admin.requests')
            </div>
        </div>
    </div>
</div>
@endsection()
