<?php
include_once "config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;
$userEmail = $user['email'];
$booksQuery = $connect->query("select * from wishlist join books on books.id=wishlist.book_id where user_id='$userId'");
$count = $connect->query("select * from wishlist where user_id='$userId'");
$coutwishlist = mysqli_num_rows($count);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        @media (max-width: 640px) {
            .mobile-menu {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 40;
                display: flex;
                background-color: #B3D8A8;
                padding: 0.5rem;
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            }

            .mobile-menu-button {
                flex: 1;
                padding: 0.5rem;
                text-align: center;
                font-size: 0.75rem;
            }

            .profile-sidebar {
                display: none;
            }

            .profile-sidebar.mobile-open {
                display: block;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 50;
                overflow-y: auto;
            }

            .content-area {
                margin-left: 0;
                padding-bottom: 4rem;
                /* Space for mobile menu */
            }
        }
    </style>
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>

    <div class="flex flex-col md:flex-row min-h-screen pt-14">
        <button id="mobileMenuButton" class="md:hidden fixed top-16 right-4 z-30 p-2 bg-[#B3D8A8] rounded-lg shadow">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar - Hidden on mobile by default -->
        <div id="profileSidebar"
            class="profile-sidebar xl:w-1/4 md:w-1/3 w-full bg-[#B3D8A8] px-4 pt-6 pb-20 flex flex-col items-center md:items-start">
            <div class="w-full flex flex-col items-center md:items-start">
                <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                    alt="Profile Picture" class="w-20 h-20 md:w-24 md:h-24 rounded-full border-2 border-gray-700">
                <h1 class="mt-4 text-lg md:text-xl font-semibold text-center md:text-left"><?= $user['name']; ?></h1>
                <p class="text-gray-800 text-xs md:text-sm text-center md:text-left"><?= $user['email']; ?></p>
            </div>

            <div class="mt-6 w-full flex flex-col items-center md:items-start space-y-2">
                <button
                    class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg font-medium md:font-semibold text-sm md:text-base cursor-pointer hover:bg-[#e8eccf] transition"
                    onclick="showSection('edit_details')">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                        Edit Details
                    </span>
                </button>
                <button
                    class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg font-medium md:font-semibold text-sm md:text-base cursor-pointer hover:bg-[#e8eccf] transition"
                    onclick="showSection('my_selling')">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd" />
                        </svg>
                        My Selling
                    </span>
                </button>
                <button
                    class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg font-medium md:font-semibold text-sm md:text-base cursor-pointer hover:bg-[#e8eccf] transition"
                    onclick="showSection('order')">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                clip-rule="evenodd" />
                        </svg>
                        My Orders
                    </span>
                </button>
                <button
                    class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg font-medium md:font-semibold text-sm md:text-base cursor-pointer hover:bg-[#e8eccf] transition"
                    onclick="showSection('wishlist')">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Wishlist
                    </span>
                </button>
                <button
                    class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg font-medium md:font-semibold text-sm md:text-base cursor-pointer hover:bg-[#e8eccf] transition"
                    onclick="showSection('address')">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                        My Address
                    </span>
                </button>
                <button
                    class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg font-medium md:font-semibold text-sm md:text-base cursor-pointer hover:bg-[#e8eccf] transition"
                    onclick="showSection('settings')">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                clip-rule="evenodd" />
                        </svg>
                        Settings
                    </span>
                </button>
                <a href="logout.php"
                    class="w-full text-left px-4 py-2 bg-red-600 text-white rounded-lg font-medium md:font-semibold text-sm md:text-base hover:bg-red-700 transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area w-full md:w-2/3 lg:w-3/4 flex-1 p-4 md:p-6">
            <?php include_once "includes/editDetails.php"; ?>
            <?php include_once "includes/mySelling.php"; ?>
            <?php include_once "includes/myOrder.php"; ?>
            <?php include_once "includes/myWishlist.php"; ?>
            <?php include_once "includes/myAddress.php"; ?>
            <div id="settings" class="content-section hidden">
                <h2 class="text-xl md:text-2xl font-semibold mb-4">Settings</h2>
                <div class="bg-white rounded-lg shadow p-4 md:p-6">
                    <p class="text-gray-700">Update your account settings here.</p>
                </div>
            </div>
        </div>

        <!-- Mobile Bottom Navigation (only shows on small screens) -->
        <div class="mobile-menu md:hidden">
            <button class="mobile-menu-button" onclick="showSection('edit_details')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-xs">Profile</span>
            </button>
            <button class="mobile-menu-button" onclick="showSection('order')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span class="text-xs">Orders</span>
            </button>
            <button class="mobile-menu-button" onclick="showSection('wishlist')">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
                <span class="text-xs">Wishlist</span>
            </button>
            <button class="mobile-menu-button" onclick="toggleSidebar()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-xs">Menu</span>
            </button>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('profileSidebar');
            sidebar.classList.toggle('mobile-open');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('profileSidebar');
            const mobileMenuButton = document.getElementById('mobileMenuButton');

            if (window.innerWidth < 768 &&
                !sidebar.contains(event.target) &&
                event.target !== mobileMenuButton &&
                !event.target.closest('#mobileMenuButton')) {
                sidebar.classList.remove('mobile-open');
            }
        });

        // Mobile menu button event
        document.getElementById('mobileMenuButton').addEventListener('click', function () {
            toggleSidebar();
        });

        // Section management
        document.addEventListener("DOMContentLoaded", function () {
            const lastSection = localStorage.getItem("activeSection") || "edit_details";
            showSection(lastSection);
        });

        function showSection(section) {
            document.querySelectorAll('.content-section').forEach(div => div.classList.add('hidden'));
            document.getElementById(section).classList.remove('hidden');
            localStorage.setItem("activeSection", section);

            // Close sidebar on mobile after selection
            if (window.innerWidth < 768) {
                document.getElementById('profileSidebar').classList.remove('mobile-open');
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>