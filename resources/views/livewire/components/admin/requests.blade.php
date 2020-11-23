
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">

        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Requests</h2>

        <div class="grid justify-items-end items-start pt-5">
            <input class="truncate rounded-xl bg-gray-200 px-8 py-1 text-xs xxl:text-xl w-2/3 text-center transaction duration-300 hover:bg-gray-300 focus:bg-gray-300" type="text" wire:model="searchTerm"
                placeholder="search a company name">
        </div>
    </div>

    <table class="w-full">
        <thead>
        <tr class="truncate border-b-2 text-gray-600">
            <th class="text-left text-sm sm:text-xs xxl:text-xl ">Company Name</th>
            <th class="text-left text-sm sm:text-xs xxl:text-xl">Company Email</th>
            <th class="text-sm sm:text-xxs md:text-xs xxl:text-lg">Accept</th>
            <th class="text-sm sm:text-xxs md:text-xs xxl:text-lg">Deny</th>
        </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            <tr class="text-sm text-gray-700 font-semibold">
                <td class="text-left py-3 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">{{$request->company_name}}</td>
                <td class="text-left py-3 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">{{$request->company_admin_email}}</td>
                <td class="text-center">
                    <a href="{{route('request.accept', $request->id)}}">
                        <button
                            class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-green-200">✓
                        </button>
                    </a>
                </td>
                <td class="text-center ">
                    <a href="{{route('request.deny', $request->id)}}">
                        <button
                            class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-red-200">✕
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

