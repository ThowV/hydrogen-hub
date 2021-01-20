<div class="w-full flex text-sm">
    <div class="w-2/4 gap-3">
        <label class="text-sm" for="">Roles:</label>
        <ul class="flex flex-row flex-wrap gap-3 pt-3">
            @foreach($user->roles as $role)
                <li class="rounded-xl bg-gray-200 px-4 py-1 font-semibold sm:text-xs xxl:text-xl">{{$role->name}}</li>
            @endforeach
        </ul>
    </div>

    <div class="w-2/4">
        <label class="text-sm" for="">Change roles:</label>
        <ul class="flex flex-wrap gap-3 pt-4 pb-2">
            @foreach($roles as $role)
                <div class="sm:text-xs xxl:text-xl">
                    <input type="checkbox" value="{{$role->name}}" class="form-checkbox text-typeBlue-500 cursor-pointer" wire:model="roleInputs"
                        @if($user->hasRole($role)) checked="true" @endif />
                    {{$role->name}}
                </div>
            @endforeach
        </ul>
        <span class="text-xs sm:text-xxs font-semibold">The roles will automatically reset and save.</span>
    </div>
</div>
