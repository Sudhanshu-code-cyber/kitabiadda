<?php
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;
$userEmail = $user ? $user['email'] : null;
?>
<div class="flex fixed w-full z-50 top-0 xl:gap-10 lg:gap-[5rem] md:gap-7  items-center bg-[#3D8D7A] px-[5%] py-3">
    <!-- Logo -->
    <a href="index.php" class="text-[#FBFFE4] font-bold text-2xl tracking-wide">
        <img src="assets/logo5.png" alt="Logo" class="h-10  object-contain">
    </a>


    <!-- Mobile Menu Button (Hamburger) - Hidden on desktop -->
    <div class="flex gap-2 ml-[8rem] md:hidden  md:ml-[17rem]">
        <div id="search-toggle" class="flex gap-1 justify-center items-center border rounded-full px-2 py-1 text-[#FBFFE4] font-semibold">
            Search
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-6 " fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <button id="mobile-menu-toggle" class=" text-[#FBFFE4] focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Desktop Navigation Items - Hidden on mobile -->
    <div
        class="hidden md:flex xl:flex 2xl:flex xl:justify-between 2xl:justify-between lg:justify-between lg:w-[60rem] xl:w-[70rem] 2xl:w-[75rem] items-center space-x-4 lg:space-x-6">
        <!-- Search Bar -->
        <form action="filter.php" method="get" class="flex xl:w-[35rem] 2xl:w-[42rem] rounded">
            <input type="search" name="search_book" placeholder="Search by ISBN or name..."
                class="p-2 bg-white rounded-l-md xl:w-[35rem] 2xl:w-[40rem] lg:w-[26rem] text-black border-0 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-0">
            <button type="submit" name="search"
                class="inline-flex items-center px-4 py-2 bg-[#B3D8A8] text-gray-800 font-medium rounded-r-md hover:bg-[#9bc58d] transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </form>

        <!-- Wishlist -->
        <div class="flex gap-7">
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
        </div>

        <!-- Sell Button -->
        <a href="sell/sell2.php"
            class="relative  px-2 py-2 rounded-full text-sm font-semibold text-[#FBFFE4] bg-gradient-to-br from-[#4a9c87] to-[#3D8D7A] shadow-md hover:shadow-lg hover:from-[#3D8D7A] hover:to-[#2a7d6a] border border-[#FBFFE4]/20 hover:border-[#FBFFE4]/40 transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-95 group overflow-hidden">

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

        <!-- User Profile or Login -->
        <?php if (isset($_SESSION['user'])): ?>
            <div class="relative">
                <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
                    class="flex items-center text-sm pe-1 font-medium text-[#FBFFE4] bg-gradient-to-br from-[#4a9c87] to-[#3D8D7A] shadow-md hover:shadow-lg hover:from-[#3D8D7A] hover:to-[#2a7d6a] border border-[#FBFFE4]/20 hover:border-[#FBFFE4]/40 transition-all duration-300 ease-in-out transform hover:scale-[1.03] active:scale-95 group overflow-hidden rounded-full md:me-0 focus:ring-gray-100 cursor-pointer transition-colors"
                    type="button">
                    <img class="w-11 h-11 me-2 rounded-full"
                        src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                        alt="user photo">
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownAvatarName"
                    class="hidden absolute right-0 mt-2 bg-[#B3D8A8] divide-y divide-gray-100 rounded-md shadow-xl w-44 z-50">
                    <div class="px-4 py-3 text-sm text-gray-900">
                        <div class="font-medium"><?= $user['name']; ?></div>
                        <div class="truncate"><?= $user['email']; ?></div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700">
                        <li>
                            <a href="profile.php"
                                class="block px-4 py-2 hover:bg-[#4a9c87] hover:text-[#FBFFE4] transition-colors">View
                                Profile</a>
                        </li>
                        <li>
                            <a href="contact.php"
                                class="block px-4 py-2 hover:bg-[#4a9c87] hover:text-[#FBFFE4] transition-colors">Help</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-[#4a9c87] hover:text-[#FBFFE4] transition-colors">Settings</a>
                        </li>
                    </ul>
                    <div class="py-2">
                        <a href="logout.php"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#4a9c87] hover:text-[#FBFFE4] transition-colors">Logout</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php"
                class="px-4 py-2 border border-transparent rounded-full text-sm font-medium text-[#3D8D7A] bg-[#FBFFE4] hover:bg-[#e8f5d0] transition-colors">
                Login
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Mobile Menu (Hidden by default) -->
<div id="mobile-menu" class="md:hidden hidden fixed top-16 left-0 right-0 bg-[#3D8D7A] shadow-lg z-40 px-[5%] py-4">
    <div class="space-y-4">
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
            <div class="pt-4 border-t border-[#4a9c87]">
                <div class="flex items-center px-2">
                    <img class="w-10 h-10 rounded-full border-2 border-[#FBFFE4]"
                        src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                        alt="user photo">
                    <div class="ml-3">
                        <div class="text-[#FBFFE4] font-medium"><?= $user['name']; ?></div>
                        <div class="text-sm text-[#e8f5d0] truncate"><?= $user['email']; ?></div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="profile.php"
                        class="block px-3 py-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded transition-colors">Profile</a>
                    <a href="contact.php"
                        class="block px-3 py-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded transition-colors">Help</a>
                    <a href="#"
                        class="block px-3 py-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded transition-colors">Settings</a>
                    <a href="logout.php"
                        class="block px-3 py-2 text-[#FBFFE4] hover:bg-[#4a9c87] rounded transition-colors">Logout</a>
                </div>
            </div>
        <?php else: ?>
            <a href="login.php"
                class="block w-full px-4 py-2 mt-2 text-center text-[#3D8D7A] bg-[#FBFFE4] rounded hover:bg-[#e8f5d0] transition-colors">
                Login
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Mobile Search Menu (Hidden by default) -->
<div id="search-fun" class="md:hidden hidden fixed top-16 left-0 right-0 bg-[#3D8D7A] shadow-lg z-40 px-[5%] py-4">
    <div class="space-y-4">
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
    </div>
</div>

<script>
    // Mobile menu toggle
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    // Search Function toggle
    const searchToggle = document.getElementById('search-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const searchFun = document.getElementById('search-fun');

    mobileMenuToggle.addEventListener('click', function () {
        mobileMenu.classList.toggle('hidden');
        document.body.style.overflow = mobileMenu.classList.contains('hidden') ? 'auto' : 'hidden';
    });
    searchToggle.addEventListener('click', function () {
        searchFun.classList.toggle('hidden');
        document.body.style.overflow = searchFun.classList.contains('hidden') ? 'auto' : 'hidden';
    });

    // User dropdown toggle (if exists)
    const userDropdownButton = document.getElementById('dropdownAvatarNameButton');
    const userDropdown = document.getElementById('dropdownAvatarName');

    if (userDropdownButton && userDropdown) {
        userDropdownButton.addEventListener('click', function () {
            userDropdown.classList.toggle('hidden');
        });

        // Close when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#dropdownAvatarNameButton') && !e.target.closest('#dropdownAvatarName')) {
                userDropdown.classList.add('hidden');
            }
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('#mobile-menu-toggle') && !e.target.closest('#mobile-menu')) {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        if (!e.target.closest('#search-toggle') && !e.target.closest('#search-fun')) {
            searchFun.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });
</script>