<?php

include_once "config/connect.php";

// Check if user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null;

// Handle wishlist toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggleWishlist'])) {
    if (!$userId) {
        redirect("login.php");
        exit;
    }
    
    $bookId = intval($_POST['wishlistId']);

    // Check if book exists in wishlist
    $query = "SELECT 1 FROM wishlist WHERE user_id = $userId AND book_id = $bookId";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Remove from wishlist
        $deleteQuery = "DELETE FROM wishlist WHERE user_id = $userId AND book_id = $bookId";
        mysqli_query($connect, $deleteQuery);
    } else {
        // Add to wishlist
        $insertQuery = "INSERT INTO wishlist (user_id, book_id) VALUES ($userId, $bookId)";
        mysqli_query($connect, $insertQuery);
    }

    redirect(" wishlist.php"); // Refresh wishlist page
    exit;
}

// Fetch wishlist items
$booksResult = [];
$countWishlist = 0;

if ($userId) {
    $query = "SELECT books.* FROM wishlist JOIN books ON books.id = wishlist.book_id WHERE wishlist.user_id = $userId";
    $booksResult = mysqli_query($connect, $query);

    $countQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = $userId";
    $countResult = mysqli_query($connect, $countQuery);
    $countWishlist = mysqli_fetch_assoc($countResult)['count'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<body>
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex mt-30 gap-4 px-[5%] p-10 flex-col bg-[#fefff7]">
        <h1 class="font-bold text-2xl text-red-900 flex items-center gap-2 animate-pulse">
            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text">
                My Wishlist (<?= $countWishlist; ?>)
            </span>
        </h1>

        <?php if ($countWishlist == 0): ?>
            <div class="text-center py-10">
                <p class="text-xl text-gray-500">Your wishlist is empty 😢</p>
                <p class="text-gray-500">Explore our collection and add books you love!</p>
                <a href="index.php" class="mt-4 inline-block px-6 py-3 bg-[#3D8D7A] text-white font-semibold rounded-lg shadow-md hover: transition">
                    Browse Books
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-5 gap-4">
                <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
                    <?php
                    $bookId = $book['id'];
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                    ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                        <div class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                            <?= $discount; ?>% OFF
                        </div>
                        <form method="POST" action="wishlist.php" class="absolute top-3 right-3">
                            <input type="hidden" name="wishlistId" value="<?= $bookId; ?>">
                            <button type="submit" class="cursor-pointer" name="toggleWishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" stroke="red" stroke-width="1.5" class="size-6 hover:scale-110 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </button>
                        </form>
                        <a href="view.php?book_id=<?= $bookId; ?>" class="block">
                            <div class="flex justify-center  ">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover" class="w-40 h-56 object-cover hover:scale-105 transition shadow-md rounded-md">
                            </div>
                            <div class="mt-4 text-center">
                                <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"> <?= $book['book_name']; ?> </h2>
                                <p class="text-gray-500 text-sm"> <?= $book['book_author']; ?> </p>
                                <div class="flex justify-center items-center space-x-2 mt-1">
                                    <p class="text-gray-500 line-through text-sm"> ₹<?= $book['mrp']; ?>/- </p>
                                    <p class="text-black font-bold text-lg"> ₹<?= $book['sell_price']; ?>/- </p>
                                </div>
                            </div>
                        </a>
                        <a href="cart.php?add_book=<?= $book['id']; ?>">
                            <div class="mt-4 border-t pt-3 flex justify-between items-center">
                                <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include_once "includes/footer2.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>
</html>
