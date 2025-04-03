<style>
    /* Hide scrollbar */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    /* Mobile styles */
    @media (max-width: 768px) {
        .category-scroll {
            margin-left: 0;
            gap: 0.5rem;
            padding: 0.25rem 0;
        }

        .category-scroll a,
        .mobile-main-links a {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.75rem !important;
            border-radius: 9999px !important;
        }

        /* Show mobile links and adjust layout */
        .mobile-main-links {
            display: flex !important;
            gap: 0.5rem;
        }

        /* Hide desktop main links on mobile */
        .desktop-main-links {
            display: none !important;
        }
    }

    /* Desktop styles */
    @media (min-width: 769px) {
        .mobile-main-links {
            display: none !important;
        }

        .desktop-main-links {
            display: flex !important;
            
            gap: 1rem;
        }
    }
</style>

<div class="fixed w-full bg-white shadow z-30 top-0 mt-16 px-4 py-2  ">
    <div class="flex justify-center items-center gap-4 ">
        <!-- Main links (desktop version) -->
        <div class="desktop-main-links">
            <a href="index.php" class="py-2 px-4 bg-[#B3D8A8] text-gray-700 font-semibold rounded-full text-xs">
                Home
            </a>
            <a href="filter.php?hide" class="py-2 px-4 bg-[#B3D8A8] text-gray-700 font-semibold rounded-full text-xs">
                All
            </a>
        </div>

        <!-- Main links (mobile version) -->
        <div class="mobile-main-links">
            <a href="index.php" class="bg-[#B3D8A8] text-gray-700 font-semibold">
                Home
            </a>
            <a href="filter.php?hide" class="bg-[#B3D8A8] text-gray-700 font-semibold">
                All
            </a>
        </div>

        <!-- Categories scroll -->
        <div class="overflow-x-auto whitespace-nowrap scrollbar-hide flex gap-2 sm:gap-5 ml-0 sm:ml-4 category-scroll">
            <?php
            $catcalling = $connect->query("SELECT * FROM category");
            while ($cat = $catcalling->fetch_array()):
                $isActive = isset($_GET['filter']) && $_GET['filter'] === $cat['cat_title'];
                $bgClass = $isActive ? 'bg-blue-300' : 'bg-gray-100 hover:bg-gray-200';
            ?>
                <a href="filter.php?filter=<?= urlencode($cat['cat_title']); ?>"
                    class="py-1 px-4 sm:py-1.5 sm:px-6 <?= $bgClass ?> text-gray-700 font-semibold rounded-full text-md sm:text-sm hover:scale-105 transition-transform">
                    <?= htmlspecialchars($cat['cat_title']); ?>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</div>