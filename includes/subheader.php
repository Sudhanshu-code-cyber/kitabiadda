<div class="m-4 flex  px-6  relative items-center">

    <!-- Dropdown Section -->
    <div class="flex items-center w-full">
        <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown" class="text-black w-full font-medium text-lg font-semibold rounded-md px-6 py-3 flex justify-between items-center whitespace-nowrap" type="button">
            All Books
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
            </svg>

        </button>

        <!-- Dropdown menu -->
        <div id="multi-dropdown" class="z-10 hidden bg-white border border-gray-200 rounded-lg shadow-md w-56 mt-2 absolute">
            <ul class="py-3 text-base text-gray-700">
                <li>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-100">Fiction</a>
                </li>
                <li>
                    <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown" data-dropdown-placement="right-start" type="button" class="flex items-center justify-between w-full px-4 py-3 hover:bg-gray-100">
                        Categories
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                    </button>
                    <div id="doubleDropdown" class="z-10 hidden bg-white border border-gray-200 rounded-lg shadow-md w-56 mt-2 absolute">
                        <ul class="py-3 text-base text-gray-700">
                            <li>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">Overview</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">My Downloads</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">Billing</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-3 hover:bg-gray-100">Rewards</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-100">Earnings</a>
                </li>
                <li>
                    <a href="#" class="block px-4 py-3 hover:bg-gray-100">Sign Out</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Divider and Category Section -->
    <div class="flex space-x-4 pl-4">
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Science</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Technology</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Engineering</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Mathematics</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Arts</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Mathematics</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Science</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Technology</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Engineering</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Mathematics</h2>
        <h2 class="border-l border-[#105242] px-4 font-semibold text-gray-700">Arts</h2>
    </div>
</div>