<div>
    <ul>
        @foreach($roles as $role)
            <input type="checkbox" value="{{$role->name}}" class="text-black">{{$role->name}}</input>
        @endforeach
    </ul>
</div>
