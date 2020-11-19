@extends('layouts.app')

@section('content')
    <div class="flex flex-row">
        <div class="w-full rounded shadow-lg m-3">
            @livewire('components.employees.edit', ["employee"=>$employee])
        </div>
    </div>
@endsection()
