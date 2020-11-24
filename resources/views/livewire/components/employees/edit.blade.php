<div>
    <h1 class="text-2xl">{{$employee->full_name}}</h1>

    <div class="flex-row">
        <input wire:dirty.class="border-red-500" class="form-control border rounded shadow "
               wire:model="employee.first_name" type="text">
        @error('employee.first_name') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="flex-row">
        <input wire:dirty.class="border-red-500" class="form-control border rounded shadow "
               wire:model="employee.last_name" type="text">
        @error('employee.last_name') <span class="error">{{ $message }}</span> @enderror
    </div>
    IF YOU CHANGE THE EMAIL, VERIFY EMAIL PROCEDURE SHOULD START OVER
    <div class="flex-row">
        <input wire:dirty.class="border-red-500" class="form-control border rounded shadow w-full"
               wire:model.debounce.10000ms="employee.email" type="text">
        @error('employee.email') <span class="error">{{ $message }}</span> @enderror
    </div>

    <button wire:click="save" class="bg-green-500 p-2 text-white hover:bg-green-400 rounded shadow m-3">
        Save
    </button>
</div>
