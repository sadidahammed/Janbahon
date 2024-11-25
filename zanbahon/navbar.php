<nav>
    <div class="">
        <div class="navbar bg-[#178783]">
            <div class="navbar md:flex hidden max-w-screen-xl mx-auto">
                <div class="navbar-start">
                    <div class="dropdown">
                        <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h8m-8 6h16" />
                            </svg>
                        </div>
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                            <li>Home</li>
                            <li>Services</li>
                            <li>History</li>
                            <li>Offers</li>
                            <li>Modes</li>
                        </ul>
                    </div>
                    <div>
                        <img src="image/zanbahon_no color_no_bg 1.png" alt="Zanbahon Logo" class="w-40">
                    </div>
                </div>
                <div class="navbar-center hidden lg:flex">
                    <ul class="menu menu-horizontal px-1 space-x-10 font-bold text-white">
                        <li>Home</li>
                        <li>Services</li>
                        <li>History</li>
                        <li>Offers</li>
                        <li>Modes</li>
                    </ul>
                </div>

                <div class="navbar-end space-x-5 ">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full">
                                <img alt="Tailwind CSS Navbar component"
                                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                            <li><a class="justify-between"> Profile <span class="badge">New</span></a></li>
                            <li><a>Settings</a></li>
                            <li><a>Logout</a></li>
                        </ul>
                    </div>
                    <a class="btn">Login</a>
                </div>
            </div>
            <div class="">
                <div class="flex items-center space-x-3 md:hidden ml-5">
                    <a href=""><i class="fa-solid fa-arrow-left text-white"></i></a>
                    <p class="text-white font-semibold">Emergency Service</p>
                </div>
            </div>
        </div>
    </div>
    <div class="fixed bottom-0 w-full bg-pantone p-3 flex justify-around text-white md:hidden bg-[#178783] z-50">
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-th-large text-lg"></i>
            <p class="text-xs">Services</p>
        </div>
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-clock text-lg"></i>
            <p class="text-xs">History</p>
        </div>
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-home text-lg"></i>
            <p class="text-xs">Home</p>
        </div>
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-percent text-lg"></i>
            <p class="text-xs">Offers</p>
        </div>
        <div class="flex flex-col items-center space-y-1">
            <i class="fa-solid fa-layer-group text-lg"></i>
            <p class="text-xs">Modes</p>
        </div>
    </div>
</nav>