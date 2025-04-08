<div class="px-5 py-5">
    <section class="bg-white py-10 rounded-lg shadow-lg">
        <?php
        include_once "config/connect.php";

        $user = isset($_SESSION['user']) ? getUser() : null;
        $userId = $user['user_id'] ?? null;
        $email = $_SESSION['user'] ?? null;

        // Assuming $book_id is passed to the page (e.g., view.php?book_id=5)
        $book_id = $_GET['book_id'] ?? null;
        $bookQuery = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
        $bookInfo = $bookQuery->fetch_assoc();
        $book_category = $bookInfo['book_category'] ?? '';

        // Fetch related books
        $booksQuery = $connect->query("SELECT * FROM books WHERE book_category='$book_category' AND version='new' AND id != '$book_id'");

        // Fetch wishlist items
        $wishlistItems = [];
        if ($userId) {
            $wishlistQuery = $connect->query("SELECT book_id FROM wishlist WHERE user_id = '$userId'");
            while ($wish = $wishlistQuery->fetch_assoc()) {
                $wishlistItems[] = $wish['book_id'];
            }
        }

        // Fetch cart items
        $cartItems = [];
        $cartQuery = $connect->query("SELECT item_id FROM cart WHERE email='$email' AND direct_buy=0");
        while ($item = $cartQuery->fetch_assoc()) {
            $cartItems[] = $item['item_id'];
        }
        ?>

        <div class="w-full px-5 mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Recommended Books</h2>
            </div>

            <div class="relative">
                <button id="scrollLeft"
                    class="absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 hidden md:block">
                    &#8592;
                </button>

                <div id="bookScroll" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">
                    <?php while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['id'];
                        $isWishlisted = in_array($bookId, $wishlistItems);
                        $isInCart = in_array($bookId, $cartItems);

                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);
                        $percentage = ($mrp > 0 && is_numeric($sell_price)) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                        ?>

                        <div
                            class="bg-white p-3 rounded-lg shadow-md border border-gray-200 w-40 sm:w-60 min-w-[10rem] sm:min-w-[14rem] relative hover:shadow-xl">
                            <div
                                class="absolute left-2 top-2 bg-red-500 text-white px-1.5 sm:px-3 py-0.5 sm:py-1 text-[10px] sm:text-xs font-bold rounded-md shadow-md">
                                <?= $percentage; ?>% OFF
                            </div>

                            <form method="POST" action="view.php?book_id=<?= $book_id ?>" class="absolute top-2.5 right-2">
                                <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                                <input type="hidden" name="toggle_wishlist" value="1">
                                <button type="submit" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-4 sm:size-6 hover:scale-110 transition">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="view.php?book_id=<?= $bookId; ?>" class="block">
                                <div class="flex justify-center">
                                    <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                        class="w-28 h-40 sm:w-36 sm:h-52 object-cover shadow-md hover:shadow-xl rounded-md">
                                </div>
                                <div class="mt-2 sm:mt-3 text-center">
                                    <h2 class="text-xs sm:text-base font-semibold truncate text-[#3D8D7A]">
                                        <?= $book['book_name']; ?>
                                    </h2>
                                    <div
                                        class="flex mt-1 justify-between  text-gray-500 text-[10px] sm:text-xs font-semibold">
                                        <p class="text-gray-500 text-sm font-semibold truncate w-30">
                                            <?= $book['book_author']; ?>

                                        </p>
                                        <span class="text-sm text-orange-400 "><?= $book['book_category']; ?></span>

                                    </div>
                                    <div class="flex justify-center items-center space-x-1 sm:space-x-2 mt-1">
                                        <p class="text-gray-500 line-through text-[10px] sm:text-xs">
                                            ₹<?= $book['mrp']; ?>/-
                                        </p>
                                        <p class="text-black font-bold text-sm sm:text-lg">
                                            ₹<?= $book['sell_price']; ?>/-
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <div class="block group/cart">
                                <div class="mt-3 sm:mt-4 border-t border-gray-200 pt-2 sm:pt-3">
                                    <button
                                        onclick="<?= $isInCart ? "window.location.href='cart.php'" : "addToCartAndRedirect($bookId)"; ?>"
                                        class="w-full flex items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs sm:text-sm font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95">

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
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 9.5l1.5 1.5 3-3" />
                                                </svg>
                                            <?php endif; ?>
                                        </div>

                                        <span><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>
                                    </button>
                                </div>
                                <script>
                                    function addToCartAndRedirect(bookId) {
                                        // Optional: show loading spinner here
                                        fetch(`cart.php?add_book=${bookId}`)
                                            .then(response => response.text())
                                            .then(() => {
                                                // Redirect after successful addition
                                                window.location.href = 'cart.php';
                                            })
                                            .catch(error => {
                                                console.error('Error adding to cart:', error);
                                                alert('Failed to add to cart.');
                                            });
                                    }
                                </script>


                            </div>

                        </div>
                    <?php endwhile; ?>
                </div>

                <button id="scrollRight"
                    class="absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100 hidden md:block">
                    &#8594;
                </button>
            </div>
        </div>

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
    </section>
</div>