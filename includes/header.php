<?php
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user['user_id'] ?? null;
$userEmail = $user['email'] ?? null;
?>

<!-- Mobile Menu Toggle -->
<button id="mobile-menu-toggle" class="md:hidden fixed top-3 right-3 z-50 p-2 rounded-md bg-[#3D8D7A] text-[#FBFFE4]">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
</button>

<!-- Main Navigation Bar -->
<div class="flex flex-col md:flex-row fixed w-full z-40 top-0 bg-[#3D8D7A] px-4 py-2 md:px-[5%] md:py-3">
    <!-- Top Row (Mobile) -->
    <div class="flex justify-between items-center w-full md:w-auto">
        <!-- Logo -->
        <a href="index.php" class="text-[#FBFFE4] font-bold text-xl md:text-2xl tracking-wide">
            <img src="assets/images/Screenshot 2025-03-24 135151-Photoroom.png" alt="Logo" 
                 class="h-8 md:h-10 w-auto object-contain">
        </a>

        <!-- Mobile Icons -->
        <div class="flex items-center space-x-4 md:hidden">
            <!-- Mobile Search Toggle -->
            <button id="mobile-search-toggle" class="p-1 text-[#FBFFE4]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
            
            <!-- User Icon (Mobile) -->
            <?php if (isset($_SESSION['user'])): ?>
                <button id="mobile-user-toggle" class="p-1">
                    <img class="w-8 h-8 rounded-full border border-[#FBFFE4]"
                         src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" 
                         alt="User profile">
                </button>
            <?php else: ?>
                <a href="login.php" class="p-1 text-[#FBFFE4]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Mobile Search (Hidden by default) -->
    <form id="mobile-search" action="filter.php" method="get" 
          class="hidden md:hidden w-full mt-2 border rounded">
        <div class="flex">
            <input type="search" name="search_book" placeholder="Search by ISBN or name..."
                   class="p-2 bg-white rounded-l w-full text-black focus:outline-none">
            <button type="submit" name="search"
                    class="bg-[#B3D8A8] font-semibold rounded-r p-2 text-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Desktop Search (Hidden on mobile) -->
    <form action="filter.php" method="get" 
          class="hidden md:flex border rounded mx-4 w-full max-w-xl">
        <input type="search" name="search_book" placeholder="Search by ISBN or name..."
               class="p-2 bg-white rounded-l w-full text-black focus:outline-none">
        <button type="submit" name="search"
                class="bg-[#B3D8A8] font-semibold rounded-r p-2 text-slate-800 hover:bg-[#9bc58d] transition">
            Search
        </button>
    </form>

    <!-- Navigation Icons -->
    <div class="hidden md:flex items-center space-x-4">
        <!-- Wishlist -->
        <a href="wishlist.php" class="relative p-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
            <?php if(isset($userId)): 
                $countWishlistQuery = $connect->query("select * from wishlist where user_id='$userId'");
                $countWishlist = $countWishlistQuery->num_rows;
                if ($countWishlist > 0): ?>
                    <div class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border border-white rounded-full">
                        <?= $countWishlist; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </a>

        <!-- Cart -->
        <a href="cart.php" class="relative p-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
            </svg>
            <?php if(isset($userEmail)): 
                $countcartQuery = $connect->query("select * from cart where email='$userEmail' and direct_buy=0");
                $countcart = $countcartQuery->num_rows;
                if ($countcart > 0): ?>
                    <div class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border border-white rounded-full">
                        <?= $countcart; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </a>

        <!-- Chat -->
        <a href="chatboard.php" class="relative p-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded-full transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
            </svg>
            <div class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border border-white rounded-full">
                2
            </div>
        </a>

        <!-- Sell Button -->
        <a href="sell/sell2.php" class="border p-2 rounded-full text-[#FBFFE4] hover:bg-[#4a9c87] transition whitespace-nowrap text-sm">
            Sell Used Book
        </a>

        <!-- User Dropdown -->
        <?php if (isset($_SESSION['user'])): ?>
            <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                class="flex items-center text-sm font-medium text-[#FBFFE4] rounded-full border p-1 hover:bg-[#4a9c87] transition"
                type="button">
                <img class="w-8 h-8 rounded-full"
                     src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" 
                     alt="User profile">
                <span class="mx-2"><?= $user['name']; ?></span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                </svg>
            </button>

            <div id="dropdownAvatarName"
                class="hidden absolute right-5 mt-2 bg-[#B3D8A8] divide-y divide-gray-100 rounded-lg shadow w-44 z-50">
                <div class="px-4 py-3 text-sm text-gray-900">
                    <div class="truncate"><?= $user['email']; ?></div>
                </div>
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                    </li>
                    <li>
                        <a href="contact.php" class="block px-4 py-2 hover:bg-gray-100">Help</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                    </li>
                </ul>
                <div class="py-2">
                    <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php" class="text-[#FBFFE4] hover:underline px-3 py-1">Login</a>
        <?php endif; ?>
    </div>
</div>

<!-- Mobile Menu (Hidden by default) -->
<div id="mobile-menu" class="hidden fixed inset-0 z-30 bg-[#3D8D7A] pt-16 px-4 overflow-y-auto">
    <div class="flex flex-col space-y-4">
        <?php if (isset($_SESSION['user'])): ?>
            <div class="flex items-center space-x-3 p-3 border-b border-[#4a9c87]">
                <img class="w-10 h-10 rounded-full"
                     src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" 
                     alt="User profile">
                <div>
                    <div class="font-medium text-[#FBFFE4]"><?= $user['name']; ?></div>
                    <div class="text-sm text-[#e8f5d0]"><?= $user['email']; ?></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Mobile Navigation Links -->
        <a href="index.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
        </a>

        <a href="wishlist.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
            <span>Wishlist</span>
            <?php if(isset($userId) && $countWishlist > 0): ?>
                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    <?= $countWishlist; ?>
                </span>
            <?php endif; ?>
        </a>

        <a href="cart.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
            </svg>
            <span>Cart</span>
            <?php if(isset($userEmail) && $countcart > 0): ?>
                <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                    <?= $countcart; ?>
                </span>
            <?php endif; ?>
        </a>

        <a href="chatboard.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
            </svg>
            <span>Chat</span>
            <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">2</span>
        </a>

        <a href="sell/sell2.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Sell Used Book</span>
        </a>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="profile.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Profile</span>
            </a>

            <a href="logout.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded border-t border-[#4a9c87] mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                <span>Logout</span>
            </a>
        <?php else: ?>
            <a href="login.php" class="flex items-center space-x-3 text-[#FBFFE4] hover:bg-[#4a9c87] p-3 rounded border-t border-[#4a9c87] mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Login</span>
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Mobile User Dropdown (Hidden by default) -->
<div id="mobile-user-dropdown" class="hidden fixed right-3 top-14 z-50 bg-[#B3D8A8] rounded-lg shadow w-48">
    <div class="px-4 py-3 text-sm text-gray-900 border-b border-[#3D8D7A]">
        <div class="truncate"><?= $user['email'] ?? ''; ?></div>
    </div>
    <ul class="py-2 text-sm text-gray-700">
        <li>
            <a href="profile.php" class="block px-4 py-2 hover:bg-[#3D8D7A] hover:text-[#FBFFE4]">Profile</a>
        </li>
        <li>
            <a href="contact.php" class="block px-4 py-2 hover:bg-[#3D8D7A] hover:text-[#FBFFE4]">Help</a>
        </li>
    </ul>
    <div class="py-2 border-t border-[#3D8D7A]">
        <a href="logout.php" class="block px-4 py-2 text-sm hover:bg-[#3D8D7A] hover:text-[#FBFFE4]">Logout</a>
    </div>
</div>

<script>
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    
    mobileMenuToggle.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'auto' : 'hidden';
    });

    // Mobile search toggle
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileSearch = document.getElementById('mobile-search');
    
    mobileSearchToggle.addEventListener('click', () => {
        mobileSearch.classList.toggle('hidden');
        mobileMenu.classList.add('hidden');
        mobileUserDropdown.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });

    // Mobile user dropdown toggle
    const mobileUserToggle = document.getElementById('mobile-user-toggle');
    const mobileUserDropdown = document.getElementById('mobile-user-dropdown');
    
    if(mobileUserToggle) {
        mobileUserToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileUserDropdown.classList.toggle('hidden');
            mobileMenu.classList.add('hidden');
            mobileSearch.classList.add('hidden');
        });
    }

    // Close all dropdowns when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('#mobile-user-toggle') && !e.target.closest('#mobile-user-dropdown')) {
            mobileUserDropdown.classList.add('hidden');
        }
        if (!e.target.closest('#mobile-menu-toggle') && !e.target.closest('#mobile-menu')) {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        if (!e.target.closest('#mobile-search-toggle') && !e.target.closest('#mobile-search')) {
            mobileSearch.classList.add('hidden');
        }
        if (!e.target.closest('#dropdownAvatarNameButton') && !e.target.closest('#dropdownAvatarName')) {
            document.getElementById('dropdownAvatarName').classList.add('hidden');
        }
    });

    // Desktop dropdown toggle
    const dropdownButton = document.getElementById('dropdownAvatarNameButton');
    if(dropdownButton) {
        dropdownButton.addEventListener('click', () => {
            document.getElementById('dropdownAvatarName').classList.toggle('hidden');
        });
    }
</script>