@extends('layouts.app')

@section('content')
    <h1 class="text-2xl">Company overview</h1>
    <div class="flex flex-row">
        <div class="w-full">
            @livewire('components.company.overview-component')
        </div>
    </div>
@endsection()
