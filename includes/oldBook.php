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
                <button id="scrollLeft" class="absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
                    &#8592;
                </button>

                <!-- Scrollable Book Cards -->
                <div id="bookScroll" class="flex space-x-4 overflow-x-auto scroll-smooth px-10 pb-4">

                    <!-- Book Card -->
              
<?php
                $callNewBook = $connect->query("select * from books where version='old'");
                while ($book = $callNewBook->fetch_array()) {
                

                ?>
                <a href="view2.php?book_id=<?= $book['id']; ?>">

                    <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                        <!-- Discount Badge (60% Off) -->
                        <div
                            class="absolute top-2 left-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                            60% OFF
                        </div>

                        <!-- Book Image (Clickable Link) -->
                        <div class="flex justify-center">
                            <button target="_blank">
                                <img src="assets/sell_images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-40 h-56 object-cover shadow-md rounded-md hover:scale-105 transition">
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
                            <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>

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
                </a>
                <?php
                }
                ?>

                    <!-- Book Card 2 -->
                  

                </div>

                <!-- Right Arrow -->
                <button id="scrollRight" class="absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border rounded-full shadow p-2 hover:bg-gray-100">
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




