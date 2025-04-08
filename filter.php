<?php
include_once "config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null;

// Wishlist Toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist1'])) {
    if ($userId) {
        $bookId = $_POST['wishlist_id1'];
        $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        if ($check->num_rows > 0) {
            $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        } else {
            $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
        }
        redirect("filter.php");
        exit();
    } else {
        redirect("login.php");
        exit();
    }
}

// Base query
$sql = "SELECT books.*, books.id AS book_id, category.cat_title 
        FROM books 
        JOIN category ON books.book_category = category.cat_title 
        WHERE 1";

// Filter: Category
if (!empty($_GET['filter'])) {
    $cat_title = mysqli_real_escape_string($connect, $_GET['filter']);
    $sql .= " AND book_category = '$cat_title'";
}

// Filter: Search
if (!empty($_GET['search_book'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search_book']);
    if (strlen($search) < 1) {
        message("Please enter a search term.");
        redirect("filter.php");
    }

    $sql .= " AND (
        LOWER(book_name) LIKE LOWER('%$search%') OR 
        LOWER(book_author) LIKE LOWER('%$search%') OR 
        LOWER(book_category) LIKE LOWER('%$search%') OR 
        LOWER(version) LIKE LOWER('%$search%') OR 
        LOWER(isbn) LIKE LOWER('%$search%')
    )";
}

$booksQuery = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Used Books</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Custom styles */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }

        @media (min-width: 640px) {
            .book-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1rem;
            }
        }

        @media (min-width: 768px) {
            .book-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .book-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 1.5rem;
            }
        }

        .book-card {
            height: auto;
            min-height: 0;
        }

        .book-image {
            height: 160px;
        }

        @media (min-width: 640px) {
            .book-image {
                height: 200px;
            }
        }

        /* Mobile slider styles */
        .slider-container {
            display: none;
        }

        @media (max-width: 639px) {
            .slider-container {
                display: flex;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-behavior: smooth;
                gap: 0.75rem;
                padding: 0.5rem 1rem;
                margin: 0 -1rem;
            }

            .slider-container .book-card {
                scroll-snap-align: start;
                flex: 0 0 calc(50% - 0.5rem);
                min-width: calc(50% - 0.5rem);
            }

            .book-grid {
                display: none;
            }
        }

        /* Hide scrollbar but keep functionality */
        .slider-container::-webkit-scrollbar {
            display: none;
        }

        .slider-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#FBFFE4] text-gray-800 font-sans">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="flex flex-col mt-32 gap-4 sm:p-4">
        <?php if (isset($_GET['filter']) && !isset($_GET['hide'])): ?>
            <div class="flex justify-center items-center mb-3">
                <h2 class="text-lg sm:text-xl md:text-2xl font-serif py-1 px-4 sm:py-2 sm:px-6 rounded-md bg-[#3D8D7A] font-bold text-white">
                    <?= htmlspecialchars($_GET['filter']); ?>
                </h2>
            </div>
        <?php endif; ?>

        <div class="flex-1">
            <?php if ($booksQuery->num_rows > 0): ?>
                <!-- Mobile Slider (shows only on mobile) -->
                <div class="slider-container md:hidden">
                    <?php while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['book_id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);

                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);
                        $percentage = ($mrp > 0 && $sell_price > 0) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                    ?>
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

                            // Step 2: Inside your book loop, check if it's in the cart
                            $isInCart = in_array($book['id'], $cartItems);
                            ?>

                            <a href="<?= $isInCart ? 'cart.php' : 'cart.php?add_book=' . $book['id']; ?>"
                                class="block group/cart">
                                <div class="mt-3 sm:mt-4 border-t border-gray-200 pt-2 sm:pt-3">
                                    <button
                                        class="w-full flex items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs sm:text-sm font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95">

                                        <!-- Icon -->
                                        <div class="relative">
                                            <?php if ($isInCart): ?>
                                                <!-- Tick Icon for "Go to Cart" -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            <?php else: ?>
                                                <!-- Cart Icon for "Add to Cart" -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 text-white group-hover/cart:-translate-y-1 transition-transform"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <!-- Cart base -->
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
                                                    <!-- Check mark -->
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5l1.5 1.5 3-3" />
                                                </svg>


                                            <?php endif; ?>

                                        </div>

                                        <span class="cursor-pointer   "><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>


                                        <!-- Optional plus icon -->
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
                            </a>

                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Desktop Grid (shows on tablet/desktop) -->
                <main class="book-grid hidden md:grid">
                    <?php
                    // Reset pointer to loop through results again
                    $booksQuery->data_seek(0);
                    while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['book_id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);

                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);
                        $percentage = ($mrp > 0 && $sell_price > 0) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                    ?>
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

                            // Step 2: Inside your book loop, check if it's in the cart
                            $isInCart = in_array($book['id'], $cartItems);
                            ?>

                            <a href="<?= $isInCart ? 'cart.php' : 'cart.php?add_book=' . $book['id']; ?>"
                                class="block group/cart">
                                <div class="mt-3 sm:mt-4 border-t border-gray-200 pt-2 sm:pt-3">
                                    <button
                                        class="w-full flex items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs sm:text-sm font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95">

                                        <!-- Icon -->
                                        <div class="relative">
                                            <?php if ($isInCart): ?>
                                                <!-- Tick Icon for "Go to Cart" -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                            <?php else: ?>
                                                <!-- Cart Icon for "Add to Cart" -->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 text-white group-hover/cart:-translate-y-1 transition-transform"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <!-- Cart base -->
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
                                                    <!-- Check mark -->
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5l1.5 1.5 3-3" />
                                                </svg>


                                            <?php endif; ?>

                                        </div>

                                        <span class="cursor-pointer   "><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>


                                        <!-- Optional plus icon -->
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
                            </a>

                        </div>
                    <?php endwhile; ?>
                </main>
            <?php else: ?>
                <div class="flex justify-center items-center h-[60vh]">
                    <div class="text-center">
                        <h2 class="text-xl md:text-2xl font-bold text-red-500 mb-4">😕 Oops! No books found for the selected filters.</h2>
                        <a href="filter.php" class="bg-[#3D8D7A] text-white px-4 py-2 rounded-md hover:bg-[#2c6b5b] transition">Browse All Books</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once "includes/footer2.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        // Enhanced touch slider for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.querySelector('.slider-container');
            if (!slider) return;

            let isDown = false;
            let startX;
            let scrollLeft;
            let velocity = 0;
            let animationFrame;
            let lastTime = 0;
            const deceleration = 0.95;
            const minVelocity = 0.1;

            // Mouse events
            slider.addEventListener('mousedown', (e) => {
                isDown = true;
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
                cancelAnimationFrame(animationFrame);
            });

            slider.addEventListener('mouseleave', () => {
                isDown = false;
                startInertia();
            });

            slider.addEventListener('mouseup', () => {
                isDown = false;
                startInertia();
            });

            slider.addEventListener('mousemove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 2;
                slider.scrollLeft = scrollLeft - walk;
                velocity = walk;
            });

            // Touch events
            slider.addEventListener('touchstart', (e) => {
                isDown = true;
                startX = e.touches[0].pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
                cancelAnimationFrame(animationFrame);
                velocity = 0;
            });

            slider.addEventListener('touchend', () => {
                isDown = false;
                startInertia();
            });

            slider.addEventListener('touchmove', (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.touches[0].pageX - slider.offsetLeft;
                const walk = (x - startX) * 2;
                slider.scrollLeft = scrollLeft - walk;
                velocity = walk;
            });

            // Inertia effect
            function startInertia() {
                lastTime = performance.now();
                animationFrame = requestAnimationFrame(inertia);
            }

            function inertia(currentTime) {
                const deltaTime = currentTime - lastTime;
                lastTime = currentTime;

                if (Math.abs(velocity) > minVelocity) {
                    slider.scrollLeft -= velocity;
                    velocity *= deceleration;
                    animationFrame = requestAnimationFrame(inertia);
                }
            }
        });
    </script>
</body>

</html>