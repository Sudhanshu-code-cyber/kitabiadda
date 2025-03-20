<?php
include_once "config/connect.php";

// Ensure the user is logged in
if (isset($_SESSION['user'])) {
    $user = getUser();
}


$userId = $user ? $user['user_id'] : null; // Get logged-in user ID

// Fetch books
$booksQuery = $connect->query("SELECT * FROM books WHERE version='new' and e_book_avl='yes'");
?>

<section class="bg-white py-10">
    <div class="w-full px-[5%] mx-auto px-[2%]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">e-Book</h2>
            <a href="booksets3.php" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <div class="relative">
            <!-- Left Arrow for Old Books -->
            <button id="scrollLeft3"
                class="absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8592;
            </button>

            <div id="bookScroll3" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">
               
            <?php
                while ($book = $booksQuery->fetch_assoc()):
                    // Check if the book is already in the wishlist
                    $bookId = $book['id'];
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);
                    
                    ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                        <!-- Discount Badge (60% Off) -->
                        <div
                            class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                            <?=round($percentage);?>% OFF
                        </div>

                        <!-- Wishlist Heart Icon (Prevents Click from Going to Next Page) -->
                        <form method="POST"
                            action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
                            class="absolute top-3 right-3" onclick="event.stopPropagation();">
                            <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                            <button type="submit" name="toggle_wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                    class="size-6 hover:scale-110 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </button>
                        </form>

                        <!-- Book Click Redirect -->
                        <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                            <div class="flex justify-center hover:scale-105 transition">
                                <img src="images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-40 h-56 object-cover shadow-md rounded-md">
                            </div>

                            <!-- Book Info -->
                            <div class="mt-4 text-center">
                                <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                                <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?>
                                <span class="text-sm text-orange-400 ml-2"><?= $book['book_category'];?></span>
                            </p>

                                <!-- Price -->
                                <div class="flex justify-center items-center space-x-2 mt-1">
                                    <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                    <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                                </div>

                                 <!-- Type -->
                                   <p class="text-red-400 font-semibold sm mt-1">E-BOOK : <?php
                                    if ($book['e_book_avl'] == "Yes") {
                                        echo $book['e_book_price'];
                                    } else {
                                        echo "Not Available";
                                    }

                                    ?></p>


                            </div>
                                    </a>
                            <!-- Footer (Add to Cart + Rating) -->
                           <a href="cart.php?add_book=<?= $book['id'];?>">
                            <div class="mt-4 border-t pt-3 flex justify-between items-center">
                                <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>

                                <!-- Dynamic Rating -->
                                <div class="flex">
                                    <?php
                                    $rating = rand(2, 5); // Random Rating for demo
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= floor($rating)) {
                                            echo '<span class="text-orange-500 text-lg">★</span>';
                                        } else {
                                            echo '<span class="text-gray-400 text-lg">★</span>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php endwhile; ?>

            </div>

            <!-- Right Arrow for Old Books -->
            <button id="scrollRight3"
                class="absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8594;
            </button>
        </div>
    </div>
</section>



<script>
    const scrollContainer3 = document.getElementById("bookScroll3");
    document.getElementById("scrollLeft3").onclick = () => scrollContainer3.scrollBy({
        left: -300,
        behavior: 'smooth'
    });
    document.getElementById("scrollRight3").onclick = () => scrollContainer3.scrollBy({
        left: 300,
        behavior: 'smooth'
    });

</script>


 