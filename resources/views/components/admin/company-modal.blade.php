<div>
    <div class="modal fixed w-full h-full top-0 left-0 z-50 flex items-center justify-center">
        <div class="modal-overlay absolute w-full h-full z-50 bg-gray-900 opacity-50" wire:click="toggleModal()">

        </div>
        <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
            <h1 class="text-2xl">Company name: {{$companyInModal->name}}</h1>
            <p>Owner Name: {{ $companyInModal->owner->full_name }}</p>
            <p>Owner Email: {{ $companyInModal->owner->email }}</p>

            <p>Activity</p>
            <table>
                @foreach($companyInModal->trades()->paginate(10) as $trade)
                    <tr>
                        <td>
                            Trade
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
</div>
