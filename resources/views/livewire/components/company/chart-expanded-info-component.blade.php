<div>
    <div>
        Information {{ $datetime ? 'for ' . $datetime : '' }}

        <table>
            <tr>
                <td>Demand: {{ $demand }}</td>
                <td>Total load: {{ $totalLoad }}</td>
            </tr>
            <tr>
                <td>Store: {{ $store }}</td>
                <td>Sold: {{ $sold }}</td>
            </tr>
            <tr>
                <td>Produce: {{ $produce }}</td>
                <td>Bought: {{ $bought }}</td>
            </tr>
            <tr>
                <td></td>
                <td>Position: {{ $position }}</td>
            </tr>
        </table>
    </div>

    <div>
        Running contracts
    </div>
</div>
