@extends('layouts.app')

@section('content')
    <div class="flex flex-row">
        <div class="w-full rounded shadow-lg m-3">


            @livewire('components.employees.change-picture-component')
        </div>
    </div>
    <div class="flex flex-row">
        <div class="w-full rounded shadow-lg m-3">
            @livewire('components.employees.edit', ["employee"=>$employee])
        </div>
    </div>
    <div class="flex flex-row">
        <div class="w-full bg-gray-800 m-3">
            @livewire('components.login.password-reset-component')
        </div>
    </div>
@endsection()
