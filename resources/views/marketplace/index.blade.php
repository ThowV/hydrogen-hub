@extends('layouts.app')

@section('content')
    <div class="flex w-full h-full flex-col">
        <!--Trade info modal-->
        @livewire('components.market.create-listing-modal-component')

        <!--Trade info modal-->
        @livewire('components.market.show-listing-modal-component')

        <!--Header-->
        @include('layouts.header', ['title' => 'Marketplace'])

        <!--Content-->
        @livewire('components.market.listings-component')
    </div>
@endsection()
