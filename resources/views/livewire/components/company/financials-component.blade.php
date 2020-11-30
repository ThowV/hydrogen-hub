<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Financials</h2>

        <div class="grid justify-items-end items-start pt-5">
            @if (!$editState)
                <svg wire:click="toggleEditState" class="opacity-25 hover:opacity-75 transaction duration-300" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                    <path id="Icon_ionic-md-settings" data-name="Icon ionic-md-settings" d="M20.97,14.375a6.254,6.254,0,0,0,.051-1c0-.35-.051-.65-.051-1l2.147-1.65a.459.459,0,0,0,.1-.65l-2.046-3.45a.5.5,0,0,0-.614-.2L18,7.425a7.443,7.443,0,0,0-1.738-1l-.358-2.65a.548.548,0,0,0-.511-.4H11.3a.548.548,0,0,0-.511.4l-.409,2.65a8.66,8.66,0,0,0-1.739,1l-2.557-1a.479.479,0,0,0-.614.2l-2.046,3.45a.6.6,0,0,0,.1.65l2.2,1.65c0,.35-.051.65-.051,1s.051.65.051,1l-2.148,1.65a.459.459,0,0,0-.1.65l2.046,3.45a.5.5,0,0,0,.614.2l2.557-1a7.442,7.442,0,0,0,1.738,1l.409,2.65a.5.5,0,0,0,.511.4h4.091a.548.548,0,0,0,.511-.4l.41-2.65a8.655,8.655,0,0,0,1.738-1l2.557,1a.479.479,0,0,0,.614-.2l2.046-3.45a.6.6,0,0,0-.1-.65Zm-7.62,2.5a3.5,3.5,0,1,1,3.58-3.5A3.519,3.519,0,0,1,13.349,16.875Z" transform="translate(-3.375 -3.375)" fill="#4a4a4a"/>
                </svg>
            @else
                <button wire:click="saveEdits" class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-green-200">✓</button>
                <button wire:click="toggleEditState" class="border rounded px-2 py-1 xxl:px-3 xxl:py-2 mx-1 hover:bg-red-200">
                    ✕
                </button>
            @endif
        </div>
    </div>

    <div>
        <input>
            <p class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Usable fund</p>

            @if (!$editState)
                <h2 class="grid items-center text-xl xxl:text-3xl">
                    € {{ number_format($this->company['usable_fund'], 0, '.', ' ') }}
                </h2>
            @else
                <label for="usableFundInput">€</label>
                <input wire:model="usableFund" type="text" id="usableFundInput" name="usableFundInput">
            @endif
        </div>

        <div>
            <p class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Bought</p>
            <h2 class="grid items-center text-xl xxl:text-3xl">
                € {{ number_format($this->company['bought'], 0, '.', ' ') }}
            </h2>
        </div>

        <div>
            <p class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Sold</p>
            <h2 class="grid items-center text-xl xxl:text-3xl">
                € {{ number_format($company['sold'], 0, '.', ' ') }}
            </h2>
        </div>
    </div>
</div>
