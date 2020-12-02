<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">
                <div class="modal-content flex flex-col w-full h-full p-12 sm:p-4 xxl:p-16 text-left">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-5 sm:pb-2">
                        <p class="text-xl xxl:text-4xl font-bold">Create listing</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer h-full z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <div class="labels flex flex-row justify-between flex-wrap border-b-2 pb-2 text-sm sm:text-xxs md:text-xs xxl:text-2xl">
                        <label class="w-40 md:w-28 xxl:w-64">Hydrogen type</label>
                        <label class="w-40 md:w-28 xxl:w-64">Units per hour</label>
                        <label class="w-40 md:w-28 xxl:w-64">Duration</label>
                        <label class="w-40 md:w-28 xxl:w-64">Price per unit</label>
                        <label class="w-40 md:w-28 xxl:w-64">Mix CO2</label>
                        <label class="w-40 md:w-28 xxl:w-64">Trade type</label>
                        <label class="w-40 md:w-28 xxl:w-64">Expire in</label>
                    </div>

                    <!--Creation form-->
                    <form class="flex flex-row justify-between pt-5 flex-wrap text-sm xxl:text-3xl" wire:submit.prevent="submit">
                        <div class="w-40 md:w-28 xxl:w-64">
                            <fieldset class="flex flex-col sm:flex-row sm:flex-wrap gap-5">
                                <div>
                                    <input class="form-radio bg-gray-200 text-typeGreen-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="green">
                                    <label class="pl-4">green</label>
                                </div>

                                <div class="">
                                    <input class="form-radio bg-gray-200 text-typeBlue-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="blue">
                                    <label class="pl-4">blue</label>
                                </div>

                                <div class="">
                                    <input class="form-radio bg-gray-200 text-typeGrey-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="grey">
                                    <label class="pl-4">grey</label>
                                </div>

                                <div class="">
                                    <input class="form-radio bg-gray-200 text-typeMix-500 h-4 w-4 xxl:h-6 xxl:h-6" type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="mix">
                                    <label class="pl-4">mix</label>
                                </div>
                            </fieldset>
                            @error('hydrogen_type') <span>{{ $message }}</span> @enderror
                        </div>

                        <div class="w-40 md:w-28 xxl:w-64">
                            <input class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="units_per_hour">
                            @error('units_per_hour') <span>{{ $message }}</span> @enderror
                        </div>

                        <div class="w-40 md:w-28 xxl:w-64 flex flex-row items-start">
                            <input class="w-2/4 bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="duration">
                            <select class="w-2/4 px-2 py-1" name="duration_type" wire:model="duration_type">
                                <option value="day">Days</option>
                                <option value="week">Weeks</option>
                                <option value="month">Months</option>
                            </select>
                            @error('duration') <span>{{ $message }}</span> @enderror
                        </div>

                        <div class="w-40 md:w-28 xxl:w-64">
                            <input class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="price_per_unit">
                            @error('price_per_unit') <span>{{ $message }}</span> @enderror
                        </div>

                        <div class="w-40 md:w-28 xxl:w-64">
                            <input class="w-full bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="mix_co2">
                            @error('mix_co2') <span>{{ $message }}</span> @enderror
                        </div>

                        <div class="w-40 md:w-28 xxl:w-64">
                            <fieldset class="flex flex-col flex-nowrap gap-5">
                                <div>
                                    <input class="form-radio bg-gray-200 text-typeBlue-500 h-4 w-4" type="radio" wire:model="trade_type" name="trade_type" value="offer">
                                    <label class="pl-4">offer</label>
                                </div>

                                <div>
                                    <input class="form-radio bg-gray-200 text-typeBlue-500 h-4 w-4" type="radio" wire:model="trade_type" name="trade_type" value="request">
                                    <label class="pl-4">request</label>
                                </div>
                            </fieldset>
                            @error('trade_type') <span>{{ $message }}</span> @enderror
                        </div>

                        <div class="w-40 md:w-28 xxl:w-64 flex flex-row items-start">
                            <input class="w-2/4 bg-gray-200 text-gray-700 rounded px-2 py-1" type="text" placeholder="Amount" wire:model="expires_at">
                            <select class="w2/4 pt-1" name="expires_at_type" wire:model="expires_at_type">
                                <option value="day">Days</option>
                                <option value="week">Weeks</option>
                                <option value="month">Months</option>
                            </select>
                            @error('expires_at') <span>{{ $message }}</span> @enderror
                        </div>
                    </form>

                    <!--Overview-->
                    <p class="flex justify-center font-bold pb-12 sm:pb-4 text-xl xxl:text-2xl">Overview</p>

                    <div class="flex flex-row h-full sm:flex-col">
                        <div class="w-1/3 flex justify-center items-start">
                            <img class="object-scale-down w-4/6 h-4/6 sm:w-2/6 sm:h-2/6" src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Fi.stack.imgur.com%2FveUID.png&f=1&nofb=1" alt="placeholder">
                        </div>

                        <div class="w-2/3 h-full grid grid-cols-4 grid-rows-3 text-sm sm:text-xxs xxl:text-2xl">
                            <div class="flex flex-col gap-5">
                                <p>Hydrogen type:</p>

                                <div class="flex flex-row gap-0">
                                    @if ($hydrogen_type)
                                        <svg class="fill-current text-type{{ ucfirst($hydrogen_type) }}-500"
                                             height="24" width="50">
                                            <circle cx="10" cy="12" r="6"/>
                                        </svg>

                                        <p>{{ $hydrogen_type }}</p>
                                    @else
                                        <p>Not provided.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Units per hour:</p>
                                <p>{{ is_numeric($units_per_hour) ? number_format($units_per_hour, 0, '.', ' ') . ' units' : 'Not provided.' }}</p>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Duration (hours):</p>
                                <p>{{ $this->getDurationReadable() }}</p>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Mix CO2:</p>
                                <p>{{ is_numeric($mix_co2) ? $mix_co2 . '%' : 'Not provided.' }}</p>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Total volume:</p>
                                <p>{{ $this->getTotalVolumeReadable() }}</p>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Price per unit:</p>
                                <p>{{ is_numeric($price_per_unit) ? '€ ' . number_format($price_per_unit, 0, '.', ' ') : 'Not provided.' }}</p>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Trade type:</p>
                                <p>{{ $trade_type ? $trade_type : 'Not provided.' }}</p>
                            </div>

                            <div class="flex flex-col gap-5">
                                <p>Expires at:</p>
                                <p>{{ $this->getExpiresAtReadable() }}</p>
                            </div>

                            <div class="col-start-2 col-span-2">
                                <p>Total value contract:</p>
                                <p>{{ $this->getTotalPriceReadable() }}</p>
                            </div>
                        </div>
                    </div>

                    <!--Footer-->
                    <div class="flex justify-center gap-10 pt-2">
                        <button
                            class="bg-butOrange hover:bg-orange-600 border-2 border-butOrange hover:border-orange-600 text-white hover:text-white text-xs xxl:text-2xl py-1 px-8 xxl:py-2 xxl:px-10 rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                            wire:click="createListing">
                            Place
                        </button>
                        <button
                            class="modal-close bg-white border-2 border-butOrange hover:bg-gray-400 hover:border-gray-400 text-butOrange hover:text-white text-xs xxl:text-2xl py-1 px-6 xxl:py-2 xxl:px-8  rounded-lg focus:outline-none focus:shadow-outline 2 transition duration-200 ease-in-out"
                            wire:click="toggleModal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
