<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-6 sm:col-start-3 row-start-1 col-span-2 sm:col-span-4 mx-10 xxl:mx-20 my-24 row-span-3 sm:row-span-3 bg-white rounded-lg shadow-lg z-50">
                <div class="modal-content flex flex-col w-full h-full p-6 sm:p-4 xxl:p-16 text-left">
                    <!--Title-->
                    <div class="flex justify-between flex-none items-center pb-5 sm:pb-2">
                        <p class="text-sm xl:text-base xxl:text-base font-bold">Choose charts to display</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer h-full z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <fieldset class="flex justify-center items-center flex-auto gap-5 xl:text-lg xxl:text-2xl">
                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeGreen-500 cursor-pointer" id="green"
                                   value="green" wire:model="interests">
                            <label for="green">green</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeBlue-500 cursor-pointer" id="blue"
                                   value="blue" wire:model="interests">
                            <label for="blue">blue</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeGrey-500 cursor-pointer" id="grey"
                                   value="grey" wire:model="interests">
                            <label for="grey">grey</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox text-typeMix-500 cursor-pointer" id="mix"
                                   value="mix" wire:model="interests">
                            <label for="mix">mix</label>
                        </div>

                        <div class="">
                            <input type="checkbox" class="form-checkbox cursor-pointer" id="combined"
                                   value="combined" wire:model="interests" style="color: #FCA357">
                            <label for="combined">combined</label>
                        </div>
                    </fieldset>

                    <!--Footer-->
                    <div class="flex justify-center flex-none items-end gap-10 pt-2">
                        <button
                            class="bg-blue-100 border-2 border-hovBlue hover:bg-hovBlue text-hovBlue hover:text-white text-xs sm:text-xxs xxl:text-2xl py-1 px-6 rounded-lg focus:outline-none transition duration-200 ease-in-out"
                            wire:click="save">
                            Save
                        </button>
                        <button
                            class="modal-close text-gray-600 hover:text-gray-900 transition duration-300 ease-in-out"
                            wire:click="toggleModal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
