<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}

if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $getbook = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
    $sellerdata = mysqli_fetch_array($getbook);
    if (!$sellerdata) {
        echo "Invalid book ID.";
        exit;
    }
} else {
    echo "No book selected.";
    exit;
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
        <div class="w-4/12 border-r border-gray-300 bg-white">
            <div class="p-4 bg-[#B3D8A8] border-b border-gray-300 flex justify-between items-center">
                <h2 class="text-xl font-bold">INBOX</h2>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-4 border p-3 bg-[#A3D1C6] rounded-lg">
                    <img src="https://img.bookchor.com/images/cover/bc/9780670095940.jpg" class="h-16 w-16 rounded border" />
                    <div>
                        <h2 class="text-lg font-semibold"><?= $sellerdata["fullname"]; ?></h2>
                        <p class="text-sm text-gray-600"><?= $sellerdata["book_name"] ?? "Science Book"; ?></p>
                        <span class="text-xs text-gray-500">Click to chat</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-8/12 bg-white flex flex-col h-[500px] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-4 ml-3">
                    <img src="https://img.bookchor.com/images/cover/bc/9780670095940.jpg" class="h-14 w-14 border rounded-full">
                    <h2 class="text-lg font-semibold"><?= $sellerdata['fullname']; ?></h2>
                </div>
            </div>

            <div class="p-4 flex justify-between mx-6">
                <h2 class="text-xl font-semibold"><?= $sellerdata['book_name'] ?? "Science Book"; ?> :-</h2>
                <p class="text-xl font-semibold text-gray-600">₹ <?= $sellerdata['price'] ?? '100'; ?></p>
            </div>

            <div class="flex-1 p-4 overflow-y-auto h-[400px] bg-gray-100">
                <?php
                $user_id = $user['user_id'];
                $seller_id = $sellerdata['seller_id'];
                $product_id = $sellerdata['id'];

                $sent = $connect->query("SELECT * FROM message WHERE sender_id = '$user_id' AND receiver_id = '$seller_id' AND product_id='$product_id'");
                while ($msg = $sent->fetch_array()):
                ?>
                    <div class="flex items-end justify-end mb-4">
                        <div class="gap-4 grid grid-cols-1">
                            <div class="bg-green-500 text-white p-3 rounded-lg shadow max-w-xs">
                                <p><?= $msg['message']; ?></p>
                                <span class="text-xs text-white"><?= date("h:i A", strtotime($msg['msg_time'])) ?></span>
                            </div>
                        </div>
                        <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" class="h-10 w-10 rounded-full border">
                    </div>
                <?php endwhile; ?>

                <?php
                $received = $connect->query("SELECT * FROM message WHERE sender_id = '$seller_id' AND receiver_id = '$user_id' AND product_id='$product_id'");
                while ($msg = $received->fetch_array()):
                ?>
                    <div class="flex items-start space-x-3 mb-4">
                        <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" class="h-10 w-10 rounded-full border">
                        <div class="bg-white p-3 rounded-lg shadow max-w-xs">
                            <p class="text-gray-700"><?= $msg['message']; ?></p>
                            <span class="text-xs text-gray-500"><?= date("h:i A", strtotime($msg['msg_time'])) ?></span>
                        </div>
                    </div>
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
                $msg = $connect->$_POST['message'];
                $query = $connect->query("INSERT INTO message (product_id, sender_id , receiver_id, message) 
                VALUES('$product_id','$user_id','$seller_id','$msg')");
                if ($query) {
                    echo "<script>window.location.href='chatboard.php?book_id=$product_id';</script>";
                    exit;
                } else {
                    echo "<p class='text-red-500 text-center'>Message not sent!</p>";
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>