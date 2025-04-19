<?php
include_once "config/connect.php";

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

$email = $_SESSION['user'];
$call_user_id = mysqli_query($connect, "SELECT * FROM users where email='$email'");
$fetch_user_id = mysqli_fetch_assoc($call_user_id);
$users_id1 = $fetch_user_id['user_id'];


if (isset($_GET['add_book'])) {
    $item_id = $_GET['add_book'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");

    if (mysqli_num_rows($itemInCart) > 0) {
        mysqli_query($connect, "UPDATE cart SET qty = qty + 1 WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");
    } else {
        mysqli_query($connect, "INSERT INTO cart (email, item_id) VALUES ('$email', '$item_id')");
    }
    echo "<script>window.location.href='cart.php';</script>";
}

if (isset($_GET['add_book_to_wishlist'])) {
    $item_id = $_GET['add_book_to_wishlist'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");

    if (mysqli_num_rows($itemInCart) > 0) {
        // $add_to_cart = mysqli_query($connect, "UPDATE cart SET qty = qty + 1 WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");
        $delete_from_wishlist = mysqli_query($connect, "DELETE FROM wishlist WHERE book_id='$item_id' AND user_id='$users_id1'");
        if ($delete_from_wishlist) {
            echo "<script>window.location.href='wishlist.php';</script>";
        }
    } else {
        $insert_to_cart_from_wishlist = mysqli_query($connect, "INSERT INTO cart (email, item_id) VALUES ('$email', '$item_id')");
        if ($insert_to_cart_from_wishlist) {
            $delete_from_wishlist = mysqli_query($connect, "DELETE FROM wishlist WHERE book_id='$item_id' AND user_id='$users_id1'");
            if ($delete_from_wishlist) {
                echo "<script>window.location.href='wishlist.php';</script>";
            }
        }
    }
    echo "<script>window.location.href='wishlist.php';</script>";

}

if (isset($_GET['minus_book'])) {
    $item_id = $_GET['minus_book'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");
    $itemData = mysqli_fetch_assoc($itemInCart);

    if ($itemData) {
        if ($itemData['qty'] > 1) {
            mysqli_query($connect, "UPDATE cart SET qty = qty - 1 WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");
        } else {
            mysqli_query($connect, "DELETE FROM cart WHERE item_id='$item_id' AND email='$email' AND direct_buy=0");
        }
    }
    echo "<script>window.location.href='cart.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart | kitabikdda.com</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Mobile sticky footer */
        @media (max-width: 767px) {
            .mobile-sticky-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                padding: 12px 16px;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
                z-index: 100;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .product-list-container {
                padding-bottom: 80px; /* Add padding to prevent content from being hidden behind sticky footer */
            }
            
            .desktop-price-summary {
                display: none;
            }
        }
        
        @media (min-width: 768px) {
            .mobile-sticky-footer {
                display: none;
            }
            
            .desktop-price-summary {
                display: block;
            }
        }
        
        /* Custom scrollbar for product list */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #3D8D7A;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #2c6a5a;
        }
    </style>
</head>

<body
    class="bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">
    <nav class="mt-12">
        <?php include_once "includes/header.php"; ?>
    </nav>

    <div class="container mx-auto p-6 md:p-10">
        <h1 class="text-3xl md:text-4xl font-bold text-green-900">Your Cart
            (<?= $total_cart_item = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM cart WHERE email='$email' AND direct_buy=0")) ?>)
        </h1>

        <?php if ($total_cart_item > 0) { ?>
            <br>
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Product List -->
                <div class="md:w-2/3">
                    <div class="w-full bg-white p-6 shadow-lg rounded-t-lg h-auto overflow-y-auto">
                        <div class="space-y-6">
                            <?php
                            $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id WHERE cart.email='$email' AND direct_buy=0 ORDER BY cart.id DESC");
                            while ($cartItem = mysqli_fetch_array($callCartItem)) { ?>
                                <div class="flex flex-col md:flex-row items-center gap-4 border-b pb-4">
                                    <a href="view.php?book_id=<?= $cartItem['item_id'] ?>">
                                        <img src="assets/images/<?= $cartItem['img1'] ?>" class="w-24 h-24 rounded-lg shadow-md"
                                            alt="Product">
                                    </a>
                                    <div class="flex-1 text-center md:text-left">
                                        <h3 class="font-semibold text-lg"><?= $cartItem['book_name'] ?></h3>
                                        <p class="text-sm text-gray-500">Author: <?= $cartItem['book_author'] ?></p>
                                        <p class="text-green-500 font-semibold text-lg">
                                            ₹<?= $cartItem['sell_price'] ?>
                                            <span class="text-gray-500 line-through text-sm">₹<?= $cartItem['mrp'] ?></span>
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3 bg-gray-100 rounded-md px-3 py-1">
                                        <a href="?minus_book=<?= $cartItem['id'] ?>"
                                            class="text-gray-700 text-xl font-medium px-2 hover:text-black">−</a>

                                        <span class="text-base font-medium text-gray-800">
                                            <?= $cartItem['qty'] ?>
                                        </span>

                                        <a href="?add_book=<?= $cartItem['id'] ?>"
                                            class="text-gray-700 text-xl font-medium px-2 hover:text-black">+</a>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="sm:flex hidden items-center  rounded-b-lg bg-white h-20 border-b pb-4 px-6">
                   
                        <a href="cart_checkout.php"
                            class="ml-auto px-6 py-3 bg-[#3D8D7A] text-white text-lg font-semibold shadow-md hover:bg-[#13453a] transition">
                            PLACE ORDER
                        </a>
                    </div>
                </div>

                <!-- Price Details -->
                <?php
                $totalMrp = 0;
                $totalSellPrice = 0;
                $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id WHERE cart.email='$email' AND direct_buy=0");
                while ($price = mysqli_fetch_array($callCartItem)) {
                    $totalMrp += $price['qty'] * $price['mrp'];
                    $totalSellPrice += $price['qty'] * $price['sell_price'];
                }
                ?>
                <div class="w-full md:w-1/3 bg-white p-6 shadow-lg rounded-lg h-fit sticky top-16">
                    <h2 class="text-xl font-bold mb-4">Price Details</h2>
                    <div class="space-y-3 text-gray-700">
                        <p class="flex justify-between"><span>Price</span> <span>₹<?= $totalMrp ?></span></p>
                        <p class="flex justify-between"><span>Discount</span> <span class="text-green-700">-
                                ₹<?= $totalMrp - $totalSellPrice ?></span></p>
                        <p class="flex justify-between"><span>Delivery</span> <span class="text-green-700">Free</span></p>
                        <hr>
                        <p class="flex justify-between text-lg font-semibold"><span>Total</span>
                            <span>₹<?= $totalSellPrice ?></span>
                        </p>
                        <p class="text-green-700">You will save ₹<?= $totalMrp - $totalSellPrice ?> on this order</p>
                    </div>
                </div>
                  <!-- Mobile Sticky Footer -->
                  <div class="mobile-sticky-footer">
                    <div class="text-left">
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="text-lg font-bold">₹<?= $totalSellPrice ?></p>
                    </div>
                    <a href="cart_checkout.php"
                        class="px-6 py-3 bg-[#3D8D7A] text-white text-lg font-semibold rounded-lg shadow-md hover:bg-[#13453a] transition whitespace-nowrap">
                        PLACE ORDER
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <div class="flex flex-col gap-1 justify-center items-center h-[60vh] text-center">
                <img src="assets/images/download.png" alt="">
                <p class="text-xl md:text-4xl font-bold">No items in your cart!</p>
                <span class="mt-4">There is nothing in your cart. Let’s add some items</span>
                <a href="index.php"
                    class="relative mt-5 inline-flex items-center px-8 py-3 bg-[#3D8D7A] text-white bg-gradient-to-r from-[#3D8D7A] to-[#2c6a5a] rounded-full group shadow-lg hover:scale-105 transition-all duration-300">
                    <span
                        class="absolute left-0 w-full h-0 transition-all bg-[#B3D8A8] rounded-full opacity-100 group-hover:h-full top-1/2 group-hover:top-0 duration-300 ease-in-out"></span>
                    <span
                        class="absolute left-0 flex items-center justify-end w-10 h-10 duration-300 transform translate-x-full group-hover:translate-x-0 ease">

                    </span>
                    <span class="relative flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 bg-[#] text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Continue Shopping
                    </span>
                </a>

            </div>
        <?php } ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>
<?php
include_once "includes/footer2.php";
?>