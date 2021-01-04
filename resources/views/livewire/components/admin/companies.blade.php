<div>
    @if($modalOpen)
        <x-admin.company-modal :companyInModal="$companyInModal"/>
    @endif

    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Platform companies</h2>

        <div class="grid justify-items-end items-start pt-5">
            <input
                class="truncate rounded-xl bg-gray-200 px-8 py-1 text-xs xxl:text-xl w-1/3 md:w-2/3 sm:w-2/3 text-center transaction duration-300 hover:bg-gray-300 focus:bg-gray-300"
                type="text" wire:model="searchTerm"
                placeholder="search">
        </div>
    </div>


    <table class="w-full">
        <thead>
        <tr class="border-b-2 text-gray-600">
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Company Name</th>
            <th class="text-left sm:text-xs text-sm xxl:text-xl">Company Owner</th>
            <th class="text-right text-gray-600 text-sm xxl:text-lg sm:text-xxs md:text-xxs hover:text-nav transaction duration-300">
                <a href="{{route('company.register')}}">
                    + Add company
                </a>
            </th>
        </tr>
        </thead>

        <tbody>
        @foreach($resultSet as $result)
            <tr class="text-sm font-semibold text-gray-700 ">
                <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">{{$result->name}}</td>
                <td class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">{{$result->owner->email}}</td>
                <td class="flex justify-end items-center pr-5 py-3 xxl:py-5">
                    <i class="fas fa-cog fa-2x opacity-25 hover:opacity-75 transaction duration-300 z-10" wire:click="toggleModal({{$result->id}})"></i>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
