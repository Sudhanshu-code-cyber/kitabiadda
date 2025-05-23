<?php
include_once "config/connect.php";

// Check if order ID is provided
if (!isset($_GET['sell_id'])) {
    header("Location: profile.php");
    exit();
}

$sell_id = $_GET['sell_id'];
$callSelledBook = $connect->query("select * from books where id='$sell_id'");
$selled_item= $callSelledBook->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sold Product - <?= htmlspecialchars($selled_item['book_name']) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php";?>
    <div class="container mx-auto mt-14 py-8 px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Product Details Section -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-4"><?= htmlspecialchars($selled_item['book_name']) ?></h1>
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Product Images -->
                        <div class="md:w-1/3">
                            <img src="assets/images/<?= htmlspecialchars($selled_item['img1']) ?>" 
                                 alt="<?= htmlspecialchars($selled_item['book_name']) ?>" 
                                 class="w-full h-auto rounded-lg object-cover">
                        </div>
                        
                        <!-- Product Info -->
                        <div class="md:w-2/3">
                            <div class="mb-4">
                                <span class="inline-block bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full mb-2">
                                    Sold On <?= date('M j, Y', strtotime($selled_item['post_date'])) ?>
                                </span>
                            </div>
                            
                            <div class="space-y-3">
                                <p class="text-gray-700"><span class="font-semibold">Price:</span> ₹<?= number_format($selled_item['sell_price'], 2) ?></p>
                                <p class="text-gray-700"><span class="font-semibold">Category:</span> <?= htmlspecialchars($selled_item['book_category']) ?></p>
                                <p class="text-gray-700"><span class="font-semibold">Condition:</span> <?= ucfirst($selled_item['quality']) ?></p>
                                <p class="text-gray-700"><span class="font-semibold">Description:</span> <?= htmlspecialchars($selled_item['book_description']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Chat Section -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-[#B3D8A8] text-white p-4">
                        <h2 class="text-lg font-semibold">Chat History</h2>
                    </div>
                    
                    <div class="h-96 overflow-y-auto p-4 space-y-4">
                        <?php if (empty($chats)): ?>
                            <p class="text-gray-500 text-center py-8">No messages yet</p>
                        <?php else: ?>
                            <?php foreach ($chats as $chat): ?>
                                <div class="flex gap-3 <?= $chat['sender_id'] == $_SESSION['user_id'] ? 'justify-end' : '' ?>">
                                    <?php if ($chat['sender_id'] != $_SESSION['user_id']): ?>
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 overflow-hidden">
                                            <?php if (!empty($chat['profile_pic'])): ?>
                                                <img src="<?= htmlspecialchars($chat['profile_pic']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <i class="fas fa-user text-gray-400 text-xl m-2"></i>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="<?= $chat['sender_id'] == $_SESSION['user_id'] ? 'bg-blue-100' : 'bg-gray-100' ?> rounded-lg p-3 max-w-xs">
                                        <?php if ($chat['sender_id'] != $_SESSION['user_id']): ?>
                                            <p class="text-sm font-semibold"><?= htmlspecialchars($chat['sender_name']) ?></p>
                                        <?php endif; ?>
                                        <p class="text-gray-800"><?= htmlspecialchars($chat['message']) ?></p>
                                        <p class="text-xs text-gray-500 mt-1"><?= date('g:i a', strtotime($chat['created_at'])) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>