<?php
include_once "config/connect.php";

// Check if user is logged in
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
    $books = mysqli_fetch_all($booksResult, MYSQLI_ASSOC);

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
    <title>My Wishlist | BookStore</title>
    <meta name="description" content="View and manage your wishlist of books">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.8/glider.min.css">
    <style>
        .empty-wishlist {
            min-height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .book-image {
            transition: transform 0.3s ease;
        }
        .book-image:hover {
            transform: scale(1.05);
        }
        .wishlist-btn {
            transition: transform 0.2s ease;
        }
        .wishlist-btn:hover {
            transform: scale(1.2);
        }
        .glider-slide {
            padding: 0 8px;
        }
        .glider-track {
            gap: 16px;
        }
        .glider-prev, .glider-next {
            top: 40%;
            transform: translateY(-50%);
        }
        .glider-prev {
            left: -20px;
        }
        .glider-next {
            right: -20px;
        }
        .glider-contain {
            position: relative;
        }
        @media (max-width: 767px) {
            .desktop-view {
                display: none;
            }
            .mobile-slider {
                display: block;
            }
        }
        @media (min-width: 768px) {
            .desktop-view {
                display: grid;
            }
            .mobile-slider {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    
    <main class="container mx-auto px-4 py-8">
        <!-- Flash message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg flex justify-between items-center">
                <span><?= $_SESSION['message']; ?></span>
                <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                <span class="bg-gradient-to-r from-blue-500 to-purple-600 text-transparent bg-clip-text">
                    My Wishlist
                </span>
                <span class="text-gray-600 ml-2">(<?= $countWishlist; ?>)</span>
            </h1>
            <?php if ($countWishlist > 0): ?>
                <a href="index.php" class="flex items-center text-blue-600 hover:text-blue-800">
                    <i class="fas fa-plus mr-2"></i>
                    <span class="hidden sm:inline">Add More Books</span>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($countWishlist == 0): ?>
            <div class="empty-wishlist text-center">
                <div class="w-24 h-24 mb-6 text-gray-300">
                    <i class="fas fa-heart text-6xl"></i>
                </div>
                <h2 class="text-xl md:text-2xl font-semibold text-gray-700 mb-2">Your wishlist is empty</h2>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">Save your favorite books here to keep track of what you want to read next!</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="index.php" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-md">
                        Browse Books
                    </a>
                    <a href="bestsellers.php" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-md">
                        View Bestsellers
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Desktop View (Original Grid) -->
            <div class="desktop-view grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-12">
                <?php foreach ($books as $book): ?>
                    <?php
                    $bookId = $book['id'];
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                    ?>
                    <div class="book-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-gray-100 relative">
                        <!-- Discount badge -->
                        <?php if ($discount > 0): ?>
                            <div class="absolute left-3 top-3 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-md shadow-md z-10">
                                <?= $discount; ?>% OFF
                            </div>
                        <?php endif; ?>
                        
                        <!-- Wishlist button -->
                        <form method="POST" action="wishlist.php" class="absolute right-3 top-3 z-10">
                            <input type="hidden" name="wishlistId" value="<?= $bookId; ?>">
                            <button type="submit" class="wishlist-btn bg-white p-2 rounded-full shadow-md" name="toggleWishlist" aria-label="Remove from wishlist">
                                <i class="fas fa-heart text-red-500 text-lg"></i>
                            </button>
                        </form>
                        
                        <!-- Book image and details -->
                        <a href="view.php?book_id=<?= $bookId; ?>" class="block">
                            <div class="p-4 flex justify-center">
                                <img src="assets/images/<?= $book['img1']; ?>" alt="<?= htmlspecialchars($book['book_name']); ?>" class="book-image w-40 h-56 object-contain">
                            </div>
                            <div class="px-4 pb-4">
                                <h2 class="text-lg font-semibold text-gray-800 mb-1 truncate"><?= htmlspecialchars($book['book_name']); ?></h2>
                                <p class="text-gray-600 text-sm mb-3 truncate"><?= htmlspecialchars($book['book_author']); ?></p>
                                <div class="flex items-center gap-2">
                                    <?php if ($discount > 0): ?>
                                        <span class="text-gray-400 line-through text-sm">₹<?= number_format($mrp, 2); ?></span>
                                    <?php endif; ?>
                                    <span class="text-gray-900 font-bold">₹<?= number_format($sell_price, 2); ?></span>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Add to cart button -->
                        <div class="px-4 pb-4 pt-2 border-t border-gray-100">
                            <a href="cart.php?add_book=<?= $book['id']; ?>" class="block w-full py-2 text-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                Add to Cart
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Mobile Slider View (2 products per slide) -->
            <div class="mobile-slider relative mt-6">
                <div class="glider-contain">
                    <div class="glider">
                        <?php 
                        // Group books into pairs for 2-per-slide display
                        $bookPairs = array_chunk($books, 2);
                        foreach ($bookPairs as $pair): 
                        ?>
                            <div class="glider-slide">
                                <div class="grid grid-cols-2 gap-4">
                                    <?php foreach ($pair as $book): ?>
                                        <?php
                                        $bookId = $book['id'];
                                        $mrp = floatval($book['mrp']);
                                        $sell_price = floatval($book['sell_price']);
                                        $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                                        ?>
                                        <div class="book-card bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow border border-gray-100 relative">
                                            <!-- Discount badge -->
                                            <?php if ($discount > 0): ?>
                                                <div class="absolute left-3 top-3 bg-red-500 text-white px-2 py-1 text-xs font-bold rounded-md shadow-md z-10">
                                                    <?= $discount; ?>% OFF
                                                </div>
                                            <?php endif; ?>
                                            
                                            <!-- Wishlist button -->
                                            <form method="POST" action="wishlist.php" class="absolute right-3 top-3 z-10">
                                                <input type="hidden" name="wishlistId" value="<?= $bookId; ?>">
                                                <button type="submit" class="wishlist-btn bg-white p-2 rounded-full shadow-md" name="toggleWishlist" aria-label="Remove from wishlist">
                                                    <i class="fas fa-heart text-red-500 text-lg"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Book image and details -->
                                            <a href="view.php?book_id=<?= $bookId; ?>" class="block">
                                                <div class="p-4 flex justify-center">
                                                    <img src="assets/images/<?= $book['img1']; ?>" alt="<?= htmlspecialchars($book['book_name']); ?>" class="book-image w-full h-40 object-contain">
                                                </div>
                                                <div class="px-4 pb-4">
                                                    <h2 class="text-lg font-semibold text-gray-800 mb-1 truncate"><?= htmlspecialchars($book['book_name']); ?></h2>
                                                    <p class="text-gray-600 text-sm mb-3 truncate"><?= htmlspecialchars($book['book_author']); ?></p>
                                                    <div class="flex items-center gap-2">
                                                        <?php if ($discount > 0): ?>
                                                            <span class="text-gray-400 line-through text-sm">₹<?= number_format($mrp, 2); ?></span>
                                                        <?php endif; ?>
                                                        <span class="text-gray-900 font-bold">₹<?= number_format($sell_price, 2); ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                            
                                            <!-- Add to cart button -->
                                            <div class="px-4 pb-4 pt-2 border-t border-gray-100">
                                                <a href="cart.php?add_book=<?= $book['id']; ?>" class="block w-full py-2 text-center bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button aria-label="Previous" class="glider-prev bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button aria-label="Next" class="glider-next bg-white p-2 rounded-full shadow-md hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <div role="tablist" class="glider-dots mt-4 flex justify-center"></div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include_once "includes/footer2.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/glider-js/1.7.8/glider.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile slider initialization
            if (document.querySelector('.glider')) {
                new Glider(document.querySelector('.glider'), {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    draggable: true,
                    scrollLock: true,
                    arrows: {
                        prev: '.glider-prev',
                        next: '.glider-next'
                    },
                    dots: '.glider-dots',
                    responsive: [
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });
            }

            // Original form validation
            const wishlistForms = document.querySelectorAll('form[name="toggleWishlist"]');
            wishlistForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!this.querySelector('input[name="wishlistId"]').value) {
                        e.preventDefault();
                        alert('Error: Book ID missing');
                    }
                });
            });
        });
    </script>
</body>
</html>