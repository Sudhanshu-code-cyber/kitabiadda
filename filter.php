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

// Filter: Price Range
if (!empty($_GET['price'])) {
    $priceConditions = [];
    foreach ($_GET['price'] as $range) {
        if ($range === '3000 above') {
            $priceConditions[] = "(sell_price > 3000)";
        } else {
            [$min, $max] = explode('-', $range);
            $priceConditions[] = "(sell_price BETWEEN " . (int)$min . " AND " . (int)$max . ")";
        }
    }
    $sql .= " AND (" . implode(" OR ", $priceConditions) . ")";
}

// Filter: Language
if (!empty($_GET['language'])) {
    $langs = array_map(function ($lang) use ($connect) {
        return "'" . mysqli_real_escape_string($connect, $lang) . "'";
    }, $_GET['language']);
    $sql .= " AND language IN (" . implode(", ", $langs) . ")";
}

// Filter: Search
if (!empty($_GET['search_book'])) {
    $search = mysqli_real_escape_string($connect, $_GET['search_book']);
    $sql .= " AND (book_name LIKE '%$search%' OR book_author LIKE '%$search%' OR book_category LIKE '%$search%' OR isbn LIKE '%$search%')";
}

$booksQuery = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Used Books</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="flex mt-30 flex-col lg:flex-row gap-6 p-4">
        <!-- Sidebar Filters -->
        <div class="w-[50vh] max-w-md">
            <form method="GET" class="bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                <h2 class="text-2xl font-semibold mb-4 text-gray-800">Filters</h2>
                <p class="text-xl text-gray-500 mb-4">Add filters for more accurate results</p>

                <!-- Price Filter -->
                <div class="mb-6">
                    <h3 class="text-xl font-medium text-gray-700 mb-3">Price</h3>
                    <?php
                    $prices = ['0-100', '101-200', '200-400', '400-1000', '1000-3000', '3000 above'];
                    foreach ($prices as $price):
                        $checked = (isset($_GET['price']) && in_array($price, $_GET['price'])) ? 'checked' : '';
                    ?>
                        <label class="flex items-center space-x-2 text-sm text-gray-600 mb-2 cursor-pointer">
                            <input type="checkbox" name="price[]" value="<?= $price ?>" <?= $checked ?> class="text-blue-600 w-4 h-4 rounded" />
                            <span><?= $price ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Language Filter -->
                <div class="mb-6">
                    <h3 class="text-xl font-medium text-gray-700 mb-3">Language</h3>
                    <?php
                    $languages = ['English', 'Italian', 'Vietnamese', 'Hindi'];
                    foreach ($languages as $lang):
                        $checked = (isset($_GET['language']) && in_array($lang, $_GET['language'])) ? 'checked' : '';
                    ?>
                        <label class="flex items-center space-x-2 text-sm text-gray-600 mb-2 cursor-pointer">
                            <input type="checkbox" name="language[]" value="<?= $lang ?>" <?= $checked ?> class="text-green-600 w-4 h-4 rounded" />
                            <span><?= $lang ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Keep category filter in form -->
                <?php if (isset($_GET['filter'])): ?>
                    <input type="hidden" name="filter" value="<?= htmlspecialchars($_GET['filter']); ?>">
                <?php endif; ?>

                <!-- Keep search in form -->
                <?php if (isset($_GET['search_book'])): ?>
                    <input type="hidden" name="search_book" value="<?= htmlspecialchars($_GET['search_book']); ?>">
                <?php endif; ?>

                <button type="submit" class="mt-4 flex w-full bg-blue-500 py-2 px-4 rounded text-white font-semibold items-center justify-center">
                    Apply Filter
                </button>
            </form>
        </div>

        <!-- Main Book List -->
        <div class="flex-1">
            <?php if ($booksQuery->num_rows > 0): ?>
                <main class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php while ($book = $booksQuery->fetch_assoc()):
                        $bookId = $book['book_id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);
                    ?>
                        <div class="bg-white p-4 rounded-lg shadow-lg h-[60vh] border border-gray-200 w-full relative">
                            <div class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">60% OFF</div>

                            <!-- Wishlist Button -->
                            <form method="POST" action="" class="absolute top-3 right-3" onclick="event.stopPropagation();">
                                <input type="hidden" name="wishlist_id1" value="<?= $bookId; ?>">
                                <button type="submit" name="toggle_wishlist1">
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
                                    <img src="images/<?= $book['img1']; ?>" alt="Book Cover" class="w-40 h-56 object-cover shadow-md rounded-md">
                                </div>

                                <div class="mt-4 text-center">
                                    <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                                    <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?>
                                        <span class="text-sm text-orange-400 ml-2"><?= $book['book_category']; ?></span>
                                    </p>

                                    <div class="flex justify-center items-center space-x-2 mt-1">
                                        <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                        <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                                    </div>
                                </div>

                                <div class="mt-4 border-t pt-3 flex justify-between items-center">
                                    <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to cart</button>
                                    <div class="flex">
                                        <?php
                                        $rating = rand(2, 5);
                                        for ($i = 1; $i <= 5; $i++) {
                                            echo '<span class="' . ($i <= $rating ? 'text-orange-500' : 'text-gray-400') . ' text-lg">★</span>';
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
                        <h2 class="text-2xl font-bold text-red-500 mb-4">😕 Oops! No books found for the selected filters.</h2>
                        <a href="filter.php" class="inline-block mt-4 bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition">
                            Clear All Filters
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include_once "includes/footer2.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>