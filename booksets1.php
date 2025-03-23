<?php

include_once "config/connect.php";

// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

if (!isset($_GET['bookType'])) {
    redirect(" index.php");
    exit;
}

$bookType = $_GET["bookType"];
$query = $connect->query("SELECT * FROM books WHERE version='$bookType'");

if ($query->num_rows == 0) {
    header("Location: index.php");
    exit;
}

$userId = $user ? $user['user_id'] : null;

// Handle Wishlist Toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist1']) && $userId) {
    $bookId = intval($_POST['wishlist_id1']);

    // Check if the book is already in the wishlist
    $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");

    if ($check->num_rows > 0) {
        // Remove from wishlist
        $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
    } else {
        // Add to wishlist
        $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
    }

    // Redirect to the same page
    redirect(" booksets1.php?bookType=" . urlencode($bookType));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Sets</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#f6f7f5]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="mt-30 :grid grid-cols-4 bg-[#f6f7f5] p-10">
        <div class="bg-white border-b border-gray-200 py-5 px-5 shadow">
            <h1 class="text-xl font-semibold">Showing <?= $query->num_rows; ?> results for "book sets"</h1>
        </div>

        <div class="grid grid-cols-5 gap-5 p-10 bg-white h-auto">
            <?php while ($book = $query->fetch_assoc()):
                $bookId = $book['id'];
                $isWishlisted = false;

                if ($userId) {
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);
                }
                $mrp =floatval($book['mrp']);
                $sell_price =floatval($book['sell_price']);
                if($mrp > 0 && is_numeric($sell_price)){
                    $percentage = ($mrp - $sell_price) / $mrp * 100;
                }
                ?>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                    <!-- Discount Badge -->
                    <div class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                    <?=round($percentage);?>% OFF
                    </div>

                    <!-- Wishlist Button -->
                    <form method="POST" action="" class="absolute top-3 right-3">
                        <input type="hidden" name="wishlist_id1" value="<?= $bookId; ?>">
                        <button type="submit" class="cursor-pointer" name="toggle_wishlist1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                class="size-6 hover:scale-110 transition">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </form>

                    <!-- Book Details -->
                    <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                        <div class="flex justify-center">
                            <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                class="w-40 h-56 object-cover hover:scale-105 transition shadow-md rounded-md">
                        </div>

                        <div class="mt-4 text-center">
                            <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                            <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?>
                                <span class="text-sm text-orange-400 ml-2"><?= $book['book_category']; ?></span>
                            </p>

                            <div class="flex justify-center items-center space-x-2 mt-1">
                                <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                            </div>
                        </div>
                    </a>

                    <!-- Add to Cart -->
                    <a href="cart.php?add_book=<?= $book['id']; ?>">
                        <div class="mt-4 border-t pt-3 flex justify-between items-center">
                            <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>

                            <!-- Dynamic Rating -->
                            <div class="flex">
                                <?php
                                $rating = rand(2, 5);
                                for ($i = 1; $i <= 5; $i++) {
                                    echo $i <= $rating
                                        ? '<span class="text-orange-500 text-lg">★</span>'
                                        : '<span class="text-gray-400 text-lg">★</span>';
                                }
                                ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <?php include_once "includes/footer2.php"; ?>
</body>

</html>
