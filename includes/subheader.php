<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="fixed top-16 w-full bg-[#FBFFE4] shadow border-b border-blue-300 z-50 px-6 py-2">
    <div class="flex items-center justify-between ">

        <div class="relative group">
            <div class="">
                <button id="multiLevelDropdownButton"
                    class="text-black text-xl ml-10 font-semibold py-2 flex items-center gap-2">
                    All Books
                    <svg class="w-4 h-4 transition-transform transform group-hover:rotate-180" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>

            <div id="multi-dropdown"
                class="hidden group-hover:block absolute left-0 ml-6  mt-2 bg-white border border-gray-200 rounded-md shadow-xl w-[50vh] z-60 h-[75vh] overflow-y-auto no-scrollbar">
                <ul id="dropdownList" class="py-2 text-lg text-gray-700">
                    <?php
                    $catcalling = $connect->query("SELECT * FROM category");
                    while ($cat = $catcalling->fetch_array()):
                    ?>
                        <li class="px-4 py-2 hover:bg-gray-100 transition">
                            <a href="#" class="block"><?= $cat['cat_title']; ?></a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <div class="relative ml-4 max-w-[70vw]">
            <div
                class="overflow-x-auto whitespace-nowrap no-scrollbar max-w-[70vw] transition-all duration-300 ease-in-out"
                id="categoryScroll">
                <div class="flex space-x-4">
                    <?php
                    $categoryFetch = $connect->query("SELECT * FROM category");
                    while ($cat = $categoryFetch->fetch_assoc()):
                    ?>
                        <a href="#"
                            class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 transition">
                            <?= $cat['cat_title']; ?>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>

    </div>
</div>