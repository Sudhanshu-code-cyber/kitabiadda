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
    <title>My Cart | Flipkart Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100">
    <nav class="mt-12">
        <?php include_once "includes/header.php"; ?>
    </nav>

    <div class="container mx-auto p-6 md:p-10">
        <h1 class="text-3xl md:text-4xl font-bold text-green-900">Your Cart 
            (<?= $total_cart_item = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM cart WHERE email='$email' AND direct_buy=0")) ?>)
        </h1>

        <?php if ($total_cart_item > 0) { ?>
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Product List -->
            <div class="md:w-2/3">
                <div class="w-full bg-white p-6 shadow-lg rounded-lg h-[500px] overflow-y-auto">
                    <div class="space-y-6">
                        <?php
                        $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id WHERE cart.email='$email' AND direct_buy=0");
                        while ($cartItem = mysqli_fetch_array($callCartItem)) { ?>
                        <div class="flex flex-col md:flex-row items-center gap-4 border-b pb-4">
                            <a href="view.php?book_id=<?= $cartItem['item_id'] ?>">
                                <img src="assets/images/<?= $cartItem['img1'] ?>" class="w-24 h-24 rounded-lg shadow-md" alt="Product">
                            </a>
                            <div class="flex-1 text-center md:text-left">
                                <h3 class="font-semibold text-lg"><?= $cartItem['book_name'] ?></h3>
                                <p class="text-sm text-gray-500">Author: <?= $cartItem['book_author'] ?></p>
                                <p class="text-green-500 font-semibold text-lg">
                                    ₹<?= $cartItem['sell_price'] ?> 
                                    <span class="text-gray-500 line-through text-sm">₹<?= $cartItem['mrp'] ?></span>
                                </p>
                            </div>
                            <div class="flex items-center gap-2 border rounded-lg p-1 shadow-md">
                                <a href="?minus_book=<?= $cartItem['id'] ?>" class="px-3 py-2 bg-gray-300 hover:bg-gray-400 rounded-full">-</a>
                                <span class="text-lg font-bold"> <?= $cartItem['qty'] ?> </span>
                                <a href="?add_book=<?= $cartItem['id'] ?>" class="px-3 py-2 bg-gray-300 hover:bg-gray-400 rounded-full">+</a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="flex items-center bg-white h-20 border-b pb-4 px-6">
                    <a href="cart_checkout.php" class="ml-auto px-6 py-3 bg-orange-500 text-white text-lg font-semibold shadow-md hover:bg-orange-600 transition">
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
                    <p class="flex justify-between"><span>Discount</span> <span class="text-green-700">- ₹<?= $totalMrp - $totalSellPrice ?></span></p>
                    <p class="flex justify-between"><span>Delivery</span> <span class="text-green-700">Free</span></p>
                    <hr>
                    <p class="flex justify-between text-lg font-semibold"><span>Total</span> <span>₹<?= $totalSellPrice ?></span></p>
                    <p class="text-green-700">You will save ₹<?= $totalMrp - $totalSellPrice ?> on this order</p>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="flex justify-center items-center h-[60vh] text-center">
            <p class="text-2xl md:text-4xl font-bold">Your Cart Is Empty, Please add items to continue...</p>
        </div>
        <?php } ?>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    
</body>
</html>
<?php
    include_once "includes/footer2.php";
    ?>