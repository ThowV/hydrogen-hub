<?php
/* @var \App\Models\User $employeeToUpdate */
?>
<div class="z-40 relative w-full h-full text-gray-700">

    <div class="modal fixed top-0 left-0 h-full w-full grid grid-cols-8 grid-rows-6">

        <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal()"></div>

        <div class="modal-container max-h-full max-w-full grid col-start-2 sm:col-start-3 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">

            <div class="modal-content flex flex-col gap-5 w-full h-full p-8 sm:p-4 xxl:p-12 text-left">

                <div class="flex flex-none w-full justify-between">
                    <h2 class="text-base xxl:text-3xl font-bold">Employee portfolio</h2>
                    <div class="modal-close cursor-pointer h-full z-50">
                        <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                        </svg>
                    </div>
                </div>

                <div class="flex flex-1 flex-row py-10 sm:py-1">
                    <div class="w-1/3 flex flex-col gap-y-5">
                        <div align="center" class="w-full">
                            <img class="rounded-full w-32 xxl:w-46" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fcdn.pixabay.com%2Fphoto%2F2016%2F08%2F08%2F09%2F17%2Favatar-1577909_960_720.png&f=1&nofb=1" alt="">
                        </div>
                        <div class="w-full flex flex-col justify-center items-center text-sm sm:text-xs" align="center">
                            <label for="">Change picture URL:</label>
                            <input class="rounded-xl bg-gray-200 w-2/4 px-4 py-1 xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" placeholder="Example..." wire:model="employeeToUpdate.picture_url" type="text"/>
                            @error('employeeToUpdate.picture_url') 
                            <span class="error text-red-500">{{ $message }}</span> @enderror                    
                        </div>
                    </div>

                    <form class="w-2/3 h-full" wire:submit.prevent="saveUpdate">
                        <ul class="h-full flex flex-col justify-between">
                            <div class="flex flex-none justify-between flex-wrap gap-2 text-sm">
                                <li class="flex flex-col gap-3">
                                    <label class="" for="">First name:</label>
                                    <input class="font-semibold rounded-xl bg-gray-200 px-4 py-1 xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" wire:model="employeeToUpdate.first_name"
                                            type="text"/>
                                    @error('employeeToUpdate.first_name') <span
                                        class="error text-red-500">{{ $message }}</span> @enderror
                                </li>
                                <li class="flex flex-col gap-3">
                                    <label class="" for="">Last name: </label>
                                    <input class="font-semibold rounded-xl bg-gray-200 px-4 py-1 xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" wire:model="employeeToUpdate.last_name"
                                       @if(!auth()->user()->hasAnyRole('Super Admin|Admin'))disabled @endif  type="text"/>
                                    @error('employeeToUpdate.last_name') <span
                                        class="error text-red-500">{{ $message }}</span> @enderror
                                </li>
                                <li class="flex flex-col gap-3">
                                    <label class="" for="">Email: </label>
                                    <input class="font-semibold rounded-xl bg-gray-200 px-4 py-1 xxl:text-xl transaction duration-300 hover:bg-gray-300 focus:bg-gray-300 sm:text-xs xxl:text-xl" wire:model="employeeToUpdate.email" type="text"/>
                                    @error('employeeToUpdate.email') <span
                                        class="error text-red-500">{{ $message }}</span> @enderror
                                </li>
                                <li class="flex items-center">
                                    <button type="submit"
                                            class="rounded-lg px-2 py-1 bg-blue-100 border-2 border-hovBlue hover:bg-hovBlue text-hovBlue hover:text-white text-xs sm:text-xxs xxl:text-2xl transition duration-200 ease-in-out" autofocus>
                                        Submit
                                    </button>
                                </li>
                            </div>

                            <!-- Roles -->
                            <li class="flex flex-auto pt-10 sm:pt-4 text-sm">               
                                @hasanyrole('Super Admin|Admin')
                                    @livewire('components.admin.role-manager-component', ['user'=>$this->employeeToUpdate])
                                @endhasanyrole                       
                            </li> 
                        </ul>
                    </form>
                </div>

                <div class="flex flex-auto">
                    <div class="flex flex-row w-full text-sm sm:text-xs xxl:text-xl">
                        <div class="w-3/4 flex flex-col gap-3 sm:gap-1">
                            <span class="font-semibold">Activity</span>
                            <ul class="flex flex-col gap-3 sm:gap-1">
                                <li>Total Trades: {{count($employeeToUpdate->trades)}}</li>
                                <li>Total Offers: {{count($employeeToUpdate->tradesAsOwner->where('trade_type', 'offer'))}}</li>
                                <li>Total Sold: {{count($employeeToUpdate->tradesAsResponder->where('trade_type', 'request'))}}</li>
                            </ul>
                        </div>
                        <div class="w-1/4 flex flex-col gap-3 sm:gap-1">
                            <span class="font-semibold">Stats</span>
                            <ul class="flex flex-col gap-3 sm:gap-1">
                                <li>Total trades: {{count($employeeToUpdate->trades)}}</li>
                                <li>Total offers: {{count($employeeToUpdate->tradesAsOwner->where('trade_type', 'offer'))}}</li>
                                <li>Total sold: {{count($employeeToUpdate->tradesAsResponder->where('trade_type', 'request'))}}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Delete company -->
                @if(auth()->id() !==  $employeeToUpdate->id )
                    <div class="w-full flex flex-none justify-center">
                        <form class="flex flex-row gap-5" action="{{route('employees.destroy', $employeeToUpdate->id)}}"
                            onsubmit="return confirm('Are you sure?')" method="post">
                            @csrf @method('delete')
                            <button
                                class="text-sm xl:text-base xxl:text-2xl font-bold text-gray-500 hover:text-gray-700 flex flex-row items-center gap-5 transition duration-200 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="13.461" height="15.384"
                                    viewBox="0 0 13.461 15.384">
                                    <path id="Icon_awesome-trash-alt" data-name="Icon awesome-trash-alt"
                                        d="M.961,13.942A1.442,1.442,0,0,0,2.4,15.384h8.653A1.442,1.442,0,0,0,12.5,13.942V3.846H.961ZM9.134,6.25a.481.481,0,0,1,.961,0v6.73a.481.481,0,0,1-.961,0Zm-2.884,0a.481.481,0,0,1,.961,0v6.73a.481.481,0,0,1-.961,0Zm-2.884,0a.481.481,0,0,1,.961,0v6.73a.481.481,0,0,1-.961,0ZM12.98.961H9.375L9.092.4A.721.721,0,0,0,8.446,0H5.012a.713.713,0,0,0-.643.4L4.086.961H.481A.481.481,0,0,0,0,1.442V2.4a.481.481,0,0,0,.481.481h12.5a.481.481,0,0,0,.481-.481V1.442A.481.481,0,0,0,12.98.961Z"
                                        fill="#bebebe"/>
                                </svg>
                                Remove employee
                            </button>
                        </form>
                    </div>

                @endif
            </div>
        </div>
    </div>
</div>
</div>
