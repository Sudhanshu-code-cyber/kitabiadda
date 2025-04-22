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
    $search = trim($_GET['search_book']);
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
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Custom styles */
        .book-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
            padding: 0.5rem;
        }

        @media (min-width: 768px) {
            .book-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1.5rem;
                padding: 1rem;
            }
        }

        @media (min-width: 1024px) {
            .book-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
                gap: 1.5rem;
                padding: 1rem;
            }
        }

        .book-card {
            height: auto;
            min-height: 0;
            width: 100%;
        }

        .book-image {
            height: 160px;
            width: 100%;
            object-fit: cover;
        }

        @media (min-width: 640px) {
            .book-image {
                height: 200px;
            }
        }

        /* Mobile slider styles */
        .mobile-slider {
            display: none;
        }

        @media (max-width: 767px) {
            .mobile-slider {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1rem;
                padding: 0.5rem;
            }

            .desktop-grid {
                display: none;
            }
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
                <!-- Mobile View (2 books per row) -->
                <div class="mobile-slider">
                    <?php while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['book_id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);

                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);
                        $percentage = ($mrp > 0 && $sell_price > 0) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                    ?>
                        <div class="bg-white p-3 rounded-lg shadow-md border border-gray-200 hover:shadow-xl duration-300 relative">
                            <!-- Discount Badge -->
                            <div class="absolute left-2 top-2 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-md shadow-md">
                                <?= round($percentage); ?>% OFF
                            </div>

                            <!-- Wishlist Button -->
                            <form method="POST"
                                action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
                                class="absolute top-2 right-2" onclick="event.stopPropagation();">
                                <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                                <button type="submit" class="cursor-pointer" name="toggle_wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-5 hover:scale-110 transition">
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
                                <div class="mt-4">
                                    <h3 class="font-bold text-gray-800 text-sm sm:text-base truncate leading-tight">
                                        <?= $book['book_name']; ?>
                                    </h3>
                                    <p class="text-gray-600 text-xs sm:text-sm mt-1 truncate">
                                        <?= $book['book_author']; ?>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center space-x-2">
                                            <?php if ($mrp > $sell_price): ?>
                                                <span class="text-gray-400 text-xs line-through">₹<?= $mrp; ?></span>
                                            <?php endif; ?>
                                            <span class="text-[#3D8D7A] font-bold text-sm sm:text-base">₹<?= $sell_price; ?></span>
                                        </div>
                                        <span class="text-xs px-2 py-1 bg-gray-100 rounded-full"><?= $book['book_category']; ?></span>
                                    </div>
                                </div>
                            </a>

                            <!-- Add to Cart Button -->
                            <?php
                            $email = $_SESSION['user'] ?? null;
                            $cartItems = [];
                            if ($email) {
                                $callCartItem = mysqli_query($connect, "SELECT item_id FROM cart WHERE email='$email' AND direct_buy=0");
                                while ($item = mysqli_fetch_assoc($callCartItem)) {
                                    $cartItems[] = $item['item_id'];
                                }
                            }
                            $isInCart = in_array($book['id'], $cartItems);
                            ?>

                            <div class="mt-3 border-t border-gray-200 pt-2">
                                <?php if ($book['version'] == "new"): ?>
                                    <a href="<?= $isInCart ? 'cart.php' : 'cart.php?add_book=' . $book['id']; ?>"
                                        class="block group/cart">
                                        <button
                                            class="w-full flex items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                                            <div class="relative">
                                                <?php if ($isInCart): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 text-white group-hover/cart:-translate-y-1 transition-transform"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5l1.5 1.5 3-3" />
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <span><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a href="chatboard.php?book_id=<?= $book['id'] ?>" class="block">
                                        <button class="w-full flex items-center justify-center gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white text-xs font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Chat Seller
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Desktop View (5 books per row) -->
                <div class="desktop-grid book-grid">
                    <?php
                    $booksQuery->data_seek(0);
                    while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['book_id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);

                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);
                        $percentage = ($mrp > 0 && $sell_price > 0) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                    ?>
                        <div class="bg-white p-3 rounded-lg shadow-md border border-gray-200 hover:shadow-xl duration-300 relative">
                            <!-- Discount Badge -->
                            <div class="absolute left-2 top-2 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-md shadow-md">
                                <?= round($percentage); ?>% OFF
                            </div>

                            <!-- Wishlist Button -->
                            <form method="POST"
                                action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
                                class="absolute top-2 right-2" onclick="event.stopPropagation();">
                                <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                                <button type="submit" class="cursor-pointer" name="toggle_wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-5 hover:scale-110 transition">
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
                                <div class="mt-4">
                                    <h3 class="font-bold text-gray-800 text-sm sm:text-base truncate leading-tight">
                                        <?= $book['book_name']; ?>
                                    </h3>
                                    <p class="text-gray-600 text-xs sm:text-sm mt-1 truncate">
                                        <?= $book['book_author']; ?>
                                    </p>

                                    <div class="flex items-center justify-between mt-3">
                                        <div class="flex items-center space-x-2">
                                            <?php if ($mrp > $sell_price): ?>
                                                <span class="text-gray-400 text-xs line-through">₹<?= $mrp; ?></span>
                                            <?php endif; ?>
                                            <span class="text-[#3D8D7A] font-bold text-sm sm:text-base">₹<?= $sell_price; ?></span>
                                        </div>
                                        <span class="text-xs px-2 py-1 bg-gray-100 rounded-full"><?= $book['book_category']; ?></span>
                                    </div>
                                </div>
                            </a>

                            <!-- Add to Cart Button -->
                            <?php
                            $email = $_SESSION['user'] ?? null;
                            $cartItems = [];
                            if ($email) {
                                $callCartItem = mysqli_query($connect, "SELECT item_id FROM cart WHERE email='$email' AND direct_buy=0");
                                while ($item = mysqli_fetch_assoc($callCartItem)) {
                                    $cartItems[] = $item['item_id'];
                                }
                            }
                            $isInCart = in_array($book['id'], $cartItems);
                            ?>

                            <div class="mt-3 border-t border-gray-200 pt-2">
                                <?php if ($book['version'] == "new"): ?>
                                    <a href="<?= $isInCart ? 'cart.php' : 'cart.php?add_book=' . $book['id']; ?>"
                                        class="block group/cart">
                                        <button
                                            class="w-full flex items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                                            <div class="relative">
                                                <?php if ($isInCart): ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="w-4 h-4 text-white group-hover/cart:-translate-y-1 transition-transform"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5l1.5 1.5 3-3" />
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <span><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>
                                        </button>
                                    </a>
                                <?php else: ?>
                                    <a href="chatboard.php?book_id=<?= $book['id'] ?>" class="block">
                                        <button class="w-full flex items-center justify-center gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white text-xs font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            </svg>
                                            Chat Seller
                                        </button>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
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
</body>

</html>