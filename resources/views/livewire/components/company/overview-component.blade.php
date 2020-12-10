<div>
    <h1 class="text-xl">Employee list component</h1>


    @if($modalOpen)
        <x-company.overview-modal :employeeToUpdate="$employeeToUpdate"></x-company.overview-modal>
    @endif

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
        @foreach($employees as $employee)
            <tr class="text-center">
                <td align="center">
                    <img src="{{$employee->avatar}}" alt="">
                </td>
                <td>{{$employee->full_name}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->created_at}}</td>
                <td>
                    <a wire:click="toggleModal({{$employee->id}})" class="rounded p-2 bg-yellow-500">
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
