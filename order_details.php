<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
// Check if order ID is provided
if (!isset($_GET['order_id'])) {
    header("Location: profile.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_email = $user['email']; // Assuming you have user session

// Fetch order details
$order_query = $connect->query("SELECT * FROM orders WHERE id='$order_id' AND email='$user_email'");
if ($order_query->num_rows == 0) {
    header("Location: profile.php");
    exit();
}
$order = $order_query->fetch_assoc();

// Fetch order items
$items_query = $connect->query("
    SELECT cart.*, books.book_name, books.img1, books.sell_price, books.book_author 
    FROM cart 
    JOIN books ON cart.item_id = books.id 
    WHERE cart.orders_id='$order_id'
");
$total_items = $items_query->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #<?= $order_id ?> Details</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="./src/output.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto  py-8 max-w-6xl">
        <!-- Header with back button -->
        <nav class="bg-[#3D8D7A] text-white p-4 fixed w-full top-0 z-50 shadow-md">
            <div class="container mx-auto flex justify-between items-center px-4">
                <a href="profile.php" class="text-white text-xl md:text-2xl">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <?php if ($order['status'] == 1) { ?>
                    <button onclick="window.print()"
                        class="bg-[#3D8D7A] hover:bg-[#337565] text-white font-semibold py-2 px-5 rounded-xl shadow-lg flex items-center gap-2 transition-all duration-300">

                        <!-- Icon (Optional) -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11v8m0 0l3-3m-3 3l-3-3m6-13H9a2 2 0 00-2 2v4h10V6a2 2 0 00-2-2z" />
                        </svg>

                        Save Page as PDF
                    </button>

                    </a>
                <?php }

                ?>

            </div>
        </nav>

        <!-- Order Summary Card -->
        <div class="bg-white mt-32 md:mt-24 rounded-xl shadow-lg p-4 sm:p-6 mb-6 max-w-4xl mx-auto"
            id="invoice-content">
            <div class="flex flex-col md:flex-row justify-between mb-6">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-1">Order #<?= $order_id ?></h1>
                    <p class="text-sm text-gray-500">Placed on
                        <?= date("F j, Y, g:i a", strtotime($order['order_time'])) ?>
                    </p>


                    <!-- Order Status Badge -->

                    <!-- Button to show popup -->
                    <button onclick="showPopup()"
                        class="px-4 py-1 bg-orange-500 mt-2 text-white rounded-sm hover:bg-orange-600 transition duration-300">
                        Show Order Status
                    </button>
                </div>

                <div class="mt-5 md:mt-0">
                    <?php
                    $callAdd = $connect->query("select * from user_address where email='$user_email'");
                    $add = $callAdd->fetch_assoc();
                    ?>
                    <h2 class="text-md sm:text-lg font-semibold text-gray-800 mb-1">Delivery Address</h2>
                    <p class="text-sm text-gray-600"><?= $add['name'] ?></p>
                    <p class="text-sm text-gray-600"><?= $add['address'] ?></p>
                    <p class="text-sm text-gray-600"><?= $add['city'] ?>, <?= $add['state'] ?> - <?= $add['pincode'] ?>
                    </p>
                    <p class="text-sm text-gray-600">Phone: <?= $add['mobile'] ?></p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t border-gray-200 pt-5">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Order Items (<?= $total_items ?>) </h2>
                <div class="space-y-4">
                    <?php
                    $subtotal = 0;
                    while ($item = $items_query->fetch_assoc()):
                        $subtotal += $item['sell_price'] * $item['qty'];
                        ?>
                        <div class="flex flex-col sm:flex-row items-start sm:items-center border-b border-gray-100 pb-4">
                            <div class="flex items-start flex-1">
                                <img src="assets/images/<?= $item['img1'] ?>" alt="<?= $item['book_name'] ?>"
                                    class="w-20 h-20 object-cover rounded-lg mr-4">
                                <div>
                                    <h3 class="text-md font-medium text-gray-900"><?= $item['book_name'] ?></h3>
                                    <p class="text-sm text-gray-600">by <?= $item['book_author'] ?></p>
                                    <p class="text-sm text-gray-600 mt-1">Quantity: <?= $item['qty'] ?></p>
                                </div>
                            </div>
                            <div class="mt-2 sm:mt-0 sm:text-right">
                                <p class="text-md font-medium text-gray-900">
                                    ₹<?= number_format($item['sell_price'] * $item['qty'], 2) ?></p>
                                <p class="text-sm text-gray-500">₹<?= number_format($item['sell_price'], 2) ?> each</p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-8 border-t border-gray-200 pt-5">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-2">Payment Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p class="text-sm text-gray-600"><span class="font-medium">Method:</span>
                                <?= ucfirst($order['payment_type']) ?></p>
                            <p class="text-sm text-gray-600"><span class="font-medium">Status:</span>
                                <?= $order['status'] == 1 ? 'Paid' : 'Pending' ?></p>
                            <?php if ($order['payment_type'] == 'card'): ?>
                                <p class="text-sm text-gray-600"><span class="font-medium">Card Ending:</span> **** ****
                                    **** <?= substr($order['card_number'], -4) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-2">Order Total</h3>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm text-gray-600">Subtotal:</span>
                                <span class="font-medium">₹<?= number_format($subtotal, 2) ?></span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                                <span class="text-gray-900 font-semibold">Total:</span>
                                <span
                                    class="text-gray-900 font-semibold">₹<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Delivery Tracking (if shipped) -->

    </div>

</body>

</html>









<script>
    function showPopup() {
        const popup = document.getElementById('statusPopup');
        const line = document.getElementById('statusLine');
        popup.classList.remove('hidden');
        popup.classList.add('transform', 'translate-y-0', 'transition-all', 'duration-500');
        line.classList.remove('hidden');
        line.classList.add('animate-line');
    }

    function closePopup() {
        const popup = document.getElementById('statusPopup');
        popup.classList.add('hidden');
    }
</script>
<style>
    @keyframes animateLine {
        0% {
            width: 0;
        }

        100% {
            width: 100%;
        }
    }

    .animate-line {
        animation: animateLine 2s forwards;
    }
</style>


<!-- Order Status Popup -->
<div id="statusPopup"
    class="hidden fixed top-16 left-1/2 transform -translate-x-1/2 w-full max-w-md bg-white text-black py-4 px-6 text-center text-lg z-50 shadow-xl rounded-lg mt-4">
    <div>
        <h2 class="font-semibold text-xl">Order Status</h2>
        <div id="statusLine" class="h-1 bg-blue-600 mt-4 hidden"></div>
        <div class="mt-4 space-y-3">
            <?php
            if ($order['status'] == 0) { ?>
                <div class="flex items-center justify-start">
                    <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                    <span>Order Confirmed</span>
                </div>
            <?php } elseif ($order['status'] == 1) { ?>
                <div class="flex items-center justify-start">
                    <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                    <span>Order Confirmed</span>
                </div>
                <div class="flex items-center justify-start">
                    <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                    <span>Preparing for Shipment</span>
                </div>
                <div class="flex items-center justify-start">
                    <span class="w-4 h-4 bg-green-400 rounded-full mr-3"></span>
                    <span>Shipped</span>
                </div>
                <div class="flex items-center justify-start">
                    <span class="w-4 h-4 bg-purple-400 rounded-full mr-3"></span>
                    <span>Out for Delivery</span>
                </div>
                <div class="flex items-center justify-start">
                    <span class="w-4 h-4 bg-teal-400 rounded-full mr-3"></span>
                    <span>Delivered</span>
                </div>


            <?php } elseif ($order['status'] == 2) { ?>
                <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                <span>Order Confirmed</span>
            </div>
            <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                <span>Preparing for Shipment</span>
            </div>


            <?php } elseif ($order['status'] == 3) { ?>
                <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                <span>Order Confirmed</span>
            </div>
            <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                <span>Preparing for Shipment</span>
            </div>
            <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-green-400 rounded-full mr-3"></span>
                <span>Shipped</span>
            </div>

            <?php } elseif ($order['status'] == 4) { ?>
                <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                <span>Order Confirmed</span>
            </div>
            <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                <span>Preparing for Shipment</span>
            </div>
            <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-green-400 rounded-full mr-3"></span>
                <span>Shipped</span>
            </div>
            <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-purple-400 rounded-full mr-3"></span>
                <span>Out for Delivery</span>
            </div>


            
            <?php } elseif ($order['status'] == 5) { ?>
                <div class="flex items-center justify-start">
                <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                <span>Order Canclelled</span>
            </div>
            


            <?php } ?>
           
            
        </div>
    </div>
    <button onclick="closePopup()"
        class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Close</button>
        
</div>

