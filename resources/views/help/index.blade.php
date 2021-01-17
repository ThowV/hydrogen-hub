@extends('layouts.app')


@section('content')
    <div class="flex h-full flex-col">
        @include('layouts.header', ['title' => 'Help'])

        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex flex-nowrap min-h-full sm:flex-col text-gray-700">
                <div class="rounded-lg px-10 mr-4 w-full sm:w-full sm:mr-0 md:w-2/4 bg-white">
                    <h1>Terms: Company portfolio charts</h1>

                    <p>The company portfolio charts display the total amount of hydrogen flowing into and out of the company&#39;s system. When navigating to the company portfolio page you&#39;ll be greeted with a set of charts that might look a little bit like the example below:</p>

                    <p><img src="{{ asset('storage/photos/ChartOverview.png') }}" alt="Portfolio chart"></p>

                    <p>In this chart we see the two terms used:</p>

                    <table><thead>
                        <tr>
                            <th>Term</th>
                            <th>Meaning</th>
                        </tr>
                        </thead><tbody>
                        <tr>
                            <td>Demand</td>
                            <td>The amount of hydrogen the company needs to spend or have available on a given day in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                        </tr>
                        <tr>
                            <td>Total load</td>
                            <td>The amount of hydrogen the company currently has in their system. This value is updated for every trade made</td>
                        </tr>
                        </tbody></table>

                    <h1>Terms: Company portfolio extended charts</h1>

                    <p>The extended company portfolio charts display the total amount of hydrogen flowing into and out of the company&#39;s system in greater detail than the standard charts. You can access this chart by pressing one of the overview charts on the company portfolio page. Once pressed you&#39;ll be greeted with a chart that looks a little bit like the following example:</p>

                    <p><img src="{{ asset('storage/photos/ChartExpanded.png') }}" alt="Portfolio extended chart"></p>

                    <p>This chart is a zoomed in version of the standard company portfolio chart and provided a few extra options. First of all, it is important to keep in mind that this chart is zoomed in on the next 48 hours, which means it shows the next 2 days in greater detail. This chart also gives you the option to press on one of the data points for extra information about the running trades for that hour. This chart also uses a few terms:</p>

                    <table><thead>
                        <tr>
                            <th>Term</th>
                            <th>Meaning</th>
                            <th>Impacts</th>
                        </tr>
                        </thead><tbody>
                        <tr>
                            <td>Demand</td>
                            <td>The amount of hydrogen the company needs to spend or have available on a given hour in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Total load</td>
                            <td>The amount of hydrogen the company has in their system for the given hour. This value is updated for every trade made</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Produce</td>
                            <td>The amount of hydrogen the company is producing in the given hour. This value is provided by the company portfolio manager or a higher-up and contributes to the total volume.</td>
                            <td>Total volume</td>
                        </tr>
                        <tr>
                            <td>Bought</td>
                            <td>The amount of hydrogen that is flowing into the company&#39;s system as a result of the running trades for the given hour.</td>
                            <td>Total load</td>
                        </tr>
                        <tr>
                            <td>Store</td>
                            <td>The amount of hydrogen that is being sent to storage for the given hour. This value is provided by the company portfolio manager or a higher-up.</td>
                            <td>Total load</td>
                        </tr>
                        <tr>
                            <td>Sold</td>
                            <td>The amount of hydrogen that is flowing out of the company&#39;s system as a result of the running trades for the given hour.</td>
                            <td>Total load</td>
                        </tr>
                        </tbody></table>

                    <h1>Terms: Marketplace listing creation impact chart</h1>

                    <p>When creating a listing on the marketplace for others to accept you&#39;ll be greeted with an impact chart. This impact chart shows the impact on the company portfolio chart <a href="#terms-company-portfolio-charts">that is shown here</a>. When creating a listing you can choose if the hydrogen flows into or out of the company&#39;s system, this is also known as a request or an offer. In both scenario&#39;s the chart will change direction, this will have an impact on the terms.</p>

                    <h2>Terms: Positive impact chart</h2>

                    <p><img src="{{ asset('storage/photos/ChartCreationImpactIn.png') }}" alt="Marketplace listing creation impact chart with hydrogen flowing in"></p>

                    <p>This chart shows a listing that is specified as a request. When a company has a request for hydrogen up on the marketplace, anyone who accepts this request will be sending hydrogen towards this company. This means the amount of hydrogen present in the system of the company will be positively impacted. This positive impact chart has the following terms:</p>

                    <table><thead>
                        <tr>
                            <th>Term</th>
                            <th>Meaning</th>
                            <th>Impacts</th>
                        </tr>
                        </thead><tbody>
                        <tr>
                            <td>Demand</td>
                            <td>The amount of hydrogen the company needs to spend or have available on a given day in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>New total load</td>
                            <td>The amount of hydrogen the company has in their storage for the given day. This value is the final result of the hydrogen going into the system.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Load left</td>
                            <td>The amount of hydrogen that won&#39;t be impacted by this trade.</td>
                            <td>New total load</td>
                        </tr>
                        <tr>
                            <td>Load removed</td>
                            <td>The amount of hydrogen that is going into the company&#39;s system that counteracts the hydrogen already flowing out of the system.</td>
                            <td>New total load</td>
                        </tr>
                        <tr>
                            <td>Load added</td>
                            <td>The amount of hydrogen that is going into the company&#39;s system that assists the hydrogen already flowing into the system.</td>
                            <td>New total load</td>
                        </tr>
                        </tbody></table>

                    <h2>Terms: Negative impact chart</h2>

                    <p><img src="{{ asset('storage/photos/ChartCreationImpactOut.png') }}" alt="Marketplace listing creation impact chart with hydrogen flowing out">  </p>

                    <p>This chart shows a listing that is specified as an offer. When a company has an offer for hydrogen up on the marketplace, anyone who accepts this offer will be receiving hydrogen from this company. This means the amount of hydrogen present in the system of this company will be negatively impacted. This negative impact chart has the following terms:</p>

                    <table><thead>
                        <tr>
                            <th>Term</th>
                            <th>Meaning</th>
                            <th>Impacts</th>
                        </tr>
                        </thead><tbody>
                        <tr>
                            <td>Demand</td>
                            <td>The amount of hydrogen the company needs to spend or have available on a given day in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>New total load</td>
                            <td>The amount of hydrogen the company has in their storage for the given day. This value is the final result of the hydrogen going into the system.</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Load left</td>
                            <td>The amount of hydrogen that won&#39;t be impacted by this trade.</td>
                            <td>New total load</td>
                        </tr>
                        <tr>
                            <td>Load removed</td>
                            <td>The amount of hydrogen that is going out of the company&#39;s system that counteracts the hydrogen already flowing into the system.</td>
                            <td>New total load</td>
                        </tr>
                        <tr>
                            <td>Load added</td>
                            <td>The amount of hydrogen that is going out of the company&#39;s system that assists the hydrogen already flowing out of the system.</td>
                            <td>New total load</td>
                        </tr>
                        </tbody></table>

                    <h1>Terms: Marketplace listing responding impact chart</h1>

                    <p>When responding to a listing on the marketplace that others have placed you&#39;ll be greeted with an impact chart. <a href="#terms-marketplace-listing-creation-impact-chart">Just like the creation impact chart</a>, this chart shows the impact on the company portfolio chart <a href="#terms-company-portfolio-charts">that is shown here</a>. When looking for a listing on the marketplace you can specify whether you want to buy or sell hydrogen, this is also known as responding to an offer and responding to a request. In both scenario&#39;s the chart will change direction. The terms of these charts correspond to the terms of the <a href="#terms-positive-impact-chart">positive</a> and <a href="#terms-negative-impact-chart">negative</a> listing creation impact chart.</p>
                </div>
            </div>
        </div>
    </div>
@endsection()
