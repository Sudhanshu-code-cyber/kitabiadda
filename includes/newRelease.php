<?php
include_once "config/connect.php";

// Ensure the user is logged in
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user['user_id']; // Get logged-in user ID

// Fetch books
$booksQuery = $connect->query("SELECT * FROM books WHERE version='new'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Books Wishlist</title>
</head>

<body class="bg-gray-100 p-10">

    <h1 class="text-3xl font-bold mb-5">Books List</h1>

    <div class="grid grid-cols-3 gap-6">
        <?php while ($book = $booksQuery->fetch_assoc()): ?>
            <?php
            // Check if the book is already in the wishlist
            $bookId = $book['id'];
            $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
            $isWishlisted = ($checkWishlist->num_rows > 0);
            ?>

            <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                <!-- Discount Badge (60% Off) -->


                <!-- Book Image (Clickable Link) -->
                <div class="flex relative justify-center hover:scale-105 transition">
                    <div class="absolute  left-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">

                        60% OFF
                    </div>
                    <form method="POST" action="actions/wishlistAction.php" class="absolute top-2 right-2">
                        <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                        <button type="submit" name="toggle_wishlist">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="cursor-pointer size-6 
                            <?= $isWishlisted ? 'text-red-500' : 'text-gray-400'; ?> hover:text-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </form>

                    <button target="_blank">
                        <img src="images/<?= $book['img1']; ?>" alt="Book Cover"
                            class="w-40 h-56 object-cover shadow-md rounded-md ">
                    </button>
                </div>

                <!-- Book Info -->
                <div class="mt-4">
                    <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                    <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?></p>

                    <!-- Price -->
                    <div class="flex items-center space-x-2 mt-1">
                        <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                        <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                    </div>
                </div>

                <!-- Footer Section (Add to Cart + Dynamic Rating) -->
                <div class="mt-4 border-t pt-2 flex justify-between items-center">
                    <a href="view2.php?book_id=<?= $book['id']; ?>">
                        <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>
                    </a>


                    <!-- Dynamic Rating -->
                    <div class="flex">
                        <?php
                        $rating = rand(2, 5); // Random Rating for demo
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($rating)) {
                                echo '<span class="text-orange-500 text-lg">★</span>';
                            } elseif ($i - $rating < 1) {
                                echo '<span class="text-orange-500 text-lg">☆</span>';
                            } else {
                                echo '<span class="text-gray-400 text-lg">★</span>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

</body>

</html>