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
    <script src="https://cdn.tailwindcss.com"></script>
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

    <div class="flex flex-col mt-32 gap-4 p-3 sm:p-4">
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
                        <div class="book-card bg-white p-3 rounded-lg shadow-md border border-gray-200 relative">
                            <?php if ($percentage > 0): ?>
                                <div class="absolute left-2 top-2 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded shadow">
                                    <?= $percentage; ?>% OFF
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="" class="absolute top-2 right-2">
                                <input type="hidden" name="wishlist_id1" value="<?= $bookId; ?>">
                                <button type="submit" name="toggle_wishlist1" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-5 hover:scale-110 transition">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="view.php?book_id=<?= $bookId; ?>" class="block h-full">
                                <div class="flex justify-center">
                                    <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover" class="book-image w-auto object-contain">
                                </div>

                                <div class="mt-2 text-center px-1">
                                    <h2 class="text-sm font-semibold line-clamp-2 text-[#3D8D7A] h-10 overflow-hidden">
                                        <?= $book['book_name']; ?>
                                    </h2>
                                    <p class="text-gray-500 text-xs truncate"><?= $book['book_author']; ?></p>
                                    <p class="text-orange-400 text-xs mt-1"><?= $book['book_category']; ?></p>

                                    <div class="flex justify-center items-center space-x-1 mt-1">
                                        <?php if ($mrp > 0): ?>
                                            <p class="text-gray-500 line-through text-xs">₹<?= $book['mrp']; ?></p>
                                        <?php endif; ?>
                                        <p class="text-black font-bold text-sm">₹<?= $book['sell_price']; ?></p>
                                    </div>
                                </div>

                                <div class="mt-2 border-t pt-2 flex justify-between items-center px-1">
                                    <button class="text-[#27445D] text-xs hover:underline">Add to cart</button>
                                    <div class="flex">
                                        <?php
                                        $rating = rand(2, 5);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo '<span class="' . ($i <= $rating ? 'text-orange-500' : 'text-gray-400') . ' text-xs">★</span>';
                                        }
                                        ?>
                                    </div>
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
                        <div class="book-card bg-white p-3 sm:p-4 rounded-lg shadow-lg border border-gray-200 relative">
                            <?php if ($percentage > 0): ?>
                                <div class="absolute left-2 top-2 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded shadow">
                                    <?= $percentage; ?>% OFF
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="" class="absolute top-3 right-3">
                                <input type="hidden" name="wishlist_id1" value="<?= $bookId; ?>">
                                <button type="submit" name="toggle_wishlist1" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-6 hover:scale-110 transition">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>

                            <a href="view.php?book_id=<?= $bookId; ?>" class="block h-full">
                                <div class="flex justify-center hover:scale-105 transition">
                                    <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover" class="book-image w-auto object-contain">
                                </div>

                                <div class="mt-3 text-center">
                                    <h2 class="text-sm md:text-base font-semibold line-clamp-2 text-[#3D8D7A] h-12 md:h-14 overflow-hidden">
                                        <?= $book['book_name']; ?>
                                    </h2>
                                    <p class="text-gray-500 text-xs md:text-sm truncate"><?= $book['book_author']; ?></p>
                                    <p class="text-orange-400 text-xs md:text-sm mt-1"><?= $book['book_category']; ?></p>

                                    <div class="flex justify-center items-center space-x-2 mt-2">
                                        <?php if ($mrp > 0): ?>
                                            <p class="text-gray-500 line-through text-xs md:text-sm">₹<?= $book['mrp']; ?></p>
                                        <?php endif; ?>
                                        <p class="text-black font-bold text-sm md:text-base">₹<?= $book['sell_price']; ?></p>
                                    </div>
                                </div>

                                <div class="mt-3 border-t pt-2 flex justify-between items-center">
                                    <button class="text-[#27445D] text-xs md:text-sm hover:underline">Add to cart</button>
                                    <div class="flex">
                                        <?php
                                        $rating = rand(2, 5);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo '<span class="' . ($i <= $rating ? 'text-orange-500' : 'text-gray-400') . ' text-sm md:text-base">★</span>';
                                        }
                                        ?>
                                    </div>
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