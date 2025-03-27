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
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>

    <div class="flex flex-col sm:flex-row h-screen pt-14">
        <div class="w-full sm:w-1/4 sm:fixed sm:h-screen bg-[#B3D8A8] px-6 pt-14 flex flex-col items-center sm:items-start">
            <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                alt="Profile Picture" class="w-24 h-24 rounded-full border border-gray-700">
            <h1 class="mt-4 text-xl font-semibold text-center sm:text-left"><?= $user['name']; ?></h1>
            <p class="text-gray-800 text-sm text-center sm:text-left"><?= $user['email']; ?></p>

            <div class="mt-6 w-full flex flex-col items-center sm:items-start">
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('edit_details')">Edit Details</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('my_selling')">My Selling</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('order')">My Orders</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('wishlist')">Wishlist</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('address')">My Address</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-6 font-semibold cursor-pointer"
                    onclick="showSection('settings')">Settings</button>
                <a href="logout.php"
                    class="text-left px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">Logout</a>
            </div>
        </div>

        <div class="w-full sm:w-3/4 sm:ml-[25%] flex-1 p-6">
            <?php include_once "includes/editDetails.php"; ?>
            <?php include_once "includes/mySelling.php"; ?>
            <?php include_once "includes/myOrder.php"; ?>
            <?php include_once "includes/myWishlist.php"; ?>
            <?php include_once "includes/myAddress.php"; ?>
            <div id="settings" class="content-section hidden">
                <h2 class="text-2xl font-semibold mb-4">Settings</h2>
                <p>Update your account settings here.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const lastSection = localStorage.getItem("activeSection") || "edit_details";
            showSection(lastSection);
        });

        function showSection(section) {
            document.querySelectorAll('.content-section').forEach(div => div.classList.add('hidden'));
            document.getElementById(section).classList.remove('hidden');
            localStorage.setItem("activeSection", section);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>
