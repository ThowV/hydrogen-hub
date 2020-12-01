<?php
/* @var \App\Models\Company $companyInModal */
?>
<div>
    <div class="modal fixed w-full h-full top-0 left-0 z-50 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full z-50 bg-gray-900 opacity-50" wire:click="toggleModal()">


        </div>

        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <div wire:click="toggleModal" class="modal-close cursor-pointer float-right z-50">
                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                     viewBox="0 0 18 18">
                    <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
            </div>
            <h1 class="text-2xl">Company Profile</h1>
            <img src="{{$companyInModal->logo_path}}" alt="">
            <h1 class="text-2xl">Company name: {{$companyInModal->name}}</h1>
            <p>Owner Name: {{ $companyInModal->owner->full_name }}</p>
            <p>Owner Email: {{ $companyInModal->owner->email }}</p>

            <p>Activity</p>
            <ul>
                @foreach($companyInModal->getAllActivities(true) as $key => $activity)
                    <li class="@if($key % 2 == 0) bg-gray-300 @endif">
                        <span class="font-bold">{{ucfirst($activity[0])}}</span> <span
                            class="font-bold">{{$activity[1]}}</span>/h for <span
                            class="font-bold">{{$activity[2]}}</span> of <span class="font-bold">{{$activity[3]}}</span>
                        hydrogen at
                        the price of € <span class="font-bold">{{$activity[4] / 100}}</span>/unit
                        <span class="font-bold">{{ \Carbon\Carbon::parse( $activity[5])->diffForHumans()}}</span>
                    </li>
                @endforeach
            </ul>

            <p class="text-2xl">Stats</p>
            <ul>
                <li>Total Trades {{count($companyInModal->trades)}}</li>
                <li>Total Offers {{count($companyInModal->tradesAsOwner->where('trade_type', 'offer'))}}</li>
                <li>Total Sold   {{count($companyInModal->tradesAsResponder->where('trade_type', 'request'))}}</li>
            </ul>
            <form onsubmit="return confirm('Are you sure?')" method="post" action="{{route('company.destroy', $companyInModal->id)}}">
                @method('delete')
                @csrf
                <button class="button p-2">Delete Company</button>
            </form>
        </div>
    </div>
</div>
