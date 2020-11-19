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
        @foreach($employees as $employee)
            <tr class="text-center">
                <td align="center">
                    <img src="{{$employee->avatar}}" alt="">
                </td>
                <td>{{$employee->full_name}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->created_at}}</td>
                <td>
                    <a href="{{ route('employees.update', [$employee->id]) }}" class="rounded p-2 bg-yellow-500">
                        <button>Update</button>
                    </a>
                </td>
                <td>
                    <form action="{{ route('employees.destroy',$employee->id) }}" method="post" class="rounded p-2 bg-red-500">
                        <button>Delete</button>
                        @method('delete')
                        @csrf
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
