<?php
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user['user_id'] ?? null;
$userEmail = $user['email'] ?? null;
?>

<!-- Premium Navigation Bar -->
<div class="fixed w-full z-50 top-0 bg-[#3D8D7A] shadow-lg">
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Desktop Navigation -->
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="index.php" class="text-[#FBFFE4] font-bold text-2xl tracking-tight">
                    <img src="assets/logo2.png" alt="Logo"
                        class="h-10 w-auto object-contain ">
                </a>
            </div>

            <div class="hidden md:flex xl:ml-7 items-center space-x-28">
                <!-- Search Bar -->
                <form action="filter.php" method="get" class="relative w-130">
                    <div
                        class="flex rounded-md shadow-sm ring-1 ring-[#B3D8A8] ring-opacity-50 focus-within:ring-2 focus-within:ring-[#FBFFE4] transition-all duration-200">
                        <input type="search" name="search_book" placeholder="Search by ISBN or name..."
                            class="block w-full pl-4 pr-12 py-2 bg-white rounded-l-md border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0">
                        <button type="submit" name="search"
                            class="inline-flex items-center px-4 py-2 bg-[#B3D8A8] text-gray-800 font-medium rounded-r-md hover:bg-[#9bc58d] transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Navigation Icons -->
                <div class="flex items-center space-x-6">
                    <!-- Wishlist -->
                    <a href="wishlist.php"
                        class="relative p-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded-full transition-all duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                        <?php if (isset($userId)):
                            $countWishlistQuery = $connect->query("select * from wishlist where user_id='$userId'");
                            $countWishlist = $countWishlistQuery->num_rows;
                            if ($countWishlist > 0): ?>
                                <div
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border border-white rounded-full transform group-hover:scale-110 transition-transform">
                                    <?= $countWishlist; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>

                    <!-- Cart -->
                    <a href="cart.php"
                        class="relative p-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded-full transition-all duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                        </svg>
                        <?php if (isset($userEmail)):
                            $countcartQuery = $connect->query("select * from cart where email='$userEmail' and direct_buy=0");
                            $countcart = $countcartQuery->num_rows;
                            if ($countcart > 0): ?>
                                <div
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border border-white rounded-full transform group-hover:scale-110 transition-transform">
                                    <?= $countcart; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>

                    <!-- Chat -->
                    <a href="chatboard.php"
                        class="relative p-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded-full transition-all duration-200 group">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="w-6 h-6 group-hover:scale-110 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
                        </svg>
                        <div
                            class="absolute -top-1 -right-1 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border border-white rounded-full transform group-hover:scale-110 transition-transform">
                            2
                        </div>
                    </a>

                    <!-- Sell Button -->
                    <a href="sell/sell2.php"
                        class="relative ml-4 px-6 py-2.5 rounded-full text-sm font-semibold text-[#FBFFE4] bg-gradient-to-br from-[#4a9c87] to-[#3D8D7A] shadow-md hover:shadow-lg hover:from-[#3D8D7A] hover:to-[#2a7d6a] border border-[#FBFFE4]/20 hover:border-[#FBFFE4]/40 transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-95 group overflow-hidden">

                        <span
                            class="absolute inset-0 bg-[#FBFFE4]/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>

                        <!-- Button content with subtle animation -->
                        <span class="relative flex items-center justify-center space-x-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 transition-transform duration-300 group-hover:rotate-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Sell Used Book</span>
                        </span>

                        <!-- Glow effect -->
                        <span
                            class="absolute inset-0 rounded-full pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-500"
                            style="box-shadow: 0 0 15px rgba(251, 255, 228, 0.3);"></span>
                    </a>

                    <!-- User Profile -->
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="relative ml-4">
                            <button id="user-menu-button" type="button"
                                class="flex items-center space-x-2 max-w-xs rounded-full focus:outline-none focus:ring-2 focus:ring-[#FBFFE4] group"
                                aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full border-2 border-[#FBFFE4] group-hover:border-[#B3D8A8] transition-colors"
                                    src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                                    alt="User profile">
                                <span
                                    class="text-[#FBFFE4] font-medium group-hover:text-[#B3D8A8] transition-colors"><?= $user['name']; ?></span>
                                <svg class="h-4 w-4 text-[#FBFFE4] group-hover:text-[#B3D8A8] transition-colors"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div id="user-dropdown"
                                class="hidden origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-[#B3D8A8] ring-1 ring-black ring-opacity-5 focus:outline-none transition-all duration-200 transform opacity-0 scale-95"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <div class="py-3 px-4 border-b border-[#3D8D7A]">
                                    <p class="text-sm font-medium text-gray-900"><?= $user['name']; ?></p>
                                    <p class="text-xs font-light text-gray-700 truncate"><?= $user['email']; ?></p>
                                </div>
                                <div class="py-1">
                                    <a href="profile.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#3D8D7A] hover:text-[#FBFFE4] transition-colors"
                                        role="menuitem">Profile</a>
                                    <a href="contact.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#3D8D7A] hover:text-[#FBFFE4] transition-colors"
                                        role="menuitem">Help Center</a>
                                    <a href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#3D8D7A] hover:text-[#FBFFE4] transition-colors"
                                        role="menuitem">Settings</a>
                                </div>
                                <div class="py-1 border-t border-[#3D8D7A]">
                                    <a href="logout.php"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#3D8D7A] hover:text-[#FBFFE4] transition-colors"
                                        role="menuitem">Sign out</a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="login.php"
                            class="ml-4 px-4 py-2 border border-transparent rounded-full shadow-sm text-sm font-medium text-[#3D8D7A] bg-[#FBFFE4] hover:bg-[#e8f5d0] transition-all duration-200 transform hover:scale-105">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-toggle" type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-[#FBFFE4] hover:text-white hover:bg-[#4a9c87] focus:outline-none focus:ring-2 focus:ring-[#FBFFE4] transition-all"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden bg-[#3D8D7A] border-t border-[#4a9c87]">
        <div class="max-w-7xl mx-auto px-2 pt-2 pb-3 space-y-1 sm:px-3 z-50">
            <!-- Mobile Search -->
            <form action="filter.php" method="get" class="px-2 pt-2 pb-3">
                <div class="relative rounded-md shadow-sm">
                    <input type="search" name="search_book" placeholder="Search by ISBN or name..."
                        class="block w-full pl-4 pr-10 py-2 bg-white rounded-md border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#FBFFE4]">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <button type="submit" name="search"
                            class="p-1 rounded-md text-gray-700 hover:text-gray-900 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Mobile Navigation Links -->
            <a href="wishlist.php"
                class="flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87] group">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    Wishlist
                </div>
                <?php if (isset($userId) && $countWishlist > 0): ?>
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        <?= $countWishlist; ?>
                    </span>
                <?php endif; ?>
            </a>

            <a href="cart.php"
                class="flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87] group">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                    Cart
                </div>
                <?php if (isset($userEmail) && $countcart > 0): ?>
                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                        <?= $countcart; ?>
                    </span>
                <?php endif; ?>
            </a>

            <a href="chatboard.php"
                class="flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87] group">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                    </svg>
                    Chat
                </div>
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">2</span>
            </a>

            <a href="sell/sell2.php"
                class="flex items-center px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87] group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Sell Used Book
            </a>

            <?php if (isset($_SESSION['user'])): ?>
                <div class="pt-4 pb-3 border-t border-[#4a9c87]">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full border-2 border-[#FBFFE4]"
                                src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                                alt="User profile">
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-[#FBFFE4]"><?= $user['name']; ?></div>
                            <div class="text-sm font-light text-[#e8f5d0]"><?= $user['email']; ?></div>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        <a href="profile.php"
                            class="block px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87]">Profile</a>
                        <a href="contact.php"
                            class="block px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87]">Help
                            Center</a>
                        <a href="#"
                            class="block px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87]">Settings</a>
                        <a href="logout.php"
                            class="block px-3 py-2 rounded-md text-base font-medium text-[#FBFFE4] hover:bg-[#4a9c87]">Sign
                            out</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php"
                    class="block w-full px-4 py-2 mt-4 text-center text-sm font-medium text-[#3D8D7A] bg-[#FBFFE4] rounded-md hover:bg-[#e8f5d0] transition-colors">
                    Login
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuToggle.addEventListener('click', function () {
        const expanded = this.getAttribute('aria-expanded') === 'true';
        this.setAttribute('aria-expanded', !expanded);
        mobileMenu.classList.toggle('hidden');
        document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'auto' : 'hidden';

        // Toggle hamburger icon
        const svg = this.querySelector('svg');
        if (svg) {
            svg.classList.toggle('block');
            svg.classList.toggle('hidden');
        }
    });

    // User dropdown toggle (desktop)
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenuButton) {
        userMenuButton.addEventListener('click', function () {
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', !expanded);
            userDropdown.classList.toggle('hidden');
            userDropdown.classList.toggle('opacity-0');
            userDropdown.classList.toggle('scale-95');
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function (e) {
        // Close user dropdown
        if (userMenuButton && !e.target.closest('#user-menu-button') && !e.target.closest('#user-dropdown')) {
            userDropdown.classList.add('hidden');
            userDropdown.classList.add('opacity-0');
            userDropdown.classList.add('scale-95');
            userMenuButton.setAttribute('aria-expanded', 'false');
        }

        // Close mobile menu
        if (!e.target.closest('#mobile-menu-toggle') && !e.target.closest('#mobile-menu')) {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
            mobileMenuToggle.setAttribute('aria-expanded', 'false');

            // Reset hamburger icon
            const svgs = mobileMenuToggle.querySelectorAll('svg');
            svgs.forEach(svg => {
                svg.classList.add('block');
                svg.classList.add('hidden');
            });
        }
    });
</script>