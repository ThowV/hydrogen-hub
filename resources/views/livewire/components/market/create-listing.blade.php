<div class="z-40">
    @if($isOpen)
        <div class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center">
            <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
                <!-- Add margin if you want to see some of the overlay behind the modal-->
                <div class="modal-content py-4 text-left px-6">
                    <!--Title-->
                    <div class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">Create listing</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                            <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <form wire:submit.prevent="submit">
                        <div>
                            <label style="font-weight: bold">Trade type</label>

                            <fieldset>
                                <input type="radio" wire:model="trade_type" name="trade_type" value="offer">
                                <label>offer</label>

                                <input type="radio" wire:model="trade_type" name="trade_type" value="request">
                                <label>request</label>
                            </fieldset>

                            @error('trade_type') <span>{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label style="font-weight: bold">Hydrogen type</label>

                            <fieldset>
                                <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="green">
                                <label>green</label>

                                <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="blue">
                                <label>blue</label>

                                <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="grey">
                                <label>grey</label>

                                <input type="radio" wire:model="hydrogen_type" name="hydrogen_type" value="mix">
                                <label>mix</label>
                            </fieldset>

                            @error('hydrogen_type') <span>{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label style="font-weight: bold">Units per hour</label>
                            <input type="text" placeholder="Enter amount" wire:model="units_per_hour">
                            @error('units_per_hour') <span>{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label style="font-weight: bold">Duration</label>
                            <input type="text" placeholder="Enter amount" wire:model="duration">

                            <select name="duration_type" wire:model="duration_type">
                                <option value="day">Days</option>
                                <option value="week">Weeks</option>
                                <option value="month">Months</option>
                            </select>

                            @error('duration') <span>{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label style="font-weight: bold">Price per unit</label>
                            <input type="text" placeholder="Enter amount" wire:model="price_per_unit">
                            @error('price_per_unit') <span>{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label style="font-weight: bold">Mix CO2</label>
                            <input type="text" placeholder="Enter amount" wire:model="mix_co2">
                            @error('mix_co2') <span>{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label style="font-weight: bold">Expires in</label>
                            <input type="text" placeholder="Enter amount" wire:model="expires_at">

                            <select name="expires_at_type" wire:model="expires_at_type">
                                <option value="day">Days</option>
                                <option value="week">Weeks</option>
                                <option value="month">Months</option>
                            </select>

                            @error('expires_at') <span>{{ $message }}</span> @enderror
                        </div>
                    </form>

                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <button
                            class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2"
                            wire:click="createListing"
                        >
                            Place
                        </button>
                        <button wire:click="toggleModal" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
