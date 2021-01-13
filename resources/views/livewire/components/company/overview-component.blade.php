<div class="flex flex-col h-full">
    <div class="flex flex-none w-full pb-4 justify-between">
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
    <div class="flex flex-auto w-full h-72">
        <div class="w-full h-full overflow-auto">
            @include('components.session-messages')
            <table class="table relative w-full flex-1 max-h-full">
                <tbody class="flex flex-wrap justify-items-stretch p-12 xxl:p-20 gap-20 sm:gap-16 xl:gap-24 xxl:gap-32">
                @foreach($employees as $employee)
                    <tr class="flex w-32 flex-col text-center">
                        <td align="center">
                            <img class="rounded-full w-16 h-16 sm:w-10 sm:h-10 md:w-12 md:h-12 xxl:w-32" src="{{$employee->avatar}}" alt="">
                        </td>
                        <td class="text-sm md:text-xs sm:text-xs xxl:text-2xl font-bold pt-2 xxl:pt-4"><p class="truncate">{{$employee->full_name}}</p></td>
                        <td class="text-xs xxl:text-xl"><p class="truncate">{{$employee->email}}</p></td>
                        <td class="pt-4 xxl:pt-8">
                            <a wire:click="toggleModal({{$employee->id}})"
                            class="cursor-pointer rounded-lg px-4 py-1 bg-blue-100 border-2 border-hovBlue hover:bg-hovBlue text-hovBlue hover:text-white text-xxs sm:text-xxs xxl:text-2xl transition duration-200 ease-in-out">
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
    </div>
</div>
