<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    <h1>Invoice deal #{{ $trade['id']  }}</h1>

    <h2>Trade</h2>
    <hr/>
    <table>
        <tr>
            <th>Made at</th>
            <td>{{ $trade["deal_made_at"] }}</td>
        </tr>

        <tr>
            <th>Hydrogen {{ $trade["trade_type"] == 'offer' ? 'offered' : 'requested' }} by user</th>
            <td>{{ $trade["owner"]['full_name'] }}</td>
        </tr>

        <tr>
            <th>Hydrogen {{ $trade["trade_type"] == 'offer' ? 'offered' : 'requested' }} by company</th>
            <td>{{ $trade["owner"]['company']['name'] }}</td>
        </tr>

        <tr>
            <th>Hydrogen {{ $trade["trade_type"] == 'offer' ? 'bought' : 'sold' }} by user</th>
            <td>{{ $trade["responder"]['full_name'] }}</td>
        </tr>

        <tr>
            <th>Hydrogen {{ $trade["trade_type"] == 'offer' ? 'bought' : 'sold' }} by company</th>
            <td>{{ $trade["responder"]['company']['name'] }}</td>
        </tr>
    </table>

    <h2>Payment method</h2>
    <hr/>
    <table>
        <tr>
            <th>Options could be: Per unit / Instant / Afterpay</th>
        </tr>
        <tr>
            <th>Options could be: Middle man (safe) / Direct (Not as safe)</th>
        </tr>
    </table>

    <h2>Listing</h2>
    <hr/>
    <table>
        <tr>
            <th>Created at</th>
            <td>{{ $trade["created_at"] }}</td>
        </tr>

        <tr>
            <th>Listing type</th>
            <td>{{ $trade["trade_type"] }}</td>
        </tr>

        <tr>
            <th>Hydrogen type</th>
            <td>{{ $trade["hydrogen_type"] }}</td>
        </tr>

        <tr>
            <th>Units per hour</th>
            <td>{{ $trade["units_per_hour"] }}</td>
        </tr>

        <tr>
            <th>Price per unit</th>
            <td>€ {{ number_format($trade['price_per_unit'], 0, '.', ' ') }}</td>
        </tr>

        <tr>
            <th>Duration</th>
            <td>{{ $trade["end"] }}</td>
        </tr>

        <tr>
            <th>Total volume</th>
            <td>{{ number_format($trade['total_volume'], 0, '.', ' ') }} units</td>
        </tr>

        <tr>
            <th>Total price</th>
            <td>€ {{ number_format($trade['total_price'], 0, '.', ' ') }}</td>
        </tr>

        <tr>
            <th>Mix CO2</th>
            <td>{{ $trade["mix_co2"] }}%</td>
        </tr>
    </table>
</body>

<style>
    table {
        width: 100%;
    }
    th {
        text-align: left;
    }
</style>
</html>
