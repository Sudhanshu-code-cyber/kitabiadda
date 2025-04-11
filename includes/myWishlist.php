<?php

include_once "config/connect.php";

// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;


if (isset($_POST['toggle_wishlist']) && isset($userId)) {
    $bookId = $_POST['wishlist_id'];
    
    // Sanitize input
    $bookId = $connect->real_escape_string($bookId);
    $userId = $connect->real_escape_string($userId);

    // Check if the book is already in the wishlist
    $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
    $book = $check->fetch_array();

    if ($check->num_rows > 0) {
        // Remove from wishlist
        $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
    } else {
        // Add to wishlist
        $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
    }
    
    // Redirect back to the same page
    redirect("profile.php");
    exit();
}
?>

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

<div id="wishlist" class="content-section ">
        <h2 class="text-2xl font-semibold mb-4">My Wishlist</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
            <?php
            while ($book = $booksQuery->fetch_assoc()):
                // Check if the book is already in the wishlist
                $bookId = $book['id'];
                $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                $isWishlisted = ($checkWishlist->num_rows > 0);

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
                                <p class="text-sm text-gray-600 mb-2 truncate"><?= $book['book_author'] ?></p>
                                
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
    </div>