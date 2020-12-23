    <div class="flex items-center h-24 xxl:h-32">
        <h2 class="text-xl xxl:text-3xl font-bold">Requests</h2>
    </div>

    <table class="w-full">
        <thead>
        <tr class="border-b-2 text-gray-600">
            <th class="text-left text-sm sm:text-xs xxl:text-xl">Company Name</th>
            <th class="text-left text-sm sm:text-xs xxl:text-xl">Company Email</th>
            <th class="text-sm sm:text-xxs md:text-xs xxl:text-lg">Accept</th>
            <th class="text-sm sm:text-xxs md:text-xs xxl:text-lg">Deny</th>
        </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            <tr class="text-gray-700 font-semibold">
                <td class="text-left py-3 text-xs sm:text-xxs xl:text-sm xxl:text-2xl">{{$request->company_name}}</td>
                <td class="text-left py-3 text-xs sm:text-xxs xl:text-sm xxl:text-2xl">{{$request->company_admin_email}}</td>
                <td class="text-center">
                    <a href="{{route('request.accept', $request->id)}}">
                        <button
                            class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-green-200">✓
                        </button>
                    </a>
                </td>
                <td class="text-center">
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

