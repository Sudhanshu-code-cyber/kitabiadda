<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
    $user_id = $user['user_id'];
} else {
    echo "User not logged in.";
    exit;
}

// Get book_id if provided
$book_id = $_GET['book_id'] ?? null;
$sellerdata = null;

if ($book_id) {
    $getbook = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
    $sellerdata = mysqli_fetch_array($getbook);
    if (!$sellerdata) {
        echo "Invalid book ID.";
        exit;
    }
}

// Get chat list
$chatUsersQuery = $connect->query("SELECT DISTINCT seller_id, books.id as book_id, books.book_name, users.name 
    FROM message 
    JOIN books ON message.product_id = books.id 
    JOIN users ON books.seller_id = users.user_id 
    WHERE message.sender_id = '$user_id' OR message.receiver_id = '$user_id'
    ORDER BY message.msg_time DESC");

$chatList = [];
while ($chatRow = mysqli_fetch_assoc($chatUsersQuery)) {
    $chatList[] = $chatRow;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4]">

    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="flex mt-36 border-t border-gray-300">
        <!-- LEFT: Chat List -->
        <div class="w-4/12 border-r border-gray-300 bg-white h-[600px] overflow-y-auto">
            <div class="p-4 bg-[#B3D8A8] border-b border-gray-300">
                <h2 class="text-xl font-bold">INBOX</h2>
            </div>
            <?php foreach ($chatList as $chat):
                // Get image from books table for this chat's book
                $bookImgQuery = $connect->query("SELECT img1 FROM books WHERE id = '{$chat['book_id']}'");
                $bookImgRow = mysqli_fetch_assoc($bookImgQuery);
                $bookImg = $bookImgRow['img1'] ?? "defaultBook.png"; // fallback image
            ?>
                <a href="chatboard.php?book_id=<?= $chat['book_id']; ?>">
                    <div class="flex items-center gap-4 border p-3 bg-[#A3D1C6] rounded-lg hover:bg-[#8fc3ba] transition">
                        <img src="assets/images/<?= $bookImg; ?>" class="h-14 w-14 rounded border" />
                        <div>
                            <h2 class="text-md font-semibold"><?= htmlspecialchars($chat["name"]); ?></h2>
                            <p class="text-sm text-gray-600"><?= htmlspecialchars($chat["book_name"]); ?></p>
                            <span class="text-xs text-gray-500">Click to chat</span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>

        <!-- RIGHT: Chat Window -->
        <?php if ($sellerdata): ?>
            <div class="w-8/12 bg-white flex flex-col h-[600px] overflow-hidden" id="chatBox">
                <!-- Header -->
                <div class="flex items-center justify-between p-6 border-b">
                    <div class="flex items-center">
                        <img src="assets/images/<?= $sellerdata['img1']; ?>" class="h-14 w-14 border rounded-full">
                        <h2 class="text-lg m-4 font-semibold"><?= htmlspecialchars($chat['name']); ?></h2>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Call Button Trigger -->
                        <!-- Trigger Button (Outside Modal) -->
                        <button data-modal-target="callModal" data-modal-toggle="callModal"
                            class="text-white  hover:bg-green-600 text-sm border border-green-400 px-3 py-1 rounded">
                            📞
                        </button>

                        <!-- Flowbite Modal for Calling Seller -->
                        <div id="callModal" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-screen bg-black/50 backdrop-blur-sm">
                            <div class="relative w-full max-w-md max-h-full m-auto mt-24">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Close button -->
                                    <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                                        data-modal-hide="callModal">
                                        ✖
                                    </button>

                                    <!-- Modal content -->
                                    <div class="p-6 text-center">
                                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Contact Seller</h3>

                                        <p class="text-gray-600 dark:text-gray-300">Seller Name:</p>
                                        <h2 class="text-xl font-bold text-green-700 mb-2"><?= htmlspecialchars($chat['name']); ?></h2>

                                        <p class="text-gray-600 dark:text-gray-300">Phone Number:</p>
                                        <h2 class="text-xl font-bold text-blue-700 mb-4"><?= htmlspecialchars($chat[' '] ?? 'Not Available'); ?></h2>

                                        <a href="tel:<?= $chat['contact'] ?? '' ?>"
                                            class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded-lg">
                                            📞 Call Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Close Chat -->
                        <a href="chatboard.php"
                            class="text-red-500 hover:text-red-700 text-sm border border-red-400 px-3 py-1 rounded">
                            ✖
                        </a>
                    </div>
                </div>

                <!-- Book Info -->
                <div class="p-4 flex justify-between mx-6">
                    <h2 class="text-xl font-semibold"><?= $sellerdata['book_name'] ?? "Science Book"; ?> :-</h2>
                    <p class="text-xl font-semibold text-gray-600">₹ <?= $sellerdata['price'] ?? '100'; ?></p>
                </div>

                <!-- Messages -->
                <div class="flex-1 p-4 overflow-x-auto h-[100px] bg-gray-200">
                    <?php
                    $seller_id = $sellerdata['seller_id'];
                    $product_id = $sellerdata['id'];

                    $messages = $connect->query("SELECT * FROM message WHERE 
                        ((sender_id = '$user_id' AND receiver_id = '$seller_id') OR 
                        (sender_id = '$seller_id' AND receiver_id = '$user_id')) 
                        AND product_id='$product_id' ORDER BY msg_time ASC");

                    while ($msg = $messages->fetch_array()):
                        $isSender = ($msg['sender_id'] == $user_id);
                    ?>
                        <?php if ($isSender): ?>
                            <div class="flex items-end justify-end mb-4">
                                <div class="gap-4 grid grid-cols-1">
                                    <div class="bg-green-500 text-white p-3 rounded-lg shadow max-w-xs">
                                        <p><?= $msg['message']; ?></p>
                                        <span class="text-xs text-white"><?= date("h:i A", strtotime($msg['msg_time'])) ?></span>
                                    </div>
                                </div>
                                <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" class="h-10 w-10 rounded-full border ml-2">
                            </div>
                        <?php else: ?>
                            <div class="flex items-start space-x-3 mb-4">
                                <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" class="h-10 w-10 rounded-full border">
                                <div class="bg-white p-3 rounded-lg shadow max-w-xs">
                                    <p class="text-gray-700"><?= $msg['message']; ?></p>
                                    <span class="text-xs text-gray-500"><?= date("h:i A", strtotime($msg['msg_time'])) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>

                <!-- Chat Input -->
                <div class="p-4 border-t flex items-center gap-2 bg-white">
                    <form action="" method="post" class="flex w-full gap-2">
                        <input type="text" name="message" placeholder="Type a message..." class="flex-1 p-3 border rounded-lg outline-none focus:ring focus:ring-green-200" required>
                        <button name="send_msg" class="bg-green-500 text-white p-3 rounded-lg shadow hover:bg-green-600 transition">
                            Send
                        </button>
                    </form>
                </div>

                <?php
                if (isset($_POST['send_msg'])) {
                    $msg = mysqli_real_escape_string($connect, $_POST['message']);
                    $query = $connect->query("INSERT INTO message (product_id, sender_id, receiver_id, message) 
                        VALUES('$product_id', '$user_id', '$seller_id', '$msg')");

                    if ($query) {
                        echo "<script>window.location.href='chatboard.php?book_id=$product_id';</script>";
                        exit;
                    } else {
                        echo "<p class='text-red-500 text-center'>Message not sent!</p>";
                    }
                }
                ?>
            </div>
        <?php else: ?>
            <div class="w-8/12 bg-white flex items-center justify-center h-[600px] text-gray-500 text-lg" id="noChat">
                No chat selected
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>