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
$booksQuery = $connect->query("SELECT * FROM bookset  ORDER BY id DESC");
?>

<section class="py-10">
    <div class="w-full mx-auto px-[2%]">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold"> Book Set</h2>
            <a href="booksets1.php?bookType=old" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <div class="relative">
            <!-- Left Arrow -->
            <button id="scrollLeft2"
                class="hidden sm:block absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8592;
            </button>

            <div id="bookScroll2" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">
                <?php while ($book = $booksQuery->fetch_assoc()):
                    $bookId = $book['id'];


                    ?>
                    <div
                        class="bg-white p-3 rounded-lg shadow-lg border border-gray-200 w-40 sm:w-60 min-w-[10rem] sm:min-w-[14rem] relative hover:shadow-xl">

                        <!-- Discount Badge -->


                        <!-- Wishlist Button -->


                        <!-- Book Click Redirect -->
                        <a href="bookset_view.php?bookset_id=<?= $bookId; ?>" class="block">
                            <div class="flex justify-center">
                                <img src="assets/images/<?= $book['set_img']; ?>" alt="Book Cover"
                                    class="w-28 h-40 sm:w-36 sm:h-52 object-cover shadow-md hover:shadow-xl rounded-md">

                            </div>

                            <!-- Book Info -->
                            <div class="mt-2 sm:mt-3 text-center">
                                <h2 class="text-xs sm:text-base font-semibold truncate text-[#3D8D7A]">
                                    <?= $book['set_title']; ?>
                                </h2>


                                <!-- Price -->
                                <div class="flex justify-center items-center space-x-1 sm:space-x-2 mt-1">

                                    <p class="text-black font-bold text-sm sm:text-lg">₹<?= $book['price']; ?>/-</p>
                                </div>

                                <div class="flex justify-between items-center mt-2 text-sm text-gray-600">
                                    <!-- Location -->
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#3D8D7A]" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 11c1.1046 0 2-.8954 2-2s-.8954-2-2-2-2 .8954-2 2 .8954 2 2 2z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 2C8.13401 2 5 5.13401 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.86599-3.134-7-7-7z" />
                                        </svg>
                                        <span class="text-xs font-medium"><?= $address['city'] ?? 'Unknown'; ?></span>
                                    </div>

                                    <!-- Posted Time -->
                                    <p class="text-xs text-gray-400"><?= $postedTime; ?></p>
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