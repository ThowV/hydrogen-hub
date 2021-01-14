<div>
    <div class="w-full h-24 xxl:h-32 grid grid-rows-1 grid-cols-2">
        <h2 class="grid items-center text-xl xxl:text-3xl font-bold">Portfolio Positions</h2>
        {{auth()->user()->company->isShortOnDayForType(\Carbon\Carbon::today(), 'grey')}}
    </div>
    <table>
        <tr>
            <th></th>
            <th>Short next day</th>
            <th>Short 3 months</th>
        </tr>
        <tr class="py-2 flex flex-row">
            <td>
                <svg class="fill-current text-typeGreen-500" height="24" width="50">
                    <circle cx="10" cy="12" r="6"/>
                </svg>
                Green
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <svg class="fill-current text-typeBlue-500" height="24" width="50">
                    <circle cx="10" cy="12" r="6"/>
                </svg>
                Blue
            </td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>
                <svg class="fill-current text-typeGrey-500" height="24" width="50">
                    <circle cx="10" cy="12" r="6"/>
                </svg>
                Grey
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>
