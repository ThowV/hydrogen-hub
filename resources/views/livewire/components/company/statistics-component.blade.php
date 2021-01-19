<div class="flex justify-between text-sm xxl:text-2xl">
    <div class="flex gap-4 text-sm xxl:text-2xl">
        <p>Total volumes traded:</p>
        <p class="font-bold">{{number_format($company->total_volumes_traded, 0, '.', ' ')}}</p>
    </div>

    <div class="flex gap-4 text-sm xxl:text-2xl">
        <p>Total trades:</p>
        <p class="font-bold">{{count($company->trades)}}</p>
    </div>

    <div class="flex gap-4 text-sm xxl:text-2xl">
        <p>Total employees:</p>
        <p class="font-bold">{{count($company->employees)}}</p>
    </div>
</div>
