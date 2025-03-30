<div id="wishlist" class="content-section ">
        <h2 class="text-2xl font-semibold mb-4">My Wishlist</h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            <?php
            while ($book = $booksQuery->fetch_assoc()):
                // Check if the book is already in the wishlist
                $bookId = $book['id'];
                $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                $isWishlisted = ($checkWishlist->num_rows > 0);

                $mrp = floatval($book['mrp']);
                $sell_price = floatval($book['sell_price']);
                $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                ?>
                <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-full max-w-xs mx-auto relative">
                    <!-- Discount Badge -->
                    <div class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                        <?= $discount; ?>% OFF
                    </div>

                    <!-- Wishlist Heart Icon -->
                    <form method="POST" action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
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
                            <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                class="w-40 h-56 object-cover shadow-md rounded-md">
                        </div>

                        <!-- Book Info -->
                        <div class="mt-4 text-center">
                            <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"> <?= $book['book_name']; ?> </h2>
                            <p class="text-gray-500 text-sm font-semibold"> <?= $book['book_author']; ?> </p>

                            <!-- Price -->
                            <div class="flex justify-center items-center space-x-2 mt-1">
                                <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                            </div>
                        </div>
                    </a>

                    <!-- Footer (Add to Cart + Rating) -->
                    <a href="cart.php?add_book=<?= $book['id']; ?>">
                        <div class="mt-4 border-t pt-3 flex justify-between items-center">
                            <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>
                            <div class="flex">
                                <?php
                                $rating = rand(2, 5);
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
    </div>