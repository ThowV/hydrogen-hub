<div class="h-full w-full">
    <div class="flex flex-none w-full justify-between">
        <h2 class="xxl:text-3xl font-bold pb-6"">Portfolio Positions</h2>

        <a class="text-xs text-gray-600 font-semibold hover:text-gray-800 duration-300 transform -translate-y-4 translate-x-4 cursor-pointer" href="{{route('company.portfolio')}}">Go to portfolio</a>
    </div>
    <div class="w-full h-full text-xs md:text-xxs xxl:text-xl">

        <div class="flex flex-none w-full font-semibold border-b-2 text-gray-600 text-left">
            <p class="w-1/3"></p>
            <p class="w-1/3">Short - next day</p>
            <p class="w-1/3">Long - 3 months</p>
        </div>

        <div class="w-full h-full pb-12 flex flex-auto flex-col justify-around text-sm md:text-xs font-semibold">
            @foreach(['green','blue','grey'] as $hydrogen_type)
            <div class="py-2 flex">
                <div class="w-1/3 flex items-center">
                    <svg class="fill-current text-type{{ucfirst($hydrogen_type)}}-500" height="24" width="50">
                        <circle cx="10" cy="12" r="6"/>
                    </svg>
                    {{ucfirst($hydrogen_type)}}
                </div>
                <div class="w-1/3">
                    @if(auth()->user()->company->isShortOnDayForType(\Carbon\Carbon::tomorrow(), $hydrogen_type))
                        {{auth()->user()->company->shortOnDayForType(\Carbon\Carbon::tomorrow(), $hydrogen_type)}}
                    @endif
                </div>
                <div></div>
            </div>
            @endforeach
        </div>
    </div>
</div>
