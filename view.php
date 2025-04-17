<?php
include_once "config/connect.php";

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = NULL;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null;
$userEmail = $user ? $user['email'] : null;

// First handle the book view
if (!isset($_GET['book_id'])) {
    redirect("index.php");
}

$book_id = $_GET['book_id'];
// Use prepared statement to prevent SQL injection
$query = $connect->prepare("SELECT * FROM books WHERE id=?");
$query->bind_param("i", $book_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    redirect("index.php");
}
$book = $result->fetch_array();
$bookId = $book['id'];

// Handle wishlist toggling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist'])) {
    if (!$userId) {
        redirect("login.php");
        exit();
    }

    $bookId = $_POST['wishlist_id'];
    // Check if the book is already in the wishlist using prepared statement
    $check = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ? AND book_id = ?");
    $check->bind_param("ii", $userId, $bookId);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Remove from wishlist
        $stmt = $connect->prepare("DELETE FROM wishlist WHERE user_id = ? AND book_id = ?");
        $stmt->bind_param("ii", $userId, $bookId);
        $stmt->execute();
    } else {
        // Add to wishlist
        $stmt = $connect->prepare("INSERT INTO wishlist (user_id, book_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $userId, $bookId);
        $stmt->execute();
    }

    // Redirect back to the same page with the book_id
    header("Location: view.php?book_id=" . $book_id);
    exit();
}
$book_id = $_GET['book_id'] ?? null;
$sellerdata = null;
$sellerInfo = null;

if ($book_id) {
    $getbook = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
    $sellerdata = mysqli_fetch_array($getbook);

    if ($sellerdata) {
        $seller_id = $sellerdata['seller_id'];
        $getSellerInfo = $connect->query("SELECT name, contact, dp, email FROM users WHERE user_id = '$seller_id'");
        $sellerInfo = mysqli_fetch_assoc($getSellerInfo);
        $sellerContact = $sellerInfo; // For the call drawer
        $seller_email = $sellerContact['email'];
        // echo "<script>alert('$seller_email')</script>";

    }
}

// Check wishlist status
$isWishlisted = false;
if ($userId) {
    $checkWishlist = $connect->prepare("SELECT * FROM wishlist WHERE user_id = ? AND book_id = ?");
    $checkWishlist->bind_param("ii", $userId, $bookId);
    $checkWishlist->execute();
    $result = $checkWishlist->get_result();
    $isWishlisted = ($result->num_rows > 0);
}

// address 
$callAdd = mysqli_query($connect, "SELECT * FROM user_address WHERE email='$seller_email'");

$address = mysqli_fetch_assoc($callAdd) ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $book['book_name'] ?></title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        #bookScroll::-webkit-scrollbar {
            display: none;
        }

        .translate-x-full {
            transform: translateX(100%);
        }

        .translate-x-0 {
            transform: translateX(0);
        }

        /* Hide scrollbar for Firefox */
        #bookScroll {
            scrollbar-width: none;
        }

        /* Container styling for smooth scrolling */
        #bookScroll {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .book-container {
                flex-direction: column;
                padding: 1rem;
            }

            .book-images-section {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding: 1rem 0;
                flex-direction: column-reverse;
            }

            .thumbnails {
                flex-direction: row;
                justify-content: center;
                margin-top: 1rem;
                gap: 0.5rem;
            }

            .thumbnails img {
                width: 40px;
                height: 50px;
            }

            .main-image {
                width: 100%;
                max-width: 200px;
                margin: 0 auto;
            }

            .book-details-section {
                width: 100%;
                padding: 1rem 0;
            }

            .book-actions {
                
                gap: 1rem;
                margin-top: 1rem;
            }

            .book-highlights {
                grid-template-columns: repeat(3, 1fr);
                gap: 1rem;
            }

            .highlight-item {
                padding: 0.5rem;
                border-right: none;
            }

            .book-type-options {
                flex-direction: column;
                gap: 1rem;
            }

            .book-type-option {
                width: 100%;
            }

            .action-buttons {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }

            .action-buttons a {
                width: 100%;
                text-align: center;
                padding: 0.75rem;
            }

            .tab-content {
                padding: 1rem;
            }

            .share-dropdown {
                width: 100%;
                right: auto;
                left: 0;
            }
        }

        @media (max-width: 480px) {
            .book-highlights {
                grid-template-columns: repeat(2, 1fr);
            }

            h1 {
                font-size: 1.5rem;
            }

            .book-author {
                font-size: 1rem;
            }

            .book-category {
                font-size: 0.875rem;
            }

            .tab-buttons {
                flex-wrap: nowrap;
                overflow-x: auto;
                white-space: nowrap;
            }

            .tab-buttons li {
                display: inline-block;
                float: none;
            }
        }
    </style>
</head>

<body
    class="bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="py-5 px-4  w-full md:px-10">
        <div class="flex flex-col bg-white w-full md:flex-row p-4 md:p-10  rounded shadow mt-28 book-container">
            <!-- Book Images Section -->
            <div
                class="flex flex-col md:flex-row gap-10 w-5/12 justify-center md:gap-20 items-center md:w-5/12 border-gray-300 md:border-r-2 space-x-4 p-2 md:p-6 book-images-section">

                <!-- Thumbnails Section -->
                <div
                    class="flex flex-col gap-2 shadow mr-20 md:flex-col space-y-0 md:space-y-2 space-x-2 md:space-x-0 thumbnails">
                    <?php
                    $images = ['img1', 'img2', 'img3', 'img4'];
                    $validImages = [];

                    // Collect only valid (non-empty) images
                    foreach ($images as $imgKey) {
                        if (!empty($book[$imgKey])) {
                            $validImages[] = 'assets/images/' . htmlspecialchars($book[$imgKey]);
                        }
                    }

                    // Display thumbnails
                    foreach ($validImages as $index => $imgSrc) {
                        echo '
            <img src="' . $imgSrc . '" alt="Thumbnail ' . ($index + 1) . '"
                class="w-16 md:w-16 object-cover h-20 md:h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                onclick="changeImage(\'' . $imgSrc . '\')">';
                    }
                    ?>

                    <!-- JS for Image Switching -->
                    <script>
                        function changeImage(src) {
                            document.getElementById("mainBookImage").src = src;
                        }
                    </script>
                </div>

                <!-- Main Image Section -->
                <div class="w-full md:w-64 rounded-lg overflow-hidden shadow-lg main-image">
                    <img id="mainBookImage"
                        src="<?= !empty($book['img1']) ? 'assets/images/' . htmlspecialchars($book['img1']) : 'assets/images/placeholder.png'; ?>"
                        alt="Book Image" class="w-full h-full object-cover">
                </div>

            </div>

            <!-- Book Details Section -->
            <div class="w-7/12 md:w-7/12 flex flex-col gap-2 p-2 md:p-6 book-details-section">
                <div class="flex flex-col md:flex-row justify-between">
                    <div>
                        <h1 class="text-xl md:text-2xl font-semibold"><?= htmlspecialchars($book['book_name']); ?></h1>
                        <p class="text-orange-400 text-xs md:text-sm font-semibold book-category">
                            <?= htmlspecialchars($book['book_category']); ?>
                        </p>
                        <h3 class="text-base md:text-lg font-semibold book-author">Author: <span
                                class="text-[#3D8D7A]"><?= htmlspecialchars($book['book_author']); ?></span></h3>
                    </div>
                    <div class="relative gap-2  md:gap-4 flex md:py-5 mt-2 md:mt-0 book-actions">
                       <div class="flex">
                       <form method="POST" action="view.php?book_id=<?= $book_id ?>" class="">
                            <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                            <input type="hidden" name="toggle_wishlist" value="1">
                            <button type="submit"
                                class="flex items-center gap-1 md:gap-2 bg-gray-100 hover:bg-gray-200 px-2 py-2   md:px-4  md:py-2 rounded-lg font-semibold md:text-base">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                    fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                    class="size-4 sm:size-6 cursor-pointer hover:scale-110 transition">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                </svg>
                                Wishlist
                            </button>
                        </form>
                       </div>

                        <div class="relative  inline-block">
                            <!-- Share Button -->
                            <button id="shareBtn"
                                class="flex font-semibold items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="w-5 h-5">
                                    <path fill-rule="evenodd"
                                        d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                                        clip-rule="evenodd" />
                                </svg>
                                Share
                            </button>

                            <!-- Dropdown Share Options -->
                            <div id="shareDropdown"
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                                <div class="py-1">
                                    <!-- WhatsApp -->
                                    <a href="#" onclick="shareOnWhatsApp()"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <img src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png"
                                            class="w-5 h-5 mr-2" alt="WhatsApp">
                                        WhatsApp
                                    </a>

                                    <!-- Facebook -->
                                    <a href="#" onclick="shareOnFacebook()"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <img src="https://cdn-icons-png.flaticon.com/512/124/124010.png"
                                            class="w-5 h-5 mr-2" alt="Facebook">
                                        Facebook
                                    </a>

                                    <!-- Twitter -->
                                    <a href="#" onclick="shareOnTwitter()"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png"
                                            class="w-5 h-5 mr-2" alt="Twitter">
                                        Twitter
                                    </a>

                                    <!-- Email -->
                                    <a href="#" onclick="shareOnEmail()"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                        </svg>
                                        Email
                                    </a>

                                    <!-- Copy Link -->
                                    <a href="#" onclick="copyToClipboard()"
                                        class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                        </svg>
                                        Copy Link
                                    </a>
                                </div>
                            </div>
                        </div>
                        <script>
                            // Share dropdown functionality
                            document.getElementById('shareBtn').addEventListener('click', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                document.getElementById('shareDropdown').classList.toggle('hidden');
                            });

                            // Close dropdown when clicking outside
                            document.addEventListener('click', function () {
                                document.getElementById('shareDropdown').classList.add('hidden');
                            });

                            // Share functions
                            function getShareUrl() {
                                return window.location.href;
                            }

                            function getShareText() {
                                return "Check out this book: <?= addslashes($book['book_name']) ?>";
                            }

                            // WhatsApp
                            function shareOnWhatsApp() {
                                const url = `https://wa.me/?text=${encodeURIComponent(getShareText() + ' - ' + getShareUrl())}`;
                                window.open(url, '_blank');
                            }

                            // Facebook
                            function shareOnFacebook() {
                                const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(getShareUrl())}`;
                                window.open(url, '_blank', 'width=600,height=400');
                            }

                            // Twitter
                            function shareOnTwitter() {
                                const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(getShareText())}&url=${encodeURIComponent(getShareUrl())}`;
                                window.open(url, '_blank', 'width=600,height=400');
                            }

                            // Email
                            function shareOnEmail() {
                                const subject = "Check out this book: <?= addslashes($book['book_name']) ?>";
                                const body = `I thought you might like this book:\n\n${getShareText()}\n\n${getShareUrl()}`;
                                window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
                            }

                            // Copy Link
                            function copyToClipboard() {
                                navigator.clipboard.writeText(getShareUrl())
                                    .then(() => {
                                        // Show a small notification instead of alert
                                        const notification = document.createElement('div');
                                        notification.textContent = 'Link copied to clipboard!';
                                        notification.style.position = 'fixed';
                                        notification.style.bottom = '20px';
                                        notification.style.right = '20px';
                                        notification.style.backgroundColor = '#4CAF50';
                                        notification.style.color = 'white';
                                        notification.style.padding = '10px 20px';
                                        notification.style.borderRadius = '5px';
                                        notification.style.zIndex = '1000';
                                        document.body.appendChild(notification);

                                        setTimeout(() => {
                                            document.body.removeChild(notification);
                                        }, 3000);
                                    })
                                    .catch(() => {
                                        // Fallback for older browsers
                                        const input = document.createElement('input');
                                        input.value = getShareUrl();
                                        document.body.appendChild(input);
                                        input.select();
                                        document.execCommand('copy');
                                        document.body.removeChild(input);
                                        alert('Link copied!');
                                    });
                            }
                        </script>


                    </div>
                </div>

                <div class="flex gap-5 mb-5">
                    <?php if ($book['version'] != 'old'): ?>
                        <label class="cursor-pointer">
                            <input type="radio" name="book_type" id="e_book" value="e_book" class="peer sr-only">
                            <div
                                class="border-2 border-orange-300 hover:shadow-xl rounded-lg px-3 h-22 w-42 pt-1 flex flex-col peer-checked:border-orange-700">
                                <p class="text-lg p-0 font-semibold">E-BOOK</p>

                                <p class="text-gray-700 font-semibold">Price: <span
                                        class="text-xl text-red-500">₹<?= $book['e_book_price']; ?></span></p>
                                <?=
                                    $book['e_book_price'] != null ? "<span class='text-green-500 text-sm'>Available Now</span>" : "<span class='text-red-500 text-sm'>Not Available</span>";
                                ?>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="book_type" id="physical" value="physical" class="peer sr-only "
                                checked>
                            <div
                                class="border-2 border-orange-300 hover:shadow-xl rounded-lg px-3 h-22 w-42 pt-1 flex flex-col peer-checked:border-orange-700">
                                <p class="text-lg font-semibold"><?= $book['book_binding']; ?></p>
                                <?php
                                $bookId = $book['id'];
                                $mrp = floatval($book['mrp']);
                                $sell_price = floatval($book['sell_price']);
                                $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                                ?>
                                <p><?= $discount; ?>% off</p>
                                <p class="text-gray-700 font-semibold">Price: ₹<del
                                        class="text-sm"><?= $book['mrp']; ?></del>
                                    <span class="text-xl text-red-500">₹<?= $book['sell_price']; ?></span>
                                </p>
                            </div>
                        </label>
                    <?php else: ?>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <div class="flex flex-col gap-1">
                                <div class="flex items-baseline gap-2">
                                    <span class="text-gray-500 line-through">Original Price: ₹<?= $book['mrp']; ?></span>
                                    <span class="text-sm text-green-600 font-medium">
                                        <?= round(100 - ($book['sell_price'] / $book['mrp'] * 100), 0) ?>% OFF
                                    </span>
                                </div>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-2xl font-bold text-gray-800">₹<?= $book['sell_price']; ?></span>
                                    <span class="text-sm text-gray-500">(Inclusive of all taxes)</span>
                                </div>
                                <div class="mt-1">
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                        You will save ₹<?= $book['mrp'] - $book['sell_price']; ?> on this Book
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <hr class="text-gray-300">

                <div class="flex flex-col py-5 gap-3 md:gap-5">
                    <h1 class="text-lg md:text-xl text-gray-600 font-semibold">Key Highlights</h1>
                    <div class="grid grid-cols-5  md:grid-cols-5 gap-1 md:gap-2 book-highlights">
                        <div
                            class="flex items-center border-r gap-1 border-gray-300 px-1 md:px-3 flex-col highlight-item">
                            <p class="text-xs md:text-sm text-gray-500">language</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 md:size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" />
                            </svg>
                            <p class="text-xs md:text-sm"><?= htmlspecialchars($book['language']); ?></p>
                        </div>
                        <div
                            class="flex items-center border-r gap-1 border-gray-300 px-1 md:px-3 flex-col highlight-item">
                            <p class="text-xs md:text-sm text-gray-500">Total Pages</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 md:size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                            </svg>
                            <p class="text-xs md:text-sm"><?= htmlspecialchars($book['book_pages']) ?></p>
                        </div>
                        <div
                            class="flex items-center border-r gap-1 border-gray-300 px-1 md:px-3 flex-col highlight-item">
                            <p class="text-xs md:text-sm text-gray-500">ISBN</p>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-4 md:size-5">
                                <path
                                    d="M24 32C10.7 32 0 42.7 0 56L0 456c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24L64 56c0-13.3-10.7-24-24-24L24 32zm88 0c-8.8 0-16 7.2-16 16l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zm96 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zM448 56l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0c-13.3 0-24 10.7-24 24zm-64-8l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16s-16 7.2-16 16z" />
                            </svg>
                            <p class="text-xs md:text-sm"><?= htmlspecialchars($book['isbn']) ?></p>
                        </div>
                        <div
                            class="flex items-center border-r gap-1 border-gray-300 px-1 md:px-3 flex-col highlight-item">
                            <p class="text-xs md:text-sm text-gray-500">Publish Date</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5 md:size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                            <p class="text-xs md:text-sm"><?= htmlspecialchars($book['publish_year']) ?></p>
                        </div>
                        <div
                            class="flex items-center border-r gap-1 border-gray-300 px-1 md:px-3 flex-col highlight-item">
                            <p class="text-xs md:text-sm text-gray-500">Binding</p>
                            <img src="assets/images/paperback.png" class="size-5 md:size-7" alt="">
                            <p class="text-xs md:text-sm"><?= htmlspecialchars($book['book_binding']) ?></p>
                        </div>
                    </div>

                    <?php
                    if ($book['version'] == "new"):
                        ?>
                        <div class="flex flex-col mt-10 gap-3">
                            <div class="action-buttons grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-5">
                                <a href="cart.php?add_book=<?= $book['id'] ?>"
                                    class="text-orange-500 font-semibold border-orange-500 border rounded px-3 py-2 md:px-5 md:py-2 text-center text-sm md:text-base">
                                    Add Hardcopy to Cart
                                </a>
                                <a href="item_checkout.php?buy_book=<?= $book['id'] ?>"
                                    class="text-white bg-orange-500 font-semibold rounded px-3 py-2 md:px-5 md:py-2 text-center text-sm md:text-base">
                                    Buy Hardcopy Now
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <!-- Seller Profile Photo -->
                            <div class="flex-shrink-0">
                                <img src="assets/user_dp/<?= $sellerContact['dp'] ?? 'defaultUser.webp' ?>"
                                    alt="<?= $sellerContact['name'] ?>" class="rounded-full  h-12 w-12 object-cover">
                            </div>

                            <!-- Seller Info and Chat Button -->
                            <div class="flex-1 flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                                <div>
                                    <p class="text-xs text-gray-500">Sold by</p>
                                    <p class="font-medium text-gray-800"><?= $sellerContact['name'] ?? 'Verified Seller'; ?>
                                    </p>

                                </div>

                                <a href="chatboard.php?book_id=<?= $book['id']; ?>"
                                    class="flex items-center justify-center gap-2 py-2 px-4 bg-blue-600 hover:bg-blue-700 font-medium text-white rounded-md text-sm transition-colors shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                    Chat With Seller
                                </a>
                                <button id="open-drawer-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md">
                                    Contact
                                </button>
                                <!-- Call Drawer -->
                                <div id="call-drawer"
                                    class="fixed top-0 right-0 z-50 mt-40 w-80 h-auto p-4 bg-white shadow-lg transform translate-x-full transition-transform duration-300">
                                    <h2 class="text-lg font-bold text-gray-800 mb-4">Contact Seller</h2>

                                    <div class="flex flex-col h-[20vh] items-center">
                                        <p class="text-lg font-semibold"><?= htmlspecialchars($sellerContact['name']) ?></p>
                                        <p class="text-gray-500"><?= htmlspecialchars($sellerContact['contact']) ?></p>

                                        <div class="mt-4 space-x-4">
                                            <!-- Call Now Button -->
                                            <a id="call-now" href="tel:<?= htmlspecialchars($sellerContact['contact']) ?>"
                                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                                <i class="fas fa-phone mr-2"></i>Call Now
                                            </a>

                                            <!-- Close Button -->
                                            <button id="close-drawer"
                                                class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                                <i class="fas fa-times mr-2"></i>Close
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="py-5 px-4 md:px-10 rounded">
        <div class="bg-white shadow-md rounded-lg px-4 md:px-6 py-4 md:py-5 w-full">
            <div class="mb-4 border-b border-gray-200">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center tab-buttons" id="default-tab"
                    data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="me-2" role="presentation">
                        <button class="inline-block p-2 md:p-4 border-b-2 rounded-t-lg" id="profile-tab"
                            data-tabs-target="#profile" type="button" role="tab" aria-controls="profile"
                            aria-selected="false">Description</button>
                    </li>
                    <li class="me-2" role="presentation">
                        <button
                            class="inline-block p-2 md:p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300"
                            id="dashboard-tab" data-tabs-target="#dashboard" type="button" role="tab"
                            aria-controls="dashboard" aria-selected="false">Author</button>
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-3 md:p-4 rounded-lg bg-gray-50 tab-content" id="profile" role="tabpanel"
                    aria-labelledby="profile-tab">
                    <p class="text-gray-700 pt-2 text-sm md:text-base"><?= $book['book_description']; ?></p>
                </div>
                <div class="hidden p-3 md:p-4 rounded-lg bg-gray-50 tab-content" id="dashboard" role="tabpanel"
                    aria-labelledby="dashboard-tab">
                    <p class="text-gray-700 pt-2 text-sm md:text-base"><?= htmlspecialchars($book['book_author']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <?php

    if ($book['version'] == 'new'  ): ?>
        <?php include_once "includes/recomended_book.php" ?>
    <?php else: ?>
        <div class="p-4 md:p-6">
    <div class="flex flex-col md:flex-row gap-6 bg-white p-5 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
        <!-- Left Section - Post Details -->
        <div class="w-full md:w-1/2 space-y-4">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg">
                <h2 class="text-xl font-bold text-gray-800 mb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Posted On
                </h2>
                <div class="space-y-2 pl-7">
                    <p class="text-gray-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">Date:</span> <?= date('d M Y', strtotime($book['post_date'])) ?>
                    </p>
                    <p class="text-gray-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="font-medium">At:</span><?= $address['landmark'] ?> , <?= $address['address'] ?> , <?= $address['city'] ?> (<?= $address['pincode'] ?>), <?= $address['state'] ?>
                    </p>
                    <p class="text-gray-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        <span class="font-medium">Near By:</span> <?= $address['locality'] ?>, <?= $address['pincode'] ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Section - Map -->
        <div class="w-full md:w-1/2">
            <div class="bg-gray-100 rounded-lg p-4 h-full">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Location
                </h2>
                <div class="mt-4 rounded-lg overflow-hidden border border-gray-200">
                    <iframe class="w-full h-64 rounded-lg"
                        src="https://maps.google.com/maps?q=<?= $address['lattitude'] ?>,<?= $address['longitude'] ?>&hl=es&z=14&output=embed"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
                <a href="https://www.google.com/maps?q=<?= $address['lattitude'] ?>,<?= $address['longitude'] ?>" target="_blank" rel="noopener noreferrer"
                    class="mt-3 text-blue-600 hover:text-blue-800 text-sm font-medium inline-flex items-center transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Open in Maps
                </a>
            </div>
        </div>
    </div>
</div>
    <?php endif; ?>
    <?php include_once "includes/footer2.php" ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const callDrawer = document.getElementById("call-drawer");
            const closeDrawer = document.getElementById("close-drawer");

            // Function to open drawer
            function openDrawer() {
                callDrawer.classList.remove("translate-x-full");
                callDrawer.classList.add("translate-x-0");
            }

            // Function to close drawer
            function closeDrawerFunc() {
                callDrawer.classList.remove("translate-x-0");
                callDrawer.classList.add("translate-x-full");
            }

            // Attach close event
            if (closeDrawer) {
                closeDrawer.addEventListener("click", closeDrawerFunc);
            }

            // Example: Add event listener to open drawer (you may need to call this from another button)
            document.getElementById("open-drawer-btn")?.addEventListener("click", openDrawer);
        });



        document.addEventListener('DOMContentLoaded', function () {
            const openDrawerBtn = document.getElementById('open-drawer-btn');
            const closeDrawerBtn = document.getElementById('close-drawer');
            const callDrawer = document.getElementById('call-drawer');
            const callNowBtn = document.getElementById('call-now');

            // Open drawer when Contact button is clicked
            openDrawerBtn.addEventListener('click', function () {
                callDrawer.classList.remove('translate-x-full');
                callDrawer.classList.add('translate-x-0');
            });

            // Close drawer when Close button is clicked
            closeDrawerBtn.addEventListener('click', function () {
                callDrawer.classList.remove('translate-x-0');
                callDrawer.classList.add('translate-x-full');
            });

            // Immediately initiate call when Call Now is clicked
            callNowBtn.addEventListener('click', function (e) {
                // The href="tel:..." on the anchor tag will handle the actual call
                // Close the drawer after initiating call
                callDrawer.classList.remove('translate-x-0');
                callDrawer.classList.add('translate-x-full');
            });
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>