<?php
include_once "config/connect.php";
if(isset($_SESSION['user'])){
    $user = getUser();
}
// Check if order ID is provided
if(!isset($_GET['order_id'])) {
    header("Location: profile.php");
    exit();
}

$order_id = $_GET['order_id'];
$user_email = $user['email']; // Assuming you have user session

// Fetch order details
$order_query = $connect->query("SELECT * FROM orders WHERE id='$order_id' AND email='$user_email'");
if($order_query->num_rows == 0) {
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
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <!-- Header with back button -->
        <div class="flex justify-between items-center mb-6">
            <a href="profile.php" class="flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Orders
            </a>
            <button onclick="generatePDF()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Download Invoice
            </button>
        </div>

        <!-- Order Summary Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6" id="invoice-content">
            <div class="flex flex-col md:flex-row justify-between mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Order #<?= $order_id ?></h1>
                    <p class="text-gray-600">Placed on <?= date("F j, Y, g:i a", strtotime($order['order_time'])) ?></p>
                    
                    <!-- Order Status Badge -->
                    <?php
                    $status_class = "";
                    $status_text = "";
                    switch($order['status']) {
                        case 1: $status_class = "bg-green-100 text-green-800"; $status_text = "Delivered"; break;
                        case 2: $status_class = "bg-orange-100 text-orange-800"; $status_text = "Shipped"; break;
                        case 3: $status_class = "bg-yellow-100 text-yellow-800"; $status_text = "In Transit"; break;
                        case 4: $status_class = "bg-blue-100 text-blue-800"; $status_text = "Out for Delivery"; break;
                        default: $status_class = "bg-gray-100 text-gray-800"; $status_text = "Processing"; break;
                    }
                    ?>
                    <div class="mt-3">
                        <span class="px-3 py-1 rounded-full text-sm font-medium <?= $status_class ?>">
                            <?= $status_text ?>
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 md:mt-0">
                    <?php
                    $callAdd = $connect->query("select * from user_address where email='$user_email'");
                    $add = $callAdd->fetch_assoc();
                    ?>
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Delivery Address</h2>
                    <p class="text-gray-600"><?= $add['name'] ?></p>
                    <p class="text-gray-600"><?= $add['address'] ?></p>
                    <p class="text-gray-600"><?= $add['city'] ?>, <?= $add['state'] ?> - <?= $add['pincode'] ?></p>
                    <p class="text-gray-600">Phone: <?= $add['mobile'] ?></p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t border-gray-200 pt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Items (<?= $total_items ?>)</h2>
                
                <div class="space-y-4">
                    <?php 
                    $subtotal = 0;
                    while($item = $items_query->fetch_assoc()): 
                        $subtotal += $item['sell_price'] * $item['qty'];
                    ?>
                    <div class="flex flex-col sm:flex-row border-b border-gray-100 pb-4">
                        <div class="flex items-start flex-1">
                            <img src="assets/images/<?= $item['img1'] ?>" alt="<?= $item['book_name'] ?>" class="w-20 h-20 object-cover rounded-lg mr-4">
                            <div>
                                <h3 class="text-md font-medium text-gray-800"><?= $item['book_name'] ?></h3>
                                <p class="text-sm text-gray-600">by <?= $item['book_author'] ?></p>
                                <p class="text-sm text-gray-600 mt-1">Quantity: <?= $item['qty'] ?></p>
                            </div>
                        </div>
                        <div class="mt-3 sm:mt-0 sm:text-right">
                            <p class="text-md font-medium text-gray-800">₹<?= number_format($item['sell_price'] * $item['qty'], 2) ?></p>
                            <p class="text-sm text-gray-600">₹<?= number_format($item['sell_price'], 2) ?> each</p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="mt-8 border-t border-gray-200 pt-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-2">Payment Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-600"><span class="font-medium">Method:</span> <?= ucfirst($order['payment_type']) ?></p>
                            <p class="text-gray-600"><span class="font-medium">Status:</span> <?= $order['status'] == 1 ? 'Paid' : 'Pending' ?></p>
                            <?php if($order['payment_type'] == 'card'): ?>
                            <p class="text-gray-600"><span class="font-medium">Card Ending:</span> **** **** **** <?= substr($order['card_number'], -4) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-md font-medium text-gray-800 mb-2">Order Total</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">₹<?= number_format($subtotal, 2) ?></span>
                            </div>
                            <div class="flex justify-between border-t border-gray-200 pt-2 mt-2">
                                <span class="text-gray-800 font-semibold">Total:</span>
                                <span class="text-gray-800 font-semibold">₹<?= number_format($order['total_amount'], 2) ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delivery Tracking (if shipped) -->
        <?php if($order['status'] > 1): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Delivery Tracking</h2>
            
            <div class="relative">
                <!-- Timeline -->
                <div class="border-l-2 border-gray-200 absolute h-full left-4 top-0"></div>
                
                <!-- Timeline Steps -->
                <div class="space-y-8 relative">
                    <!-- Order Placed -->
                    <div class="flex items-start">
                        <div class="bg-blue-600 rounded-full h-8 w-8 flex items-center justify-center z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-md font-medium text-gray-800">Order Placed</h3>
                            <p class="text-sm text-gray-600 mt-1"><?= date("F j, g:i a", strtotime($order['order_time'])) ?></p>
                        </div>
                    </div>
                    
                    <!-- Processing -->
                    <div class="flex items-start">
                        <div class="<?= $order['status'] >= 1 ? 'bg-blue-600' : 'bg-gray-300' ?> rounded-full h-8 w-8 flex items-center justify-center z-10">
                            <?php if($order['status'] >= 1): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <?php endif; ?>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-md font-medium text-gray-800">Processing</h3>
                            <?php if($order['status'] >= 1): ?>
                            <p class="text-sm text-gray-600 mt-1"><?= date("F j, g:i a", strtotime($order['order_time'] . ' +1 day')) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Shipped -->
                    <?php if($order['status'] >= 2): ?>
                    <div class="flex items-start">
                        <div class="<?= $order['status'] >= 2 ? 'bg-blue-600' : 'bg-gray-300' ?> rounded-full h-8 w-8 flex items-center justify-center z-10">
                            <?php if($order['status'] >= 2): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <?php endif; ?>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-md font-medium text-gray-800">Shipped</h3>
                            <p class="text-sm text-gray-600 mt-1"><?= date("F j, g:i a", strtotime($order['order_time'] . ' +2 days')) ?></p>
                            <p class="text-sm text-gray-600 mt-1">Tracking Number: <?= $order['tracking_number'] ?? 'Not available' ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Delivered -->
                    <?php if($order['status'] >= 1): ?>
                    <div class="flex items-start">
                        <div class="<?= $order['status'] >= 1 ? 'bg-blue-600' : 'bg-gray-300' ?> rounded-full h-8 w-8 flex items-center justify-center z-10">
                            <?php if($order['status'] >= 1): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            <?php endif; ?>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-md font-medium text-gray-800">Delivered</h3>
                            <p class="text-sm text-gray-600 mt-1"><?= date("F j, g:i a", strtotime($order['order_time'] . ' +5 days')) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <script>
        // PDF Generation
        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const element = document.getElementById('invoice-content');
            
            // Show loading
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="animate-pulse">Generating PDF...</span>';
            button.disabled = true;
            
            html2canvas(element, {
                scale: 2,
                logging: false,
                useCORS: true
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 295; // A4 height in mm
                const imgHeight = canvas.height * imgWidth / canvas.width;
                let heightLeft = imgHeight;
                let position = 0;
                
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
                
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }
                
                pdf.save(`Invoice_${<?= $order_id ?>}.pdf`);
                
                // Restore button
                button.innerHTML = originalText;
                button.disabled = false;
            });
        }
    </script>
</body>
</html>