<?php
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user['user_id'];
$userEmail = $user['email'];
?>
<div class="flex fixed w-full z-50 top-0 justify-between items-center bg-[#3D8D7A] px-[5%] py-3">
    <a href="index.php" class="text-[#FBFFE4] font-bold text-2xl tracking-wide"><img
            src="assets/images/Screenshot 2025-03-24 135151-Photoroom.png" alt="Logo"
            class="h-10 w-auto   object-contain">
    </a>
    <form action="filter.php" method="get" class="flex border rounded">
        <input type="search" name="search_book" placeholder="Search by ISBN or name..."
            class="p-2 bg-white rounded-l w-[35rem] text-black ">
        <button type="submit" name="search"
            class="bg-[#B3D8A8] font-semibold rounded-r p-2 text-slate-800">Search</button>
    </form>
    <a href="wishlist.php"
        class="relative inline-flex items-center p-1 text-sm font-medium text-center text-white rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-8 text-[#FBFFE4]">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <span class="sr-only">Notifications</span>
        <?php $countWishlistQuery = $connect->query("select * from wishlist where user_id='$userId'");
        $countWishlist = $countWishlistQuery->num_rows;
        if ($countWishlist > 0):
            ?>
            <div
                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                <?= $countWishlist; ?>
            </div>
        <?php endif; ?>
    </a>
    <a href="cart.php"
        class="relative inline-flex items-center p-1 text-sm font-medium text-center text-white rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-7 text-[#FBFFE4]">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>
        <span class="sr-only">Notifications</span>
        <?php $countcartQuery = $connect->query("select * from cart where email='$userEmail' and direct_buy=0");
        $countcart = $countcartQuery->num_rows;
        if ($countcart > 0):
            ?>
        <div
            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
            <?= $countcart;?>
        </div>
        <?php endif;?>
    </a>

    <a href="chatboard.php"
        class="relative inline-flex items-center p-1 text-sm font-medium text-center text-white rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
        </svg>
        <span class="sr-only">Notifications</span>
        <div
            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
            2
        </div>
    </a>

    <a href="sell/sell2.php" class="border p-2 rounded-full text-[#FBFFE4]">Sell Used Book</a>

    <?php if (isset($_SESSION['user'])): ?>
        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
            class="flex items-center text-sm pe-1 font-medium text-[#FBFFE4] rounded-full md:me-0 border p-1 focus:ring-gray-100 relative"
            type="button">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 me-2 rounded-full"
                src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" alt="user photo">
            <?= $user['name']; ?>
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </button>

        <div id="dropdownAvatarName"
            class="absolute right-5 mt-2 hidden bg-[#B3D8A8] divide-y divide-gray-100 rounded-lg shadow-sm w-44 z-50">
            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                <div class="truncate"><?= $user['email']; ?></div>
            </div>
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li>
                    <a href="profile.php"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View
                        Profile</a>
                </li>
                <li>
                    <a href="contact.php "
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Help</a>
                </li>
                <li>
                    <a href="#"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
            </ul>
            <div class="py-2">
                <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</div>