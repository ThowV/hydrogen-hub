<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">
                <div class="modal-content flex flex-col w-full h-full p-12 sm:p-4 xxl:p-16 text-left">
                    <!--Title-->
                    <div class="flex flex-none justify-between items-center pb-2">
                        @if ($trade->responder)
                            <p class="text-lg font-bold">Trade</p>
                        @else
                            <p class="text-lg font-bold">Listing</p>
                        @endif
                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <div class="flex flex-col flex-auto">
                        <h2 class="w-full text-center pb-8 font-bold">Overview</h2>

                        <div class="flex flex-auto sm:flex-col">
                           
                            <div class="w-full flex flex-col flex-auto justify-between text-sm xl:text-base xxl:text-lg sm:px-4">

                                <div class="grid grid-cols-4 flex-col gap-2 ml-48 md:ml-32">
                                    <p class="flex flex-col"><b>Hydrogen type:</b> 
                                        <span class="flex">
                                            <svg class="fill-current text-type{{ ucfirst($trade["hydrogen_type"]) }}-500"
                                            height="24" width="24">
                                            <circle cx="10" cy="12" r="4"/>
                                            </svg>        
                                            {{ $trade->hydrogen_type }}
                                        </span>
                                    </p>
                                    <p class="flex flex-col"><b>Units per hour:</b>       {{ number_format($trade->units_per_hour, 0, '.', ' ') }}</p>
                                    <p class="flex flex-col"><b>Duration:</b>             {{ $trade->end }}</p>  
                                    <p class="flex flex-col"><b>Mix CO2:</b>              {{ $trade->mix_co2 }}%</p>
                                </div>

                                <div class="grid grid-cols-4 flex-col gap-2 ml-48 md:ml-32">
                                    <p class="flex flex-col"><b>Total volume:</b>         {{ number_format($trade->total_volume, 0, '.', ' ') }} units</p>              
                                    <p class="flex flex-col"><b>Price per unit:</b> €     {{ number_format($trade->price_per_unit, 0, '.', ' ') }}</p>
                                    <p class="flex flex-col"><b>Trade type:</b>           {{ $trade->trade_type }}</p>
                                    <p class="flex flex-col"><b>Expires at:</b>           {{ $trade->expires_at }}</p>
                                </div>

                                <div class="grid grid-cols-4 flex-col gap-2 ml-48 md:ml-32">
                                    @if ($trade->responder)
                                        <p class="flex flex-col">
                                            <b>Deal made at:</b>
                                            {{ $trade->deal_made_at }}
                                        </p>
                                    @endif
                                        <p class="flex flex-col">
                                            <b>Hydrogen {{ $trade->trade_type == 'offer' ? 'offered' : 'requested' }} by:</b>
                                            {{ $trade->owner->full_name }} - {{ $trade->owner->company->name }}
                                        </p>
                                    @if ($trade->responder)
                                        <p class="flex flex-col">
                                            <b>Hydrogen {{ $trade->trade_type == 'offer' ? 'bought' : 'sold' }} by:</b>
                                            {{ $trade->responder->full_name }} - {{ $trade->responder->company->name }}
                                        </p>
                                    @endif
                                        <p class="flex flex-col">
                                            <b>Listing created at:</b>
                                            {{ $trade->created_at }}
                                        </p>
                                </div>

                                <div class="flex justify-center">
                                    <p class=""><b>Total price:</b> €        {{ number_format($trade->total_price, 0, '.', ' ') }}</p>
                                </div>

                            </div>
                        </div>
                        @if ($trade->responder)
                        <a class="flex flex-auto justify-center items-center gap-2 cursor-pointer underline pt-4" wire:click="downloadPdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15.45" height="18.025" viewBox="0 0 15.45 18.025">
                                <path id="Icon_metro-file-pdf" data-name="Icon metro-file-pdf" d="M17.337,6.026a2.34,2.34,0,0,1,.483.764,2.321,2.321,0,0,1,.2.885V19.263a.962.962,0,0,1-.966.966H3.536a.962.962,0,0,1-.966-.966V3.169A.962.962,0,0,1,3.536,2.2h9.012a2.322,2.322,0,0,1,.885.2,2.34,2.34,0,0,1,.764.483ZM12.871,3.571V7.353h3.782a1.1,1.1,0,0,0-.221-.412L13.283,3.793a1.1,1.1,0,0,0-.412-.221Zm3.862,15.369V8.641H12.549a.962.962,0,0,1-.966-.966V3.491H3.858v15.45H16.733Zm-5.17-5.965a7.653,7.653,0,0,0,.845.563,9.981,9.981,0,0,1,1.177-.07q1.479,0,1.78.493a.486.486,0,0,1,.02.523.029.029,0,0,1-.01.02l-.02.02v.01q-.06.382-.714.382a4.149,4.149,0,0,1-1.157-.2,7.334,7.334,0,0,1-1.308-.533,18.112,18.112,0,0,0-3.943.835Q6.695,17.653,5.8,17.653a.585.585,0,0,1-.282-.07l-.241-.121q-.01-.01-.06-.05a.416.416,0,0,1-.06-.362,2.184,2.184,0,0,1,.563-.92,4.861,4.861,0,0,1,1.328-.971.147.147,0,0,1,.231.06.058.058,0,0,1,.02.04q.523-.855,1.076-1.982a15.352,15.352,0,0,0,1.046-2.635,8.131,8.131,0,0,1-.307-1.6,3.911,3.911,0,0,1,.065-1.282q.111-.4.422-.4h.221a.424.424,0,0,1,.352.151.8.8,0,0,1,.091.684.218.218,0,0,1-.04.08.262.262,0,0,1,.01.08v.3a13.171,13.171,0,0,1-.141,1.931,5.089,5.089,0,0,0,1.469,2.394ZM5.769,17.11a4.441,4.441,0,0,0,1.378-1.589,5.734,5.734,0,0,0-.88.845A3.343,3.343,0,0,0,5.769,17.11Zm4-9.254a2.991,2.991,0,0,0-.02,1.328q.01-.07.07-.443,0-.03.07-.433a.226.226,0,0,1,.04-.08.029.029,0,0,1-.01-.02.02.02,0,0,0-.005-.015.02.02,0,0,1-.005-.015.579.579,0,0,0-.131-.362.029.029,0,0,1-.01.02v.02ZM8.525,14.5a14.754,14.754,0,0,1,2.857-.815,1.517,1.517,0,0,1-.131-.1,1.8,1.8,0,0,1-.161-.136,5.328,5.328,0,0,1-1.277-1.77,13.441,13.441,0,0,1-.835,1.982q-.3.563-.453.835Zm6.5-.161a2.407,2.407,0,0,0-1.408-.241,3.8,3.8,0,0,0,1.247.282.976.976,0,0,0,.181-.01q0-.01-.02-.03Z" transform="translate(-2.571 -2.204)" fill="#727272"/>
                            </svg>
                            <p class=" hover:font-semibold transaction duration-300">Download invoice here</p>
                        </a>
                        @endif
                    </div>


                <!--Footer-->
                    <div class="flex flex-none justify-center gap-10 pt-4">
                        <button
                            class="modal-close bg-white border-2 hover:bg-gray-400 hover:border-gray-400 text-gray-600 hover:text-white text-xs xxl:text-2xl py-1 px-6 xxl:py-2 xxl:px-8  rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                            wire:click="toggleModal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

