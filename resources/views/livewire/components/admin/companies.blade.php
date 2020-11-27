<div wire:poll.15000ms="mount">
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
                    <svg wire:click="toggleModal({{$result->id}})" class="opacity-25 hover:opacity-75 transaction duration-300" xmlns="http://www.w3.org/2000/svg"
                         width="20" height="20" viewBox="0 0 20 20">
                        <path id="Icon_ionic-md-settings" data-name="Icon ionic-md-settings"
                              d="M20.97,14.375a6.254,6.254,0,0,0,.051-1c0-.35-.051-.65-.051-1l2.147-1.65a.459.459,0,0,0,.1-.65l-2.046-3.45a.5.5,0,0,0-.614-.2L18,7.425a7.443,7.443,0,0,0-1.738-1l-.358-2.65a.548.548,0,0,0-.511-.4H11.3a.548.548,0,0,0-.511.4l-.409,2.65a8.66,8.66,0,0,0-1.739,1l-2.557-1a.479.479,0,0,0-.614.2l-2.046,3.45a.6.6,0,0,0,.1.65l2.2,1.65c0,.35-.051.65-.051,1s.051.65.051,1l-2.148,1.65a.459.459,0,0,0-.1.65l2.046,3.45a.5.5,0,0,0,.614.2l2.557-1a7.442,7.442,0,0,0,1.738,1l.409,2.65a.5.5,0,0,0,.511.4h4.091a.548.548,0,0,0,.511-.4l.41-2.65a8.655,8.655,0,0,0,1.738-1l2.557,1a.479.479,0,0,0,.614-.2l2.046-3.45a.6.6,0,0,0-.1-.65Zm-7.62,2.5a3.5,3.5,0,1,1,3.58-3.5A3.519,3.519,0,0,1,13.349,16.875Z"
                              transform="translate(-3.375 -3.375)" fill="#4a4a4a"/>
                    </svg>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
