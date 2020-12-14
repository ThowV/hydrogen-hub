<div>
    {{$user->full_name}}
    {{--@MARTIJN deze heb ik even neergezet zo, misschien even kijken of je iets in deze richting mooi kwijt kunt.--}}
    User has roles: Please select new roles as all will be cleared and reset.
    <ul>
        @foreach($user->roles as $role)
            <li>{{$role->name}}</li>
        @endforeach
    </ul>
    <ul>
        @foreach($roles as $role)
            <input type="checkbox" value="{{$role->name}}" class="text-black" wire:model="roleInputs"
                   @if($user->hasRole($role)) checked="true" @endif />
            {{$role->name}}
        @endforeach
    </ul>
</div>
