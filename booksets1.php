<?php

include_once "config/connect.php";


// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

if (!isset($_GET['bookType'])) {
    redirect("index.php");
    exit;
}

$bookType = $_GET["bookType"];
$query = $connect->query("SELECT * FROM books WHERE version='$bookType' order by id DESC");

if ($query->num_rows == 0) {
    header("Location: index.php");
    exit;
}

$userId = $user ? $user['user_id'] : null;

// Handle Wishlist Toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist1']) && $userId) {
    $bookId = intval($_POST['wishlist_id1']);

    // Check if the book is already in the wishlist
    $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");

    if ($check->num_rows > 0) {
        // Remove from wishlist
        $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
    } else {
        // Add to wishlist
        $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
    }

    // Redirect to the same page
    redirect("booksets1.php?bookType=" . urlencode($bookType));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Sets</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#f6f7f5]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div
        class="mt-30  bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">
        <div class="bg-white border-b border-gray-200 py-5 shadow-xl px-5">
            <h1 class="text-xl font-semibold">Showing <?= $query->num_rows; ?> results for "<?= ($bookType); ?> Books"
            </h1>
        </div>

        <div class=" bg-white grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2  p-3">
            <?php while ($book = $query->fetch_assoc()):
                $bookId = $book['id'];
                $isWishlisted = false;

                if ($userId) {
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);
                }

                $mrp = floatval($book['mrp']);
                $sell_price = floatval($book['sell_price']);
                if ($mrp > 0 && is_numeric($sell_price)) {
                    $percentage = ($mrp - $sell_price) / $mrp * 100;
                }
                $postedTime = isset($book['post_date']) ? getPostedTime($book['post_date']) : "Unknown date";
                $sell_id=$book['seller_id'];
                $callAdd = mysqli_query($connect, "SELECT * FROM user_address WHERE user_id='$sell_id'");
                
                $address = mysqli_fetch_array($callAdd);
                ?>
                <div
                    class="bg-white p-4 rounded-lg shadow-md hover:shadow-xl border border-gray-200 relative flex flex-col justify-between">
                    <!-- Discount Badge -->
                    <div
                        class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                        <?= round($percentage); ?>% OFF
                    </div>

                    <!-- Wishlist Button -->
                    <form method="POST" action="<?= isset($_SESSION['user']) ? '' : 'login.php'; ?>" class="absolute top-3 right-3">
                        <input type="hidden" name="wishlist_id1" value="<?= $bookId; ?>">
                        <button type="submit" class="cursor-pointer" name="toggle_wishlist1">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                class="size-6 hover:scale-110 transition">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </form>

                    <!-- Book Details -->
                    <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                        <div class="flex justify-center">
                            <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                class="w-40 h-56 object-cover hover:shadow-xl shadow-md rounded-md">
                        </div>

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

                    <!-- Add to Cart -->
                    <?php
                    if ($book['version'] == 'new'): ?>
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

                        <div class="block group/cart">
                            <div class="mt-3 sm:mt-4 border-t border-gray-200 pt-2 sm:pt-3">
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

                                    <span ><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>

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

                    <?php else: ?>
                        
                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-100">
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1 text-[#3D8D7A]"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span
                                            class="truncate max-w-[80px] sm:max-w-[100px]"><?= $address['city'] ?? 'Unknown'; ?></span>
                                    </div>

                                    <div class="flex items-center text-xs text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <?= $postedTime; ?>
                                    </div>
                                </div>


                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <?php include_once "includes/footer2.php"; ?>
</body>

</html>