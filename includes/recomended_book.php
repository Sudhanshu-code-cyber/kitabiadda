<section class="bg-white  py-10">
    <div class=" w-full px-[5%]  mx-auto ">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Recomended Books</h2>
            <a href="#" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <!-- Carousel Container -->
        <div class="relative ">

            <!-- Left Arrow -->
            <button id="scrollLeft"
                class="absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8592;
            </button>

            <!-- Scrollable Book Cards -->
            <div id="bookScroll" class="flex no-scrollbar space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">

                <!-- Book Card -->


                <?php
                $book_category = $book['book_category'];
                // recomended book query
                $booksQuery = $connect->query("SELECT * FROM books WHERE book_category='$book_category' and id != '$book_id'");
                while ($book = $booksQuery->fetch_assoc()):
                    // Check if the book is already in the wishlist
                    $bookId = $book['id'];
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);

                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);

                    if ($mrp > 0 && is_numeric($sell_price)) {
                        $percentage = ($mrp - $sell_price) / $mrp * 100;

                    } else {
                        echo "Error: Invalid price values.";
                    }
                    ?>
                    <div
                        class="bg-white p-4 rounded-lg  transition shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                        <!-- Discount Badge (60% Off) -->


                        <div
                            class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                            <?= round($percentage); ?>% OFF
                        </div>

                        <div class=" px-3 ">
                            <!-- Wishlist Heart Icon (Prevents Click from Going to Next Page) -->
                            <form method="POST" action="" class="absolute top-3 right-3" onclick="event.stopPropagation();">
                                <input type="hidden" name="wishlist_id2" value="<?= $bookId; ?>">
                                <button type="submit" class="cursor-pointer" name="toggle_wishlist2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-6 hover:scale-110 transition">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        <!-- Book Click Redirect -->
                        <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                            <div class="flex justify-center    ">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-40  h-56 object-cover hover:scale-105 transition shadow-md rounded-md">
                            </div>

                            <!-- Book Info -->
                            <div class="mt-4 text-center">
                                <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?>
                                </h2>
                                <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?>
                                    <span class="text-sm text-orange-400 ml-2"><?= $book['book_category']; ?></span>

                                </p>

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
                                <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to
                                    cart</button>

                                <!-- Dynamic Rating -->
                                <div class="flex">
                                    <?php
                                    $rating = $book['book_rating']; // Random Rating for demo
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $rating) {
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

                <!-- Book Card 2 -->


            </div>

            <!-- Right Arrow -->
            <button id="scrollRight"
                class="absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8594;
            </button>
        </div>
    </div>
</section>