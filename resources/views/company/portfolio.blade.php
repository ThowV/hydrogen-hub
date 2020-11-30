@extends('layouts.app')

@section('content')
    <div class="flex flex-row">
        <div class="w-full">
            @livewire('components.company.portfolio-component')
        </div>
    </div>
@endsection()
