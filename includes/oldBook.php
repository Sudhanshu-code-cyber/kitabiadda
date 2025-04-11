<?php
include_once "config/connect.php";

// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null;
$userEmail = $user ? $user['email'] : null;

// Fetch old books
$booksQuery = $connect->query("SELECT * FROM books WHERE version='old' ORDER BY id DESC");
?>

<style>
     .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
</style>
<section class="mt-10">
    <div class="w-full mx-auto px-[2%]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Old Book</h2>
            <a href="booksets1.php?bookType=old" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <div class="relative">
            <!-- Left Arrow -->
            <button id="scrollLeft2"
                class="hidden sm:block absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8592;
            </button>

            <div id="bookScroll2" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 md:px-10  pb-4">
                <?php while ($book = $booksQuery->fetch_assoc()):
                    $bookId = $book['id'];
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);

                    // Discount calculation
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $percentage = ($mrp > 0 && is_numeric($sell_price)) ? (($mrp - $sell_price) / $mrp * 100) : 0;

                    // Posted time
                    $postedTime = isset($book['post_date']) ? getPostedTime($book['post_date']) : "Unknown date";
                    $sell_id = $book['seller_id'];
                    $callAdd = mysqli_query($connect, "SELECT * FROM user_address WHERE user_id='$sell_id'");
                    $address = mysqli_fetch_array($callAdd);
                    ?>
                    <div
                        class="bg-white p-3 rounded-lg shadow-lg border border-gray-200 w-40 sm:w-60 min-w-[10rem] sm:min-w-[14rem] relative hover:shadow-xl">

                        <!-- Discount Badge -->
                        <div
                            class="absolute left-2 top-2 discount-badge">
                            <?= round($percentage); ?>% OFF
                        </div>

                        <!-- Wishlist Button -->
                        <form method="POST" action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>" 
                          class="absolute top-1 right-3 z-10" onclick="event.stopPropagation();">
                        <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                        <button type="submit" name="toggle_wishlist" class="p-1.5 bg-white bg-opacity-80 rounded-full shadow-md hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                 fill="<?= $isWishlisted ? 'red' : 'none'; ?>" 
                                 stroke="red" stroke-width="1.5" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </form>

                        <!-- Book Click Redirect -->
                        <a href="view.php?book_id=<?= $bookId; ?>" class="block">
                            <div class="flex justify-center">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-28 h-40 sm:w-36 sm:h-52 object-cover shadow-md hover:shadow-xl rounded-md">
                            </div>

                            <!-- Book Info -->
                            <div class="mt-3 px-2">
                                <!-- Book Title -->
                                <h2
                                    class="text-sm sm:text-base font-bold text-gray-800 truncate hover:text-[#3D8D7A] transition-colors">
                                    <?= $book['book_name']; ?>
                                </h2>

                                <!-- Author and Category -->
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-xs text-gray-600 font-medium truncate max-w-[60%]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline mr-1 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <?= $book['book_author']; ?>
                                    </p>
                                    <span
                                        class="text-[10px] sm:text-xs bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">
                                        <?= $book['book_category']; ?>
                                    </span>
                                </div>

                                <!-- Price Section -->
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm sm:text-base font-bold text-[#3D8D7A] ">
                                            ₹<?= $book['sell_price']; ?>
                                        </span>
                                        <span class="text-xs text-gray-400 line-through">
                                            ₹<?= $book['mrp']; ?>
                                        </span>
                                    </div>
                                    <span
                                        class="text-[10px] sm:text-xs  text-green-500 sm:px-2 py-0.5 rounded-full">
                                        Save ₹<?= $book['mrp'] - $book['sell_price']; ?>
                                    </span>
                                </div>

                                <!-- Location and Time -->
                                <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-[#3D8D7A]"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span
                                            class="truncate max-w-[80px] sm:max-w-[100px]"><?= $address['city'] ?? 'Unknown'; ?></span>
                                    </div>

                                    <div class="flex items-center text-xs text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <?= $postedTime; ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Right Arrow -->
            <button id="scrollRight2"
                class="hidden sm:block absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8594;
            </button>
        </div>
    </div>
</section>

<!-- Scroll Button Functionality -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const scrollContainer2 = document.getElementById("bookScroll2");
        const scrollLeft2 = document.getElementById("scrollLeft2");
        const scrollRight2 = document.getElementById("scrollRight2");

        if (scrollContainer2 && scrollLeft2 && scrollRight2) {
            scrollLeft2.onclick = () => scrollContainer2.scrollBy({
                left: -300,
                behavior: 'smooth'
            });

            scrollRight2.onclick = () => scrollContainer2.scrollBy({
                left: 300,
                behavior: 'smooth'
            });
        }
    });
</script>