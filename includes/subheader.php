<!-- Include Flowbite CSS & JS in your <head> and before closing </body> -->

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="fixed top-16 w-full bg-[#FBFFE4] shadow border-b border-blue-300 z-30 px-2 py-2">
    <div class="flex items-center gap-10">

        <!-- All Books Dropdown -->
        <div class="relative">
            <button id="dropdownButton" data-dropdown-toggle="dropdownMenu"
                class="text-black w-[24vh] font-semibold px-6 py-2 flex items-center gap-2 hover:text-green-700 transition">
                All Books
                <svg class="w-4 h-4 transform transition-transform" id="dropdownIcon" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div id="dropdownMenu"
                class="z-50 hidden absolute left-0 m-4 w-[40vh] h-[75vh] overflow-y-auto no-scrollbar rounded-lg bg-white border border-gray-200 shadow-lg">
                <ul class="py-2 text-base text-gray-700 divide-y divide-gray-100">
                    <?php
                    $catcalling = $connect->query("SELECT * FROM category");
                    while ($cat = $catcalling->fetch_array()):
                    ?>
                        <a href="filter.php?filter=<?= $cat['cat_title']; ?>" class="block px-4 py-2 hover:bg-gray-100 transition-all">
                            <?= $cat['cat_title']; ?>
                        </a>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <!-- Horizontal Scroll Categories -->
        <div class="relative max-w-full">
            <div class="overflow-x-auto whitespace-nowrap no-scrollbar max-w-full" id="categoryScroll">
                <div class="flex space-x-4">
                    <?php
                    $callingused = $connect->query("SELECT * FROM books WHERE version = 'old'");

                    if ($callingused && $used = $callingused->fetch_array()) {
                    ?>
                        <a href="filter.php?filter=<?= htmlspecialchars($used['version']); ?>"
                            class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">
                            Used Book
                        </a>
                    <?php
                    }
                    ?>
 
                    <a href="filter.php?filter=49 Store"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">49 Store</a>

                    <a href="filter.php?filter=99 Store"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">99 Store</a>

                    <a href="filter.php?filter=149"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">149</a>

                    <a href="filter.php?filter=Pre Booking"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">Pre Booking</a>

                    <a href="filter.php?filter=Childreen"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">Childreen</a>

                    <a href="filter.php?filter=Text Book"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">Text Book</a>

                    <a href="filter.php?filter=Harry Potter Store"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">Harry Potter Store</a>

                    <a href="filter.php?filter=Manga Store"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">Manga Store</a>

                    <a href="filter.php?filter=Hindi Book"
                        class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700 hover:text-green-800 hover:underline transition">Hindi Book</a>
                </div>
            </div>
        </div>

    </div>
</div>