<div class="fixed top-16 w-full bg-[#FBFFE4] shadow border-b border-blue-300 z-50 px-6 py-2">
    <div class="flex items-center justify-between">

        <!-- Dropdown -->
        <div class="relative">
            <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown" class="text-black ml-4 font-semibold text-lg px-4 py-2 flex items-center gap-2">
                All Books
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="multi-dropdown" class="hidden absolute ml-6 bg-white border border-gray-200 rounded-md shadow-xl w-60 z-60">
                <ul class="py-2 text-xl text-gray-700">
                    <?php
                    $catcalling = $connect->query("SELECT * FROM category");
                    while ($cat = $catcalling->fetch_array()):
                    ?>
                        <a href="#">
                            <a href="#" class="block px-4 py-2 hover:bg-gray-100"><?= $cat['cat_title']; ?></a>
                        </a>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

        <!-- Scrollable Categories -->
        <div class="overflow-x-auto whitespace-nowrap ml-4">
            <div class="flex space-x-4">
                <?php
                $categoryFetch = $connect->query("SELECT * FROM category");
                while ($cat = $categoryFetch->fetch_assoc()):
                ?>
                    <a href="#" class="border-l border-[#105242] pl-4 pr-2 font-semibold text-gray-700">
                        <?= htmlspecialchars($cat['cat_title']); ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</div>