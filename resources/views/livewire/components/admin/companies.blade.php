<div wire:poll.15000ms="mount">
    <div class="flex flex-row-reverse ">
        <input class="w-1/2 border focus:border-blue-400 rounded text-base p-2" type="text" wire:model="searchTerm"
               placeholder="Search a company">
        <h2 class="w-1/2 text-gray text-2xl mb-3">Companies requesting access</h2>
    </div>
    <table class="w-full table table-borderless">
        <thead>
        <tr>
            <th class="text-left">Company Name</th>
            <th class="text-left">Owner</th>
            <th class="text-right text-gray-500 text-sm">
                <a href="{{route('company.register')}}">
                    + Add company
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($resultSet as $result)
            <tr class="text-sm font-semibold">
                <td>{{$result['name']}}</td>
                <td>{{$result->owner->email}}</td>
                <td class="text-right py-1 pr-5"><i class="fa fa-cog fa-lg"></i></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
