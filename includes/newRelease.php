<?php
include_once "config/connect.php";

// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null; // Get logged-in user ID

// Fetch books
$booksQuery = $connect->query("SELECT * FROM books WHERE version='new' order by id DESC");

?>

<section class="py-10 ">
    <div class="w-full px-[2%] mx-auto ">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">New Book</h2>
            <a href="booksets1.php?bookType=new" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <!-- Carousel Container -->
        <div class="relative">

            <!-- Left Arrow (Hidden on mobile) -->
            <button id="scrollLeft"
                class="absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 hidden md:block">
                &#8592;
            </button>

            <!-- Scrollable Book Cards -->
            <div id="bookScroll" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">

                <?php while ($book = $booksQuery->fetch_assoc()):
                    // Get book details
                    $bookId = $book['id'];

                    // Check if the book is already in the wishlist
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);

                    // Discount calculation
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $percentage = ($mrp > 0 && is_numeric($sell_price)) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                    ?>

                    <!-- Book Card -->
                    <div
                        class="bg-white p-3 rounded-lg shadow-md border border-gray-200 w-40 sm:w-60 min-w-[10rem] sm:min-w-[14rem] relative hover:shadow-xl duration-300 ">
                        <!-- Discount Badge (Smaller on Mobile) -->
                        <div
                            class="absolute left-2 top-2 bg-red-500 text-white px-1.5 sm:px-3 py-0.5 sm:py-1 text-[10px] sm:text-xs font-bold rounded-md shadow-md">
                            <?= round($percentage); ?>% OFF
                        </div>

                        <!-- Wishlist Button (Compact on Mobile) -->
                        <form method="POST"
                            action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
                            class="absolute top-2.5 sm:top-3 right-2 sm:right-3" onclick="event.stopPropagation();">
                            <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                            <button type="submit" class="cursor-pointer" name="toggle_wishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                    class="size-4 sm:size-6 hover:scale-110 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </button>
                        </form>

                        <!-- Book Click Redirect -->
                        <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                            <div class="flex justify-center">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-28 h-40 sm:w-36 sm:h-52 object-cover hover:shadow-xl rounded-md">
                            </div>

                            <!-- Book Info -->
                            <div class="mt-2 sm:mt-3 text-strat">
                                <h2 class="text-xs sm:text-base font-semibold truncate text-[#3D8D7A]">
                                    <?= $book['book_name']; ?>
                                </h2>
                                <div class="flex mt-1 justify-between  text-gray-500 text-[10px] sm:text-xs font-semibold">
                                    <p class="text-gray-500 text-sm font-semibold truncate w-30">
                                        <?= $book['book_author']; ?>

                                    </p>
                                    <span class="text-sm text-orange-400 "><?= $book['book_category']; ?></span>

                                </div>


                                <!-- Price -->
                                <div class="flex justify-center items-center space-x-1 sm:space-x-2 mt-1">
                                    <p class="text-gray-500 line-through text-[10px] sm:text-xs">₹<?= $book['mrp']; ?>/-</p>
                                    <p class="text-black font-bold text-sm sm:text-lg">₹<?= $book['sell_price']; ?>/-</p>
                                </div>


                            </div>
                        </a>

                        <!-- Footer (Add to Cart + Rating) -->
                        <?php
                        $email = $_SESSION['user'] ?? null;

                        // Step 1: Fetch all cart items for the user
                        $cartItems = [];
                        $callCartItem = mysqli_query($connect, "SELECT item_id FROM cart WHERE email='$email' AND direct_buy=0");
                        while ($item = mysqli_fetch_assoc($callCartItem)) {
                            $cartItems[] = $item['item_id'];
                        }

                        // Step 2: Check if this book is in the cart
                        $isInCart = in_array($book['id'], $cartItems);
                        ?>

                        <div class="block  group/cart">
                            <div class="mt-3  sm:mt-4 border-t border-gray-200 pt-2 sm:pt-3">
                                <button
                                    class="w-full flex cursor-pointer items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs sm:text-sm font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95"
                                    onclick="<?= $isInCart ? "window.location.href='cart.php'" : "addToCart(" . $book['id'] . ")"; ?>">

                                    <!-- Icon -->
                                    <div class="relative">
                                        <?php if ($isInCart): ?>
                                            <!-- Tick Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        <?php else: ?>
                                            <!-- Cart Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-white group-hover/cart:-translate-y-1 transition-transform"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5l1.5 1.5 3-3" />
                                            </svg>
                                        <?php endif; ?>
                                    </div>

                                    <span class=""><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>

                                    <?php if (!$isInCart): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4 opacity-0 group-hover/cart:opacity-100 transition-opacity duration-200"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    <?php endif; ?>
                                </button>

                            </div>
                        </div>

                        <script>
                            function addToCart(bookId) {
                                fetch(`cart.php?add_book=${bookId}`)
                                    .then(response => response.text())
                                    .then(data => {
                                        // You can log or check response here if needed
                                        window.location.href = 'cart.php'; // Redirect after adding
                                    })
                                    .catch(error => {
                                        console.error('Error adding to cart:', error);
                                    });
                            }
                        </script>



                    </div>


                <?php endwhile; ?>
            </div>

            <!-- Right Arrow (Hidden on mobile) -->
            <button id="scrollRight"
                class="absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 hidden md:block">
                &#8594;
            </button>
        </div>
    </div>
</section>

<!-- Scroll Script -->
<script>
    const scrollContainer = document.getElementById("bookScroll");
    const leftButton = document.getElementById("scrollLeft");
    const rightButton = document.getElementById("scrollRight");

    document.getElementById("scrollLeft").onclick = () => scrollContainer.scrollBy({
        left: -300,
        behavior: 'smooth'
    });

    document.getElementById("scrollRight").onclick = () => scrollContainer.scrollBy({
        left: 300,
        behavior: 'smooth'
    });

    // Hide navigation buttons on mobile
    function handleResize() {
        if (window.innerWidth < 768) {
            leftButton.classList.add("hidden");
            rightButton.classList.add("hidden");
        } else {
            leftButton.classList.remove("hidden");
            rightButton.classList.remove("hidden");
        }
    }

    window.addEventListener("resize", handleResize);
    document.addEventListener("DOMContentLoaded", handleResize);
</script>