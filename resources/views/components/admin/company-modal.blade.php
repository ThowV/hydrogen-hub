<?php
/* @var \App\Models\Company $companyInModal */
?>
<div class="z-40 relative w-full text-gray-700">

    <div class="modal fixed top-0 left-0 h-full w-full grid grid-cols-8 grid-rows-6">

        <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal()"></div>

        <div
            class="modal-container max-h-full max-w-full grid col-start-2 sm:col-start-3 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">

            <div class="modal-content flex flex-col w-full h-full p-8 sm:p-4 xxl:p-12 text-left">

                <!--Title-->
                <div class="flex justify-between items-center pb-5 sm:pb-2 xl:pb-10 xxl:pb-12">
                    <p class="text-xl xxl:text-4xl font-bold">Company Profile</p>
                    <div wire:click="toggleModal" class="modal-close cursor-pointer h-full z-50">
                        <svg
                            class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Logo and names -->
                <div class="flex flex-row w-full pr-20" style="height: 20vh">

                    <img class="w-2/4" src="{{$companyInModal->logo_path}}" alt="">

                    <div class="w-2/4 grid grid-cols-2 grid-rows-2 text-sm xl:text-base xxl:text-2xl">
                        <div class="flex flex-col gap-3">
                            <p>Company name:</p>
                            <p class="font-bold"> {{$companyInModal->name}}</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p>Owner email:</p>
                            <p class="font-bold"> {{ $companyInModal->owner->email }}</p>
                        </div>

                        <div class="flex flex-col gap-3">
                            <p>Owner name:</p>
                            <p class="font-bold">{{ $companyInModal->owner->full_name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Activity and Stats -->
                <div class="flex flex-row w-full py-10 text-sm" style="height: 30vh">

                    <div class="flex flex-col h-full w-3/4 gap-5">

                        <p class="font-bold xl:text-xl xxl:text-2xl">Activity</p>

                        <ul class="flex flex-row gap-8 xxl:text-2xl">
                            @if(count($companyInModal->getAllActivities()) > 0)
                                @foreach($companyInModal->getAllActivities(true) as $key => $activity)
                                    <li class="@if($key % 2 == 0) bg-gray-300 @endif">
                                        <span class="font-bold">{{ucfirst($activity[0])}}</span> <span
                                            class="font-bold">{{$activity[1]}}</span>/h for <span
                                            class="font-bold">{{$activity[2]}}</span> of <span
                                            class="font-bold">{{$activity[3]}}</span>
                                        hydrogen at
                                        the price of € <span class="font-bold">{{$activity[4] / 100}}</span>/unit
                                        <span
                                            class="font-bold">{{ \Carbon\Carbon::parse( $activity[5])->diffForHumans()}}</span>
                                    </li>
                                @endforeach
                            @else
                                <li> No activities yet!</li>
                            @endif
                        </ul>
                    </div>

                    <div class="flex flex-col h-ful w-1/4 gap-5">

                        <p class="font-bold xl:text-xl xxl:text-2xl">Stats</p>

                        <ul class="flex flex-row gap-5 xxl:text-2xl">
                            <div class="flex flex-col gap-8">
                                <li>Total trades:</li>
                                <li>Total offers:</li>
                                <li>Total sold:</li>
                            </div>

                            <div class="flex flex-col gap-8 font-bold">
                                <li>{{count($companyInModal->trades)}}</li>
                                <li>{{count($companyInModal->tradesAsOwner->where('trade_type', 'offer'))}}</li>
                                <li>{{count($companyInModal->tradesAsResponder->where('trade_type', 'request'))}}</li>
                            </div>
                        </ul>
                    </div>
                </div>

                <!-- Delete company -->
                <div class="w-full flex justify-center">

                    <form class="flex flex-row gap-5" onsubmit="return confirm('Are you sure?')" method="post"
                          action="{{route('company.destroy', $companyInModal->id)}}">
                        @method('delete')
                        @csrf


                        <button
                            class="text-sm xl:text-base xxl:text-2xl font-bold text-gray-500 flex flex-row items-center gap-5">

                            <svg xmlns="http://www.w3.org/2000/svg" width="13.461" height="15.384"
                                 viewBox="0 0 13.461 15.384">
                                <path id="Icon_awesome-trash-alt" data-name="Icon awesome-trash-alt"
                                      d="M.961,13.942A1.442,1.442,0,0,0,2.4,15.384h8.653A1.442,1.442,0,0,0,12.5,13.942V3.846H.961ZM9.134,6.25a.481.481,0,0,1,.961,0v6.73a.481.481,0,0,1-.961,0Zm-2.884,0a.481.481,0,0,1,.961,0v6.73a.481.481,0,0,1-.961,0Zm-2.884,0a.481.481,0,0,1,.961,0v6.73a.481.481,0,0,1-.961,0ZM12.98.961H9.375L9.092.4A.721.721,0,0,0,8.446,0H5.012a.713.713,0,0,0-.643.4L4.086.961H.481A.481.481,0,0,0,0,1.442V2.4a.481.481,0,0,0,.481.481h12.5a.481.481,0,0,0,.481-.481V1.442A.481.481,0,0,0,12.98.961Z"
                                      fill="#bebebe"/>
                            </svg>

                            Delete company
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
