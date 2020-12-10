<?php
/* @var \App\Models\User $employeeToUpdate */
?>
<div class="z-40 relative w-full text-gray-700">

    <div class="modal fixed top-0 left-0 h-full w-full grid grid-cols-8 grid-rows-6">

        <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal()"></div>

        <div
            class="modal-container max-h-full max-w-full grid col-start-2 sm:col-start-3 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">

            <div class="modal-content flex flex-col w-full h-full p-8 sm:p-4 xxl:p-12 text-left">
                <div class="w-full">
                    <form wire:submit.prevent="saveUpdate">
                        <ul>
                            <li>
                                <label for="">Picture Url: </label>
                                <input class="bg-gray-500 text-white" wire:model="employeeToUpdate.picture_url"
                                       type="text"/>
                                @error('employeeToUpdate.picture_url') <span
                                    class="error text-red-500">{{ $message }}</span> @enderror
                            </li>
                            <li>
                                <label for="">First Name:</label>
                                <input class="bg-gray-500 text-white" wire:model="employeeToUpdate.first_name"
                                       type="text"/>
                                @error('employeeToUpdate.first_name') <span
                                    class="error text-red-500">{{ $message }}</span> @enderror
                            </li>
                            <li>
                                <label for="">Last Name: </label>
                                <input class="bg-gray-500 text-white" wire:model="employeeToUpdate.last_name"
                                       type="text"/>
                                @error('employeeToUpdate.last_name') <span
                                    class="error text-red-500">{{ $message }}</span> @enderror
                            </li>
                            <li>
                                <label for="">Label for: </label>
                                <input class="bg-gray-500 text-white" wire:model="employeeToUpdate.email" type="text"/>
                                @error('employeeToUpdate.email') <span
                                    class="error text-red-500">{{ $message }}</span> @enderror
                            </li>
                            <li>
                                <button type="submit"
                                        class="p-2 bg-green-500 rounded text-white" autofocus>
                                    Submit
                                </button>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>

            <div>
                Roles:
                <ul>
                    @if(count($employeeToUpdate->roles) !== 0 )
                        @foreach($employeeToUpdate->roles as $role)
                            <li>{{$role->name}}</li>
                        @endforeach
                    @else
                        <li>No roles yet</li>
                    @endif


                </ul>
                @if(auth()->user()->can('employees.roles.read'))
                        Todo create Rolemanager
                        <a class="mt-3 p-4 bg-orange-400 rounded text-white">Change </a>
                @endif
            </div>

            <div>
                Stats
                <ul>
                    <li>Total Trades: {{count($employeeToUpdate->trades)}}</li>
                    <li>Total Offers: {{count($employeeToUpdate->tradesAsOwner->where('trade_type', 'offer'))}}</li>
                    <li>Total Sold: {{count($employeeToUpdate->tradesAsResponder->where('trade_type', 'request'))}}</li>
                </ul>
            </div>

            <!-- Delete company -->
            @if(auth()->id() !==  $employeeToUpdate->id )
                <div class="w-full flex justify-center">
                    <form class="flex flex-row gap-5" action="{{route('employees.destroy', $employeeToUpdate->id)}}"
                          onsubmit="return confirm('Are you sure?')" method="post">
                        @csrf @method('delete')
                        <button
                            class="text-sm xl:text-base xxl:text-2xl font-bold text-gray-500 flex flex-row items-center gap-5">
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
