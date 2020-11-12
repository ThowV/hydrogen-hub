<div>
    <h2 class="text-gray text-2xl">Companies requesting access</h2>
    <table class="table-auto border">
        <tr>
            <th class="text-bold">Company Name</th>
            <th class="text-bold">Company Email</th>
            <th>Accept</th>
            <th>Deny</th>
        </tr>
        @foreach($requests as $request)
        <tr class="border-2">
            <td class="border">{{$request->company_name}}</td>
            <td class="border">{{$request->company_email}}</td>
            <td class="border">
                <a href="{{route('request.accept', $request->id)}}">
                    <button
                        class="text-white bg-green-600 rounded p-2 mx-1">Allow
                    </button>
                </a>
            </td>
            <td class="border">
                <a href="{{route('request.deny', $request->id)}}">
                    <button
                        class="text-white bg-red-600 rounded p-2 mx-1">Deny
                    </button>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
</div>
