@extends('layouts.app')


@section('content')
    <div class="flex h-full flex-col">
        @include('layouts.header', ['title' => 'Help'])

        <div class="h-full px-10 xxl:px-20 pb-10 xxl:pb-20 xxl:pt-10">
            <div class="flex flex-nowrap min-h-full sm:flex-col text-gray-700">
                <div class="rounded-lg px-10 pt-10 w-full min-h-full bg-white">
                    <div class="h-vh80 md:h-vh75 overflow-auto">

                        <h1 class="text-personal font-bold text-xl pb-4">Terms: Company portfolio charts</h1>

                        <p>The company portfolio charts display the total amount of hydrogen flowing into and out of the company&#39;s system. When navigating to the company portfolio page you&#39;ll be greeted with a set of charts that might look a little bit like the example below:</p>

                        <p class="flex justify-center py-6"><img class="h-96" src="{{ asset('storage/photos/ChartOverview.jpeg') }}" alt="Portfolio chart"></p>

                        <p>In this chart we see the two terms used:</p>

                        <table class="w-full my-6 border-2">
                            <thead class="w-full">
                            <tr class="w-full bg-gray-300">
                                <th class="w-1/6 text-left py-4 px-4 border-r-2 border-gray-400">Term</th>
                                <th class="text-left px-4">Meaning</th>
                            </tr>
                            </thead>
                            <tbody class="w-full bg-gray-100 divide-y">
                            <tr>
                                <td class="text-left h-20 px-4 border-r-2">Demand</td>
                                <td class="text-left px-4">The amount of hydrogen the company needs to spend or have available on a given day in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                            </tr>
                            <tr>
                                <td class="text-left h-20 px-4 border-r-2">Total load</td>
                                <td class="text-left px-4">The amount of hydrogen the company currently has in their system. This value is updated for every trade made</td>
                            </tr>
                            </tbody>
                        </table>

                        <h1 class="text-personal font-bold text-xl pb-4 pt-12">Terms: Company portfolio extended charts</h1>

                        <p>The extended company portfolio charts display the total amount of hydrogen flowing into and out of the company&#39;s system in greater detail than the standard charts. You can access this chart by pressing one of the overview charts on the company portfolio page. Once pressed you&#39;ll be greeted with a chart that looks a little bit like the following example:</p>

                        <p class="flex justify-center py-6"><img class="h-96" src="{{ asset('storage/photos/ChartExpanded.jpeg') }}" alt="Portfolio extended chart"></p>

                        <p>This chart is a zoomed in version of the standard company portfolio chart and provided a few extra options. First of all, it is important to keep in mind that this chart is zoomed in on the next 48 hours, which means it shows the next 2 days in greater detail. This chart also gives you the option to press on one of the data points for extra information about the running trades for that hour. This chart also uses a few terms:</p>

                        <table class="w-full my-6 border-2 text-left">
                            <thead class="w-full">
                            <tr class="w-full bg-gray-300">
                                <th class="w-1/6 h-20 px-4 border-r-2 border-gray-400">Term</th>
                                <th class="w-4/6 px-4 border-r-2 border-gray-400">Meaning</th>
                                <th class="w-1/6 px-4 border-r-2 border-gray-400">Impacts</th>
                            </tr>
                            </thead>
                            <tbody class="w-full bg-gray-100 divide-y ">
                            <tr>
                                <td class="h-20 px-4 border-r-2">Demand</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company needs to spend or have available on a given hour in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                                <td class="px-2"></td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Total load</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company has in their system for the given hour. This value is updated for every trade made</td>
                                <td class="px-4"></td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Produce</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company is producing in the given hour. This value is provided by the company portfolio manager or a higher-up and contributes to the total volume.</td>
                                <td class="px-4">Total volume</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Bought</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is flowing into the company&#39;s system as a result of the running trades for the given hour.</td>
                                <td class="px-4">Total load</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Store</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is being sent to storage for the given hour. This value is provided by the company portfolio manager or a higher-up.</td>
                                <td class="px-4">Total load</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Sold</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is flowing out of the company&#39;s system as a result of the running trades for the given hour.</td>
                                <td class="px-4">Total load</td>
                            </tr>
                            </tbody>
                        </table>

                        <h1 class="text-personal font-bold text-xl pb-4 pt-12">Terms: Marketplace listing creation impact chart</h1>

                        <p>When creating a listing on the marketplace for others to accept you&#39;ll be greeted with an impact chart. This impact chart shows the impact on the company portfolio chart <a href="#terms-company-portfolio-charts">that is shown here</a>. When creating a listing you can choose if the hydrogen flows into or out of the company&#39;s system, this is also known as a request or an offer. In both scenario&#39;s the chart will change direction, this will have an impact on the terms.</p>

                        <h2 class="font-bold pb-4 pt-12">Terms: Positive impact chart</h2>

                        <p class="flex justify-center py-6"><img class="h-96" src="{{ asset('storage/photos/ChartCreationImpactIn.jpeg') }}" alt="Marketplace listing creation impact chart with hydrogen flowing in"></p>

                        <p>This chart shows a listing that is specified as a request. When a company has a request for hydrogen up on the marketplace, anyone who accepts this request will be sending hydrogen towards this company. This means the amount of hydrogen present in the system of the company will be positively impacted. This positive impact chart has the following terms:</p>

                        <table class="w-full my-6 border-2 text-left">
                            <thead class="w-full">
                            <tr class="w-full bg-gray-300">
                                <th class="w-1/6 h-20 px-4 border-r-2 border-gray-400">Term</th>
                                <th class="w-4/6 px-4 border-r-2 border-gray-400">Meaning</th>
                                <th class="w-1/6 px-4 border-r-2 border-gray-400">Impacts</th>
                            </tr>
                            </thead>
                            <tbody class="w-full bg-gray-100 divide-y">
                            <tr>
                                <td class="h-20 px-4 border-r-2">Demand</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company needs to spend or have available on a given day in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                                <td class="px-4 border-r-2"></td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">New total load</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company has in their storage for the given day. This value is the final result of the hydrogen going into the system.</td>
                                <td class="px-4 border-r-2"></td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Load left</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that won&#39;t be impacted by this trade.</td>
                                <td class="px-4 border-r-2">New total load</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Load removed</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is going into the company&#39;s system that counteracts the hydrogen already flowing out of the system.</td>
                                <td class="px-4 border-r-2">New total load</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Load added</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is going into the company&#39;s system that assists the hydrogen already flowing into the system.</td>
                                <td class="px-4 border-r-2">New total load</td>
                            </tr>
                            </tbody>
                        </table>

                        <h2 class="font-bold pb-4 pt-12">Terms: Negative impact chart</h2>

                        <p class="flex justify-center py-6"><img class="h-96" src="{{ asset('storage/photos/ChartCreationImpactOut.jpeg') }}" alt="Marketplace listing creation impact chart with hydrogen flowing out">  </p>

                        <p>This chart shows a listing that is specified as an offer. When a company has an offer for hydrogen up on the marketplace, anyone who accepts this offer will be receiving hydrogen from this company. This means the amount of hydrogen present in the system of this company will be negatively impacted. This negative impact chart has the following terms:</p>

                        <table class="w-full my-6 border-2 text-left">
                            <thead class="w-full">
                            <tr class="w-full bg-gray-300">
                                <th class="w-1/6 h-20 px-4 border-r-2 border-gray-400">Term</th>
                                <th class="w-1/6 px-4 border-r-2 border-gray-400">Meaning</th>
                                <th class="w-1/6 px-4 border-r-2 border-gray-400">Impacts</th>
                            </tr>
                            </thead>
                            <tbody class="w-full bg-gray-100 divide-y">
                            <tr>
                                <td class="h-20 px-4 border-r-2">Demand</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company needs to spend or have available on a given day in order to function. This value is provided by the company portfolio manager or a higher-up.</td>
                                <td class="px-4 border-r-2"></td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">New total load</td>
                                <td class="px-4 border-r-2">The amount of hydrogen the company has in their storage for the given day. This value is the final result of the hydrogen going into the system.</td>
                                <td class="px-4 border-r-2"></td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Load left</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that won&#39;t be impacted by this trade.</td>
                                <td class="px-4 border-r-2">New total load</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Load removed</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is going out of the company&#39;s system that counteracts the hydrogen already flowing into the system.</td>
                                <td class="px-4 border-r-2">New total load</td>
                            </tr>
                            <tr>
                                <td class="h-20 px-4 border-r-2">Load added</td>
                                <td class="px-4 border-r-2">The amount of hydrogen that is going out of the company&#39;s system that assists the hydrogen already flowing out of the system.</td>
                                <td class="px-4 border-r-2">New total load</td>
                            </tr>
                            </tbody>
                        </table>

                        <h1 class="text-personal font-bold text-xl pb-4 pt-12">Terms: Marketplace listing responding impact chart</h1>

                        <p class="pb-12">When responding to a listing on the marketplace that others have placed you'll be greeted with an impact chart. Just like the <b>creation impact chart</b>, this chart shows the impact on the company portfolio chart.
                            When looking for a listing on the marketplace you can specify whether you want to buy or sell hydrogen, this is also known as responding to an offer and responding to a request. In both scenario's the chart will change direction.
                            The terms of these charts correspond to the terms of the positive and negative <b>listing creation impact chart.</b></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
