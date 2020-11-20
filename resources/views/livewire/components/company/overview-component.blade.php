<div>
    <h1 class="text-xl">Employee list component</h1>

    <table class="table w-full border">
        <tr>
            <th>Employee avatar</th>
            <th>Employee name</th>
            <th>Employee email</th>
            <th>Employee created at</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        <tbody>
        @if($updateMode)
            <tr class="text-center">
                <form wire:submit.stop>
                    <td align="center">
                        <input wire:model="employeeToUpdate.picture_url" type="text"/>
                    </td>
                    <td>
                        <input wire:model="employeeToUpdate.first_name" type="text"/>
                        <input wire:model="employeeToUpdate.last_name" type="text"/>
                    </td>
                    <td>
                        <input wire:model="employeeToUpdate.email" type="text"/></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button wire:click="saveUpdate" type="submit" class="p-2 bg-green-500 rounded text-white" autofocus>Submit</button>
                    </td>
                </form>
            </tr>
        @endif
        @foreach($employees as $employee)
            <tr class="text-center">
                <td align="center">
                    <img src="{{$employee->avatar}}" alt="">
                </td>
                <td>{{$employee->full_name}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->created_at}}</td>
                <td>
                    <a wire:click="$emitUp('updateModeEnabled', {{$employee->id}})" class="rounded p-2 bg-yellow-500">
                        <button>Update</button>
                    </a>
                </td>
                <td>
                    @if(!$employee->id == auth()->id() && !$employee->hasRole(['Super Admin','Admin']))
                        <form action="{{ route('employees.destroy',$employee->id) }}"
                              method="post" class="rounded p-2 bg-red-500">
                            <button>Delete</button>
                            @method('delete')
                            @csrf
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
