<div>
    <h1 class="text-2xl">{{$employee->full_name}}</h1>
    <div class="flex-row">
        <input wire:dirty.class="border-red-500" class="form-control border rounded shadow " wire:model="employee.first_name" type="text">
    </div>
    <div class="flex-row">
        <input wire:dirty.class="border-red-500" class="form-control border rounded shadow " wire:model="employee.last_name" type="text">
    </div>
    IF YOU CHANGE THE EMAIL, VERIFY EMAIL PROCEDURE SHOULD START OVER
    <div class="flex-row">
        <input wire:dirty.class="border-red-500" class="form-control border rounded shadow w-full" wire:model.debounce.10000ms="employee.email" type="text">
    </div>

    <button wire:click="save" class="bg-green-500 p-2 text-white hover:bg-green-400 rounded shadow m-3">
        Save
    </button>
</div>
