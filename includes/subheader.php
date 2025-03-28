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
        .main-links {
            display: none !important;
        }

        .category-scroll {
            margin-left: 0;
            gap: 0.5rem;
            padding: 0.25rem 0;
        }

        .category-scroll a {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.75rem !important;
            border-radius: 9999px !important;
        }
    }
</style>

<div class="fixed top-16 w-full bg-white shadow z-30 px-2 py-3">
    <div class="flex justify-center gap-4 items-center">
        <!-- Main links (hidden on mobile) -->
        <div class="main-links flex gap-4">
            <a href="index.php" class="py-3 px-6 bg-[#B3D8A8] text-gray-700 font-semibold rounded-full text-xs">
                Home
            </a>
            <a href="filter.php?hide" class="py-3 px-6 bg-[#B3D8A8] text-gray-700 font-semibold rounded-full text-xs">
                All
            </a>
        </div>

        <!-- Categories scroll (mobile-optimized) -->
        <div class="overflow-x-auto whitespace-nowrap scrollbar-hide flex gap-2 sm:gap-5 ml-0 sm:ml-4 category-scroll">
            <?php
            $catcalling = $connect->query("SELECT * FROM category");
            while ($cat = $catcalling->fetch_array()):
                $isActive = isset($_GET['filter']) && $_GET['filter'] === $cat['cat_title'];
                $bgClass = $isActive ? 'bg-blue-300' : 'bg-gray-100 hover:bg-gray-200';
            ?>
                <a href="filter.php?filter=<?= urlencode($cat['cat_title']); ?>"
                    class="py-2 px-4 sm:py-3 sm:px-6 <?= $bgClass ?> text-gray-700 font-semibold rounded-full text-md sm:text-sm hover:scale-105 transition-transform">
                    <?= htmlspecialchars($cat['cat_title']); ?>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
</div>