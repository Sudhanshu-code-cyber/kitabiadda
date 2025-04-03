<?php
include_once "config/connect.php";

// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null; // Get logged-in user ID

// Fetch books
$booksQuery = $connect->query("SELECT * FROM books WHERE version='old'");
$book = $booksQuery->fetch_assoc()
?>

<section class="py-10">
    <div class="w-full  mx-auto px-[2%]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Old Book</h2>
            <a href="booksets1.php?bookType=<?= $book['version']; ?>" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <div class="relative">
            <!-- Left Arrow for Old Books (Hidden on Mobile) -->
            <button id="scrollLeft2"
                class="hidden sm:block absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8592;
            </button>

            <div id="bookScroll2" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">
                <?php
                while ($book = $booksQuery->fetch_assoc()):
                    // Check if the book is already in the wishlist
                    $bookId = $book['id'];
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);

                    // Discount calculation
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    if ($mrp > 0 && is_numeric($sell_price)) {
                        $percentage = ($mrp - $sell_price) / $mrp * 100;
                    } else {
                        echo "Error: Invalid price values.";
                    }
                    ?>
                                <div class="bg-white p-3 rounded-lg shadow-lg border border-gray-200 w-40 sm:w-60 min-w-[10rem] sm:min-w-[14rem] relative transition-transform duration-300 hover:scale-[1.03]">
    <!-- Discount Badge (Smaller on Mobile) -->
    <div class="absolute left-2 top-2 bg-red-500 text-white px-1.5 sm:px-3 py-0.5 sm:py-1 text-[10px] sm:text-xs font-bold rounded-md shadow-md">
    <?= round($percentage); ?>% OFF
    </div>

    <!-- Wishlist Button (Compact on Mobile) -->
    <form method="POST" action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>" class="absolute top-2.5 sm:top-3 right-2 sm:right-3" onclick="event.stopPropagation();">
        <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
        <button type="submit" class="cursor-pointer" name="toggle_wishlist">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5" class="size-4 sm:size-6 hover:scale-110 transition">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
        </button>
    </form>

    <!-- Book Click Redirect -->
    <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
        <div class="flex justify-center">
            <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover" class="w-28 h-40 sm:w-36 sm:h-52 object-cover shadow-md hover:scale-105 transition rounded-md">
        </div>

        <!-- Book Info -->
        <div class="mt-2 sm:mt-3 text-center">
            <h2 class="text-xs sm:text-base font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
            <p class="text-gray-500 text-[10px] sm:text-xs font-semibold">
                <?= $book['book_author']; ?>
                <span class="text-[10px] sm:text-xs text-orange-400 ml-1"><?= $book['book_category'];?></span>
            </p>

            <!-- Price -->
            <div class="flex justify-center items-center space-x-1 sm:space-x-2 mt-1">
                <p class="text-gray-500 line-through text-[10px] sm:text-xs">₹<?= $book['mrp']; ?>/-</p>
                <p class="text-black font-bold text-sm sm:text-lg">₹<?= $book['sell_price']; ?>/-</p>
            </div>

         
        </div>
    </a>

    <!-- Footer (Add to Cart + Rating) -->
    <a href="cart.php?add_book=<?= $book['id']; ?>" class="block">
        <div class="mt-3 sm:mt-4 border-t pt-2 sm:pt-3 flex justify-between items-center">
            <button class="text-[#27445D] text-[10px] sm:text-xs font-semibold hover:underline">Add to cart</button>

            <!-- Dynamic Rating -->
            <div class="flex">
                <?php
                $rating = $book['book_rating'];
                for ($i = 1; $i <= 5; $i++) {
                    echo '<span class="'.($i <= $rating ? 'text-orange-500' : 'text-gray-400').' text-xs sm:text-lg">★</span>';
                }
                ?>
            </div>
        </div>
    </a>
</div>
                <?php endwhile; ?>
            </div>

            <!-- Right Arrow for Old Books (Hidden on Mobile) -->
            <button id="scrollRight2"
                class="hidden sm:block absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8594;
            </button>
        </div>
    </div>
</section>

<script>
    const scrollContainer2 = document.getElementById("bookScroll2");
    document.getElementById("scrollLeft2").onclick = () => scrollContainer2.scrollBy({
        left: -300,
        behavior: 'smooth'
    });
    document.getElementById("scrollRight2").onclick = () => scrollContainer2.scrollBy({
        left: 300,
        behavior: 'smooth'
    });
</script>
