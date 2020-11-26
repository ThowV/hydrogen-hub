<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Financials</h2>
    </div>

    <div>
        <div>
            <p class="py-3 xxl:py-5 sm:text-xxs text-xs xl:text-sm xxl:text-2xl">Usable fund</p>
            <h2 class="grid items-center text-xl xxl:text-3xl">
                € {{ number_format($this->company['usable_fund'], 0, '.', ' ') }}
            </h2>
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
