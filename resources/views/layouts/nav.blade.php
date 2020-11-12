<header class="">

    <div class="h-screen" id="menu">


    <div class="companyName grid justify-items-center py-16 px-0 text-white text-2xl font-bold ">HydrogenActive</div>
        <nav>
            <ul class="text-white text-opacity-50 font-bold">
                <li><a class="grid  py-8 px-20  {{ Request::is('/') ? 'text-white' : '' }}" href="/">Dashboard</a></li>
                <li><a class="grid  py-8 px-20  {{ Request::is('market') ? 'text-white' : '' }}" href="/market">Marketplace</a></li>
                <li><a class="grid  py-8 px-20  {{ Request::is('company/') ? 'bg-indigo-100' : '' }}" href="/">Company</a></li>
                <li><a class="grid  py-8 px-20  {{ Request::is('company/overview') ? 'bg-indigo-100' : '' }}" href="/">Company</a></li>
            </ul>
        </nav>
        
        <!-- <a href="#" class="lg:ml-4 flex items-center justify-start lg:mb-0 mb-4 pointer-cursor">
            <img class="rounded-full w-10 h-10 border-2 border-transparent hover:border-indigo-400" src="https://pbs.twimg.com/profile_images/1128143121475342337/e8tkhRaz_normal.jpg" alt="Andy Leverenz">
        </a> -->

    </div>

</header>

