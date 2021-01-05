<div class="flex flex-col h-full">
    <div class="flex flex-none w-full justify-between">
        <h2 class="text-base xxl:text-3xl font-bold">Employees</h2>
        <button class="text-sm xxl:text-2xl bg-none font-semibold text-gray-600 hover:text-gray-800 transaction duration-300"
                wire:click="toggleEmployeeCreationModal"> + Add employee
        </button>
    </div>

    @if($modalOpen)
        <x-company.overview-modal :employeeToUpdate="$employeeToUpdate"></x-company.overview-modal>
    @endif

    @if($addEmployeeModalOpen)
        <x-components.company.employee-creation-modal></x-components.company.employee-creation-modal>
    @endif
    @include('components.session-messages')
    <table class="table w-full flex-1 h-full">
        <tbody class="flex flex-wrap justify-between p-12 xxl:p-20 gap-16 xxl:gap-24">
        @foreach($employees as $employee)
            <tr class="flex flex-col text-center">
                <td align="center">
                    <img class="rounded-full xxl:w-32" src="{{$employee->avatar}}" alt="">
                </td>
                <td class="text-sm xxl:text-2xl font-bold pt-2 xxl:pt-4">{{$employee->full_name}}</td>
                <td class="text-xs xxl:text-xl">{{$employee->email}}</td>
                <td class="pt-4 xxl:pt-8">
                    <a wire:click="toggleModal({{$employee->id}})"
                       class="rounded-lg px-4 py-1 bg-blue-100 border-2 border-hovBlue hover:bg-hovBlue text-hovBlue hover:text-white text-xxs sm:text-xxs xxl:text-2xl transition duration-200 ease-in-out">
                        <button>View</button>
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
