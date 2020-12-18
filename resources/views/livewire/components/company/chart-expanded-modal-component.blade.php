<div class="z-40 w-full text-gray-700">
    @if($isOpen)
        <div class="modal fixed top-0 h-full w-full grid grid-cols-8 grid-rows-6">

            <div class="modal-overlay fixed w-full h-full fixed bg-gray-900 opacity-50" wire:click="toggleModal"></div>

            <div class="modal-container max-h-full max-w-full grid col-start-1 row-start-2 col-span-7 sm:col-span-6 mx-10 xxl:mx-20 row-span-4 bg-white rounded shadow-lg z-50">
                <div class="modal-content flex flex-col w-full h-full p-12 sm:p-4 xxl:p-16 text-left">
                    <!--Title-->
                    <div class="flex flex-none justify-between items-center pb-2">
                            <p class="text-lg font-bold">{{ ucfirst($chartType) }} hydrogen</p>
                        <div wire:click="toggleModal" class="modal-close cursor-pointer z-50">
                            <svg class="fill-current text-gray-600 hover:text-gray-900 transaction duration-300 w-8 h-8 xxl:w-12 xxl:h-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
                                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                            </svg>
                        </div>
                    </div>

                    <!--Body-->
                    <div>
                        <div>
                            Chart here
                        </div>
                        <div>
                            Information and running contracts here.
                        </div>
                    </div>


                    <!--Footer-->
                    <div class="flex flex-none justify-center gap-10 pt-2">
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

