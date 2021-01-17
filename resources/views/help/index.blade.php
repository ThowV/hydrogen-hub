@extends('layouts.app')


@section('content')
    <div class="flex h-full flex-col">
        @include('layouts.header', ['title' => 'Help'])

        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex flex-nowrap min-h-full sm:flex-col text-gray-700">
                <div class="rounded-lg px-10 mr-4 w-full sm:w-full sm:mr-0 md:w-2/4 bg-white">

                </div>
            </div>
        </div>
    </div>
@endsection()
