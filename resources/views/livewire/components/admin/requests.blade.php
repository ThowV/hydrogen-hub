<div class="overflow-scroll">
    <h2 class="text-gray text-2xl mb-3">Companies requesting access</h2>
    <table class="w-full table table-borderless">
        <thead>
        <tr>
            <th class="text-left">Company Name</th>
            <th class="text-left">Company Email</th>
            <th class="">Accept</th>
            <th class="">Deny</th>
        </tr>
        </thead>
        <tbody>
        @foreach($requests as $request)
            <tr class="text-sm text-gray-700 font-semibold">
                <td class="text-left">{{$request->company_name}}</td>
                <td class="text-left">{{$request->company_admin_email}}</td>
                <td class="text-center">
                    <a href="{{route('request.accept', $request->id)}}">
                        <button
                            class="text-white bg-green-600 rounded p-2 mx-1">Allow
                        </button>
                    </a>
                </td>
                <td class="text-center ">
                    <a href="{{route('request.deny', $request->id)}}">
                        <button
                            class="text-white bg-red-600 rounded p-2 mx-1">Deny
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
