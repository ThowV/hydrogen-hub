<div class="z-40 relative w-full text-gray-700">

    <div class="modal fixed top-0 left-0 h-full w-full grid grid-cols-8 grid-rows-6">

        <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleEmployeeCreationModal()"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-2 sm:col-start-3 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">

                <div class="modal-content flex flex-col gap-5 w-full h-full p-8 sm:p-4 xxl:p-12 text-left">
                
                    <div class="flex flex-none w-full justify-between">
                        <h2 class="text-base xxl:text-3xl font-bold">Add employee</h2>
                        <div wire:click="toggleEmployeeCreationModal()" class="modal-close cursor-pointer h-full z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <form class="flex flex-auto w-full justify-center" wire:submit.prevent="submitCreateUser">
                        <div class="w-1/3 flex flex-col justify-around py-8 sm:py-5">
                            <input class="text-nav border-b-2 w-full py-2 font-bold text-sm xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                            placeholder="First name" type="text" wire:model="employeeToCreate.first_name">
                            @error('employeeToCreate.first_name') <span class="error text-red-500">{{ $message }}</span> @enderror

                            <input class="text-nav border-b-2 w-full py-2 font-bold text-sm xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                            placeholder="Last name" type="text" wire:model="employeeToCreate.last_name">
                            @error('employeeToCreate.last_name') <span class="error text-red-500">{{ $message }}</span> @enderror

                            <input class="text-nav border-b-2 w-full py-2 font-bold text-sm xxl:text-2xl placeholder-nav hover:border-nav focus:border-nav transition duration-200"
                            placeholder="Email" type="email" wire:model="employeeToCreate.email">
                            @error('employeeToCreate.email') <span class="error text-red-500">{{ $message }}</span> @enderror

                            <div class="flex flex-col w-full text-sm">
                                <span class="text-nav font-semibold">Roles:</span>
                                <div class="flex flex-row justify-between flex-wrap pt-3 gap-2">
                                    @foreach($this->roleDisplay as $role)
                                    <div class="flex flex-row items-center gap-1">
                                        <input type="checkbox" class="form-checkbox text-typeBlue-500 cursor-pointer" id="{{$loop->index}}" value="{{$role->name}}" wire:model="employeeToCreate.roles.{{$loop->index}}">
                                        {{$role->name}}
                                    </div>
                                    @endforeach
                                </div>
                                @error('employeeToCreate.role') <span class="error text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex justify-center">
                                <button class="w-32 text-center bg-personal hover:bg-hovBlue border-2 border-personal hover:border-hovBlue text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg transition duration-200 ease-in-out" 
                                type="submit">Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
