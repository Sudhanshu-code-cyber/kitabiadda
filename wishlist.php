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
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                } else if (result.isDenied) {
                    window.location.href = '$previousPage';
                }
            });

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

    redirect("wishlist.php");
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
    <title>My Wishlist | Book Haven</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .book-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .heart-btn {
            transition: all 0.3s ease;
        }
        .heart-btn:hover {
            transform: scale(1.2);
        }
        .empty-wishlist {
            background-image: url('https://cdn.dribbble.com/users/5107895/screenshots/14532312/media/a7e6c2e9333d0989e3a54c95dd8321d7.jpg');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 400px;
        }
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
    </style>
</head>

<body class="bg-gradient-to-b from-[#FBFFE4] to-[#e8f5d8] min-h-screen">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <main class="container mt-30 mx-auto px-4 py-8">
        <!-- Wishlist Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="flex items-center mb-4 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    <span class="bg-clip-text  bg-gradient-to-r from-[#3D8D7A] to-[#2F6D5E]">
                        My Wishlist
                    </span>
                </h1>
                <span class="ml-3 px-3 py-1 bg-[#3D8D7A] text-white rounded-full text-sm font-semibold animate-bounce">
                    <?= $countWishlist ?> item<?= $countWishlist != 1 ? 's' : '' ?>
                </span>
            </div>
            
            <?php if ($countWishlist > 0): ?>
            
            <?php endif; ?>
        </div>

        <?php if ($countWishlist == 0): ?>
            <!-- Empty Wishlist State -->
            <div class="empty-wishlist flex flex-col items-center justify-center text-center p-8 rounded-xl bg-white  mt-10">
                <div class="max-w-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Wishlist is Feeling Lonely</h2>
                    <p class="text-gray-600 mb-6">Looks like you haven't added any books to your wishlist yet. Start exploring our collection and save your favorites!</p>
                    <a href="index.php" class="inline-flex items-center bg-[#3D8D7A] px-6 py-3 bg-gradient-to-r from-[#3D8D7A] to-[#2F6D5E] text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Books
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Wishlist Items Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
                    <?php
                    $bookId = $book['id'];
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                    ?>
                    <div class="book-card bg-white rounded-xl overflow-hidden relative group">
                        <!-- Discount Badge -->
                        <?php if ($discount > 0): ?>
                            <span class="discount-badge "><?= $discount ?>% OFF</span>
                        <?php endif; ?>
                        
                        <!-- Heart Button -->
                        <form method="POST" action="wishlist.php" class="absolute top-3 right-3 z-10">
                            <input type="hidden" name="wishlistId" value="<?= $bookId ?>">
                            <button type="submit" name="toggleWishlist" class="heart-btn bg-white p-2 rounded-full shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                            </button>
                        </form>
                        
                        <!-- Book Image -->
                        <a href="view.php?book_id=<?= $bookId ?>" class="block">
                        <div class="flex justify-center p-5">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                    class="w-28 h-40 sm:w-36 sm:h-52 object-cover hover:shadow-xl rounded-md">
                            </div>

                            
                            <!-- Book Details -->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 mb-1 truncate"><?= $book['book_name'] ?></h3>
                                <p class="text-sm text-gray-600 mb-2"><?= $book['book_author'] ?></p>
                                
                                <div class="flex items-center justify-between mt-3">
                                    <div class="flex  justify-between items-center">
                                        <?php if ($mrp > $sell_price): ?>
                                            <span class="text-xs text-gray-500 line-through mr-2">₹<?= $mrp ?></span>
                                        <?php endif; ?>
                                        <span class=" text-[#3D8D7A] font-bold">₹<?= $sell_price ?></span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-gray-100 rounded-full"><?= ucfirst($book['version']) ?></span>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Action Buttons -->
                        <div class="px-4 pb-4">
                            <?php if ($book['version'] == "new"): ?>
                                <a href="cart.php?add_book_to_wishlist=<?= $book['id'] ?>" class="block w-full">
                                    <button class="w-full flex items-center justify-center gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white py-2 px-2 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </a>
                            <?php else: ?>
                                <a href="chatboard.php?book_id=<?= $book['id'] ?>" class="block w-full">
                                    <button class="w-full flex items-center justify-center gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white py-2 px-2 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
            
            <!-- Wishlist Summary -->
            
        <?php endif; ?>
    </main>

    <?php include_once "includes/footer2.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        // Animation for empty wishlist illustration
        document.addEventListener('DOMContentLoaded', function() {
            const emptyWishlist = document.querySelector('.empty-wishlist');
            if (emptyWishlist) {
                emptyWishlist.style.backgroundPositionY = '0px';
                let position = 0;
                setInterval(() => {
                    position = (position + 1) % 20;
                    emptyWishlist.style.backgroundPositionY = position + 'px';
                }, 100);
            }
        });
    </script>




</body>

</html>