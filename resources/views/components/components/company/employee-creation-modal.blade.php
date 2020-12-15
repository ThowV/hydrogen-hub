<div class="z-40 relative w-full text-gray-700">

    <div class="modal fixed top-0 left-0 h-full w-full grid grid-cols-8 grid-rows-6">

        <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleEmployeeCreationModal()"></div>

        <div class="modal-container max-h-full max-w-full grid col-start-2 sm:col-start-3 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">
            <p class="text-gray">Create User</p>
            <form class="bg-gray-500" wire:submit.prevent="submitCreateUser">
                <input type="text" wire:model="employeeToCreate.first_name">
                @error('employeeToCreate.first_name') <span class="error text-red-500">{{ $message }}</span> @enderror

                <input type="text" wire:model="employeeToCreate.last_name">
                @error('employeeToCreate.last_name') <span class="error text-red-500">{{ $message }}</span> @enderror

                <input type="email" wire:model="employeeToCreate.email" >
                @error('employeeToCreate.email') <span class="error text-red-500">{{ $message }}</span> @enderror


                @foreach($this->roleDisplay as $role)
                    <input type="checkbox" id="{{$loop->index}}" value="{{$role->name}}" wire:model="employeeToCreate.roles.{{$loop->index}}">{{$role->name}}
                @endforeach
                @error('employeeToCreate.role') <span class="error text-red-500">{{ $message }}</span> @enderror
                <input type="submit">
            </form>
        </div>
    </div>
</div>
</div>
