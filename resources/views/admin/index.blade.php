@extends('layouts.app')


@section('content')
    <div class="container pt-5 mx-auto h-full">
        <div class="flex flex-row flex-nowrap min-h-full">
            <div class=" rounded-lg shadow px-4 py-2 m-2 w-2/3">
                <h1 class="text-2xl text-gray-700 ">
                    @livewire('components.admin.companies')
                </h1>
            </div>
            <div class="px-4 py-2 m-2  w-1/3 shadow rounded-lg lg:flex-grow">
                @livewire('components.admin.requests')
            </div>
        </div>
    </div>
@endsection()
