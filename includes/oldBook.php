<!-- Book Sets Section -->
<section class="bg-white  py-10">
    <div class=" w-full px-[5%]  mx-auto px-4">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Old Book</h2>
            <a href="#" class="text-orange-500 font-semibold hover:underline">View All</a>
        </div>

        <!-- Carousel Container -->
        <div class="relative">

            <!-- Left Arrow -->
            <button id="scrollLeft"
                class="absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                &#8592;
            </button>

            <!-- Scrollable Book Cards -->
            <div id="bookScroll" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">

                <!-- Book Card -->

                <?php
                $callNewBook = $connect->query("select * from books where version='old'");
                while ($book = $callNewBook->fetch_array()) {


                    ?>
                   

                        <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                            <!-- Discount Badge (60% Off) -->


                            <!-- Book Image (Clickable Link) -->
                            <div class="flex relative justify-center hover:scale-105 transition">
                                <div
                                    class="absolute  left-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">

                                    60% OFF
                                </div>
                                <p class="absolute right-10 bg-white rounded-full -mr-5 p-1 cursor-pointer wishlist-btn"
                                    data-book-id="<?= $book['id']; ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="font-bold text-[#3D8D7A] size-6 transition hover:text-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </p>

                                <button target="_blank">
                                    <img src="assets/sell_images/<?= $book['img1']; ?>" alt="Book Cover"
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
                  
                    <?php
                }
                ?>

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

<!-- Scroll Script -->
<script>
    const scrollContainer = document.getElementById("bookScroll");
    document.getElementById("scrollLeft").onclick = () => scrollContainer.scrollBy({
        left: -300,
        behavior: 'smooth'
    });
    document.getElementById("scrollRight").onclick = () => scrollContainer.scrollBy({
        left: 300,
        behavior: 'smooth'
    });
</script>



</script>