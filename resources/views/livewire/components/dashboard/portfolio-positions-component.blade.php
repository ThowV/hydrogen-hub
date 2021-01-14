<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Portfolio Positions</h2>
    </div>
    <table>
        <tr>
            <th></th>
            <th>Short next day</th>
            <th>Short 3 months</th>
        </tr>
        @foreach(['blue','grey','green'] as $hydrogen_type)
        <tr class="py-2 flex flex-row">
            <td>
                <svg class="fill-current text-type{{ucfirst($hydrogen_type)}}-500" height="24" width="50">
                    <circle cx="10" cy="12" r="6"/>
                </svg>
                {{ucfirst($hydrogen_type)}}
            </td>
            <td>
                @if(auth()->user()->company->isShortOnDayForType(\Carbon\Carbon::tomorrow(), $hydrogen_type))
                    {{auth()->user()->company->shortOnDayForType(\Carbon\Carbon::tomorrow(), $hydrogen_type)}}
                @endif
            </td>
            <td></td>
        </tr>
        @endforeach
    </table>
</div>
