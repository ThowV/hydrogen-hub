<aside class="flex h-screen sticky top-0 bg-nav grid grid-rows-6">

    <div
        class="grid justify-items-center items-center text-white font-black sm:text-sm md:text-xl lg:text-xl xl:text-3xl xxl:text-4xl">
        HydroActive
    </div>

    <nav
        class="row-start-2 grid justify-items-center items-center sm:text-sm md:text-sm lg:text-sm xl:text-xl xxl:text-3xl">
        <ul class="text-white font-bold">
            <li class="grid grid-cols-8 items-center sm:px-8 md:px-8 lg:px-12 xl:px-16 xxl:px-16 sm:pb-8 md:pb-8 lg:pb-10 xl:pb-12 xxl:pb-20 hover:opacity-100 duration-300 cursor-pointer {{ Request::is('/') ? 'opacity-100' : 'opacity-25' }}"
                href="/">
                <svg class="xxl:mx-10 sm:w-3 md:w-4 lg:w-4 xl:w-5" xmlns="http://www.w3.org/2000/svg" width="25"
                    height="25" viewBox="0 0 25 25">
                    <path id="Icon_material-dashboard" data-name="Icon material-dashboard"
                        d="M4.5,18.389H15.611V4.5H4.5ZM4.5,29.5H15.611V21.167H4.5Zm13.889,0H29.5V15.611H18.389Zm0-25v8.333H29.5V4.5Z"
                        transform="translate(-4.5 -4.5)" fill="#fff" opacity="1"/>
                </svg>
                <a class="grid col-start-4" href="{{route('home')}}">Dashboard</a>
            </li>

            <li class="grid grid-cols-8 items-center sm:px-8 md:px-8 lg:px-12 xl:px-16 xxl:px-16 sm:pb-8 md:pb-8 lg:pb-10 xl:pb-12 xxl:pb-20 hover:opacity-100 duration-300 cursor-pointer {{ Route::is('market') ? 'opacity-100' : 'opacity-25' }}"
                href="/market">
                <svg class="xxl:mx-10 sm:w-3 sm:h-3 md:w-4 lg:w-4 xl:w-5" xmlns="http://www.w3.org/2000/svg"
                     width="25" height="25" viewBox="0 0 25 25" href="/market">
                    <path id="Icon_metro-shop" data-name="Icon metro-shop"
                          d="M11.228,12.83l1.1-8.2H6.613L4.226,11.659a2.747,2.747,0,0,0-.112.781,3.37,3.37,0,0,0,3.571,3.125,3.446,3.446,0,0,0,3.544-2.734Zm5.385,2.734a3.371,3.371,0,0,0,3.571-3.125c0-.064,0-.128-.007-.189L19.47,4.627H13.756l-.708,7.617c0,.064-.006.128-.006.2a3.371,3.371,0,0,0,3.571,3.125ZM23.558,17.2v6.178H9.669V17.209a5.266,5.266,0,0,1-1.985.388,5.107,5.107,0,0,1-.793-.077v9.92a2.082,2.082,0,0,0,1.942,2.188H24.391a2.084,2.084,0,0,0,1.944-2.187V17.521a5.321,5.321,0,0,1-.793.077A5.2,5.2,0,0,1,23.558,17.2ZM29,11.659l-2.39-7.031H20.9L22,12.818a3.44,3.44,0,0,0,3.546,2.747,3.371,3.371,0,0,0,3.571-3.125A2.8,2.8,0,0,0,29,11.659Z"
                          transform="translate(-4.113 -4.627)" fill="#fff" opacity="1"/>
                </svg>
                <a class="col-start-4" href="{{route('market')}}">Marketplace</a>
            </li>

            <li class="grid grid-cols-8 items-center sm:px-8 md:px-8 lg:px-12 xl:px-16 xxl:px-16 hover:opacity-100 transaction duration-300 cursor-pointer {{ Route::is('company.*') ? 'opacity-100' : 'opacity-25' }}">
                <svg class="xxl:mx-11 sm:w-3 sm:h-3 md:w-4 lg:w-4 xl:w-5 " xmlns="http://www.w3.org/2000/svg"
                    width="19.495" height="25.344" viewBox="0 0 19.495 25.344">
                    <g id="Icon_ionic-ios-business" data-name="Icon ionic-ios-business" opacity="1">
                        <path id="Path_6" data-name="Path 6"
                            d="M10.1,5.287H23.5a1.1,1.1,0,0,0,1.1-1.1h0a1.1,1.1,0,0,0-1.1-1.1H10.1A1.1,1.1,0,0,0,9,4.19H9A1.1,1.1,0,0,0,10.1,5.287Z"
                            transform="translate(-7.05 -3.094)" fill="#fff"/>
                        <path id="Path_7" data-name="Path 7"
                            d="M25.149,7.031H7.847a1.1,1.1,0,0,0-.122,2.193V27.5a1.466,1.466,0,0,0,1.462,1.462h5.361a.489.489,0,0,0,.487-.487V26.039a.489.489,0,0,1,.487-.487h1.95a.489.489,0,0,1,.487.487v2.437a.489.489,0,0,0,.487.487h5.361A1.466,1.466,0,0,0,25.27,27.5V9.224a1.1,1.1,0,0,0-.122-2.193ZM12.6,23.115a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487V22.14a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm4.874,11.7a.489.489,0,0,1-.487.487H16.01a.489.489,0,0,1-.487-.487V22.14a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487H16.01a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487H16.01a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487H16.01a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm4.874,11.7a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487V22.14a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Zm0-3.9a.489.489,0,0,1-.487.487h-.975a.489.489,0,0,1-.487-.487v-.975a.489.489,0,0,1,.487-.487h.975a.489.489,0,0,1,.487.487Z"
                            transform="translate(-6.75 -3.62)" fill="#fff"/>
                    </g>
                </svg>
                <a class="col-start-4" href="{{route('company.portfolio')}}">Company</a>

                <ul class="flex flex-col items-start w-3/4 col-start-4 sm:pb-8 md:pb-8 lg:pb-10 xl:pb-12 xxl:pb-20">
                    <li class="grid items-center sm:text-sm md:text-xs lg:text-xs xl:text-base xxl:text-xl">
                        <a class="col-start-4 hover:opacity-100 transaction duration-300 sm:pt-2 md:pt-3 lg:pt-4 xl:pt-4 xxl:pt-6 {{ !Route::is('company.*') ? 'opacity-100' : (Route::is('company.portfolio') ? 'opacity-100' : 'opacity-25') }}"
                           href="{{route('company.portfolio')}}">●&nbsp;&nbsp;&nbsp;Portfolio</a></li>
                    </li>
                    <li class="grid items-center sm:text-sm md:text-xs lg:text-xs xl:text-base xxl:text-xl">
                        <a class="hover:opacity-100 transaction duration-300 sm:pt-2 md:pt-3 lg:pt-4 xl:pt-4 xxl:pt-6 {{ !Route::is('company.*') ? 'opacity-100' : (Route::is('company.overview') ? 'opacity-100' : 'opacity-25') }}"
                           href="{{route('company.overview')}}">●&nbsp;&nbsp;&nbsp;Overview</a></li>
                    </li>
                </ul>
            </li>

            @role('Super Admin')
            <li class="grid grid-cols-8 items-center sm:px-8 md:px-8 lg:px-12 xl:px-16  xxl:px-16 opacity-25 hover:opacity-100 duration-300 cursor-pointer {{ Request::is('admin') ? 'opacity-100' : '' }}"
            ">

            <svg class="xxl:mx-11 sm:w-3 sm:h-3 md:w-4 lg:w-4 xl:w-5" xmlns="http://www.w3.org/2000/svg" width="25"
                 height="25" viewBox="0 0 25 25">
                <path id="Icon_metro-wrench" data-name="Icon metro-wrench"
                      d="M27.056,21.9,15.812,12.258A7.035,7.035,0,0,0,7.56,2.23l4.062,4.062a1.567,1.567,0,0,1,0,2.21L9.144,10.979a1.567,1.567,0,0,1-2.21,0L2.872,6.917A7.033,7.033,0,0,0,12.9,15.17l9.638,11.244a1.428,1.428,0,0,0,2.122.081l2.478-2.478a1.428,1.428,0,0,0-.081-2.122Z"
                      transform="translate(-2.571 -1.928)" fill="#fff"/>
            </svg>

            <a class="col-start-4" href="{{route('admin')}}">Admin</a>

            </li>
            @endrole()

        </ul>
    </nav>


    <div class="row-start-6 text-white font-bold grid grid-cols-4 px-2 pb-10">

        <div class="w-full h-full grid items-end justify-items-center">
            <img class="rounded-full w-8 xl:w-10 xxl:w-12 border"
                 src="{{ auth()->user()->avatar }}"
                 alt="{{ auth()->user()->full_name }}">
        </div>

        <div class="w-full h-full grid content-end col-start-2 col-span-2">
            <a class="truncate sm:text-xxs md:text-xxs lg:text-xs xl:text-base xxl:text-xl ">{{ auth()->user()->full_name  }}</a>
            <a class="truncate opacity-50 sm:text-xxs md:text-xxs lg:text-xxs xl:text-xs xxl:text-lg">{{ auth()->user()->email  }}</a>
        </div>


        <div class="w-full h-full grid items-end justify-items-center cursor-pointer pb-2" id="settings-btn">
            <svg class="opacity-50 hover:opacity-100 duration-300 w-5 xl:w-6 xxl:w-8"
                 xmlns="http://www.w3.org/2000/svg" width="19.721" height="19.721" viewBox="0 0 19.721 19.721">
                <g id="Icon_ionic-md-settings" data-name="Icon ionic-md-settings" transform="translate(0)">
                    <path id="Icon_ionic-md-settings-2" data-name="Icon ionic-md-settings"
                          d="M20.724,14.222a6.167,6.167,0,0,0,.05-.986c0-.345-.05-.641-.05-.986l2.118-1.627a.453.453,0,0,0,.1-.641l-2.017-3.4a.491.491,0,0,0-.605-.2L17.8,7.368a7.339,7.339,0,0,0-1.714-.986l-.353-2.613a.54.54,0,0,0-.5-.394H11.193a.54.54,0,0,0-.5.394l-.4,2.613a8.539,8.539,0,0,0-1.715.986L6.049,6.382a.472.472,0,0,0-.605.2l-2.017,3.4a.6.6,0,0,0,.1.641L5.7,12.25c0,.345-.05.641-.05.986s.05.641.05.986L3.579,15.849a.453.453,0,0,0-.1.641l2.017,3.4a.491.491,0,0,0,.605.2L8.622,19.1a7.339,7.339,0,0,0,1.714.986l.4,2.613a.489.489,0,0,0,.5.394h4.034a.54.54,0,0,0,.5-.394l.4-2.613A8.534,8.534,0,0,0,17.9,19.1l2.521.986a.472.472,0,0,0,.605-.2l2.017-3.4a.6.6,0,0,0-.1-.641ZM13.21,16.687a3.452,3.452,0,1,1,3.53-3.451A3.469,3.469,0,0,1,13.21,16.687Z"
                          transform="translate(-3.375 -3.375)" fill="#fff" opacity="1"/>
                </g>
            </svg>
        </div>


    </div>

    <!-- Personal information section -->
    <div class="absolute bg-personal hidden row-start-5 w-full h-full rounded-t-xl text-white px-8 xxl:px-12 py-6"
         id="settings">

        <div class="flex flex-col w-full h-full">

            <div class="grid justify-items-end items-end">

                <svg class="col-start-2 row-start-1 w-4 xxl:w-12 opacity-50 hover:opacity-100 cursor-pointer"
                     xmlns="http://www.w3.org/2000/svg" width="22.429" height="22.429" viewBox="0 0 22.429 22.429"
                     id="close-settings">
                    <g id="Group_299" data-name="Group 299" transform="translate(317.808 -1627.379) rotate(90)">
                        <line id="Line_176" data-name="Line 176" y1="18.187" x2="18.187"
                              transform="translate(1629.5 297.5)" fill="none" stroke="#fff" stroke-linecap="round"
                              stroke-width="3"/>
                        <line id="Line_177" data-name="Line 177" x2="18.187" y2="18.187"
                              transform="translate(1629.5 297.5)" fill="none" stroke="#fff" stroke-linecap="round"
                              stroke-width="3"/>
                    </g>
                </svg>

            </div>

            <div class="flex justify-center py-6 sm:py-2 ">

                <img class="rounded-full w-12 lg:w-20 xl:w-24 xxl:w-32 border row-span-2"
                     src="{{auth()->user()->avatar}}"
                     alt="{{ auth()->user()->full_name }}">

            </div>


            <div>
                <p class="text-center font-bold sm:text-xxs md:text-xxs lg:text-xs xl:text-md xxl:text-xl">{{ auth()->user()->full_name  }}</p>

                <p class="text-center opacity-50 font-bold sm:text-xxs md:text-xxs lg:text-xxs xl:text-xs xxl:text-xl">{{ auth()->user()->email  }}</p>

            </div>


            <div class="grid justify-center items-end h-full">

                <a href="{{route('employees.edit', auth()->id())}}"
                   class="m-auto bg-personal border border-white text-white px-8 py-2 sm:px-4 rounded sm:text-xxs md:text-xxs lg:text-xxs xl:text-xs xxl:text:lg hover:bg-hovBlue hover:text-white transaction duration-300">
                    Personal settings
                </a>
            </div>

            <div class="grid justify-center items-end h-full">
                <a href="{{route('logout')}}"
                   class="m-auto bg-hovBlue text-white px-12 py-2 sm:px-6 rounded sm:text-xxs md:text-xxs lg:text-xxs xl:text-xs xxl:text:lg hover:bg-white hover:text-hovBlue transaction duration-300">
                    Log out
                </a>
            </div>

        </div>

    </div>

</aside>


