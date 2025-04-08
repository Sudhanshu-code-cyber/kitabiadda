<?php include_once "config/connect.php";
// Check if user is logged in
if (!isset($_SESSION['user'])) {
    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '🔒 Access Denied!',
                text: 'Please login first to continue.',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Login Now',
                denyButtonText: 'Go Back',
                allowOutsideClick: false, // बाहर क्लिक करने से बंद न हो
                allowEscapeKey: false, // ESC दबाने से बंद न हो
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php'; // Login Page पर जाएं
                } else if (result.isDenied) {
                    window.location.href = '$previousPage'; // पिछली पेज पर जाएं
                }
            });

            // ⏳ 5 सेकंड बाद Auto Redirect पिछले पेज पर
            setTimeout(() => {
                window.location.href = '$previousPage';
            }, 5000);
        });
    </script>";

    exit();
}
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();

}
$userId = $user ? $user['user_id'] : null;

// Handle wishlist toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggleWishlist'])) {
    if (!$userId) {
        redirect("login.php");
        exit;
    }

    $bookId = intval($_POST['wishlistId']);

    // Check if book exists in wishlist
    $query = "SELECT 1 FROM wishlist WHERE user_id = $userId AND book_id = $bookId";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Remove from wishlist
        $deleteQuery = "DELETE FROM wishlist WHERE user_id = $userId AND book_id = $bookId";
        mysqli_query($connect, $deleteQuery);
        $_SESSION['message'] = "Book removed from wishlist";
    } else {
        // Add to wishlist
        $insertQuery = "INSERT INTO wishlist (user_id, book_id) VALUES ($userId, $bookId)";
        mysqli_query($connect, $insertQuery);
        $_SESSION['message'] = "Book added to wishlist";
    }

    redirect("wishlist.php"); // Refresh wishlist page
    exit;
}

// Fetch wishlist items
$booksResult = [];
$countWishlist = 0;

if ($userId) {
    $query = "SELECT books.* FROM wishlist JOIN books ON books.id = wishlist.book_id WHERE wishlist.user_id = $userId";
    $booksResult = mysqli_query($connect, $query);

    $countQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = $userId";
    $countResult = mysqli_query($connect, $countQuery);
    $countWishlist = mysqli_fetch_assoc($countResult)['count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body
    class="bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex mt-30 gap-4 px-[5%] p-10 flex-col bg-linear-65">
        <h1 class="font-bold text-2xl text-red-900 flex items-center gap-2 animate-pulse">
            <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text">
                My Wishlist (<?= $countWishlist; ?>)
            </span>
        </h1>

        <?php if ($countWishlist == 0): ?>
            <div class="text-center py-10">
                <p class="text-xl text-gray-500">Your wishlist is empty 😢</p>
                <p class="text-gray-500">Explore our collection and add books you love!</p>
                <a href="index.php"
                    class="mt-4 inline-flex items-center gap-3 px-6 py-2 bg-gradient-to-r bg-[#3D8D7A] to-[#2F6D5E] text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 group">
                    <span class="text-xl">📚</span>
                    <span>Browse Our Collection</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>

            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
                    <?php
                    $bookId = $book['id'];
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                    ?>
                    <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-full relative">
                        <div
                            class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                            <?= $discount; ?>% OFF
                        </div>

                        <form method="POST" action="wishlist.php" class="absolute top-3 right-3">
                            <input type="hidden" name="wishlistId" value="<?= $bookId; ?>">
                            <button type="submit" class="cursor-pointer" name="toggleWishlist">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" stroke="red"
                                    stroke-width="1.5" class="size-6 hover:scale-110 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                            </button>
                        </form>

                        <a href="view.php?book_id=<?= $bookId; ?>" class="block">
                            <div class="flex justify-center">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-40 h-56 object-cover hover:scale-105 transition shadow-md rounded-md">
                            </div>
                            <div class="mt-4 text-center">
                                <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?></h2>
                                <p class="text-gray-500 text-sm"><?= $book['book_author']; ?></p>
                                <div class="flex justify-center items-center space-x-2 mt-1">
                                    <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                    <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                                </div>
                            </div>
                        </a>

                        <a href="cart.php?add_book=<?= $book['id']; ?>">
    <div class="mt-4 border-t pt-3  flex justify-center">
        <button
            class="flex  gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white text-sm font-semibold py-2 px-4 w-full justify-center items-center rounded-lg shadow cursor-pointer">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 mt-2 h-6 text-white" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
            </svg>
            <span>Move to Cart</span>
        </button>
    </div>
</a>

                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include_once "includes/footer2.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>