<?php
include_once "config/connect.php";
redirectIfNotAuth();
if (isset($_SESSION['user'])) {
    $user = getUser();
    $user_id = $user['user_id'];
}

$book_id = $_GET['book_id'] ?? null;
$sellerdata = null;
$sellerInfo = null;

if ($book_id) {
    $getbook = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
    $sellerdata = mysqli_fetch_array($getbook);

    if ($sellerdata) {
        $seller_id = $sellerdata['seller_id'];
        $getSellerInfo = $connect->query("SELECT name, contact FROM users WHERE user_id = '$seller_id'");
        $sellerInfo = mysqli_fetch_assoc($getSellerInfo);
    }
}

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

// Handle message sending
if (isset($_POST['send_msg']) && !empty($_POST['message']) && $book_id && $sellerdata) {
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $insert = $connect->query("INSERT INTO message (sender_id, receiver_id, product_id, message, msg_time) 
                              VALUES ('$user_id', '$seller_id', '$book_id', '$message', NOW())");
    if ($insert) {
        header("Location: chatboard.php?book_id=$book_id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        #chatMessages {
            scrollbar-width: thin;
            scrollbar-color: #9CA3AF #F3F4F6;
        }

        #chatMessages::-webkit-scrollbar {
            width: 6px;
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background-color: #9CA3AF;
            border-radius: 4px;
        }

        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .chat-container {
                height: calc(100vh - 56px);
            }

            .chat-list {
                height: 100%;
                display: <?= $book_id ? 'none' : 'block' ?>;
            }

            .chat-window {
                height: 100%;
                display: <?= $book_id ? 'flex' : 'none' ?>;
            }

            .back-button {
                display: flex !important;
            }
        }
    </style>
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>

    <div class="chat-container flex flex-col lg:flex-row mt-16 lg:mt-36">
        <!-- Mobile back button (only visible in mobile view when chat is open) -->
        <div class="lg:hidden back-button items-center p-2 bg-[#B3D8A8] hidden <?= $book_id ? 'flex' : 'hidden' ?>">
            <a href="chatboard.php" class="text-gray-700 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to conversations
            </a>
        </div>

        <!-- Chat List -->
        <div class="chat-list w-full lg:w-4/12 border-r border-gray-300 bg-white lg:h-[600px] h-full overflow-y-auto">
            <div class="p-4 bg-[#B3D8A8] border-b border-gray-300 text-center lg:text-left sticky top-0 z-10">
                <h2 class="text-xl font-bold">INBOX</h2>
            </div>
            <?php if (!empty($chatList)): ?>
                <?php foreach ($chatList as $chat):
                    $bookImgQuery = $connect->query("SELECT img1 FROM books WHERE id = '{$chat['book_id']}'");
                    $bookImgRow = mysqli_fetch_assoc($bookImgQuery);
                    $activeClass = ($book_id == $chat['book_id']) ? 'bg-[#8fc3ba]' : 'bg-[#A3D1C6]';
                ?>
                    <a href="chatboard.php?book_id=<?= $chat['book_id']; ?>" class="block">
                        <div class="flex items-center gap-4 p-3 <?= $activeClass ?> rounded-lg hover:bg-[#8fc3ba] transition">
                            <img src="assets/images/<?= $bookImgRow['img1']; ?>" class="h-14 w-14 rounded border object-cover" />
                            <div class="flex-1 min-w-0">
                                <h2 class="text-md font-semibold truncate"><?= htmlspecialchars($chat["name"]); ?></h2>
                                <p class="text-sm text-gray-600 truncate"><?= htmlspecialchars($chat["book_name"]); ?></p>
                                <span class="text-xs text-gray-500">Click to chat</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="p-6 text-gray-500 text-center">No conversations yet.</div>
            <?php endif; ?>
        </div>

        <!-- Chat Window -->
        <?php if ($sellerdata && $sellerInfo): ?>
            <div class="chat-window w-full lg:w-8/12 bg-white flex flex-col lg:h-[600px] h-[calc(100vh-112px)]">
                <div class="flex items-center justify-between p-4 border-b sticky top-0 bg-white z-10">
                    <div class="flex items-center">
                        <div class="lg:hidden mr-2">
                            <a href="chatboard.php" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                        <h2 class="text-lg font-semibold"><?= htmlspecialchars($sellerInfo['name']); ?></h2>
                    </div>
                    <a href="chatboard.php" class="text-red-500 hover:text-red-700 text-sm hidden lg:block">✖</a>
                </div>

                <div class="p-4 flex justify-between mx-2 lg:mx-6 border-b">
                    <div class="flex items-center">
                        <img src="assets/images/<?= $sellerdata['img1']; ?>" class="h-12 w-12 rounded border mr-3 lg:mr-0 lg:hidden" />
                        <h2 class="text-lg lg:text-xl font-semibold truncate max-w-[180px] lg:max-w-none"><?= htmlspecialchars($sellerdata['book_name']); ?></h2>
                    </div>
                    <p class="text-lg lg:text-xl font-semibold text-gray-600">₹ <?= $sellerdata['sell_price']; ?></p>
                </div>

                <div class="flex-1 p-4 overflow-y-auto bg-gray-200" id="chatMessages">
                    <?php
                    $messages = $connect->query("SELECT * FROM message WHERE 
                        ((sender_id = '$user_id' AND receiver_id = '$seller_id') OR 
                        (sender_id = '$seller_id' AND receiver_id = '$user_id')) 
                        AND product_id='$book_id' ORDER BY msg_time ASC");

                    while ($msg = $messages->fetch_array()):
                        $isSender = ($msg['sender_id'] == $user_id);
                    ?>
                        <div class="flex <?= $isSender ? 'justify-end' : 'justify-start' ?> mb-4">
                            <div class="p-3 rounded-lg max-w-[70%] lg:max-w-xs <?= $isSender ? 'bg-green-500 text-white' : 'bg-white' ?>">
                                <p><?= htmlspecialchars($msg['message']); ?></p>
                                <span class="text-xs text-gray-500 block text-right"><?= date("h:i A", strtotime($msg['msg_time'])) ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="p-3 lg:p-4 border-t flex items-center gap-2 bg-white sticky bottom-0">
                    <form action="" method="post" class="flex w-full gap-2">
                        <input type="text" name="message" placeholder="Type a message..." class="flex-1 p-2 lg:p-3 border rounded-lg focus:outline-none focus:ring-1 focus:ring-green-500" required>
                        <button name="send_msg" class="bg-green-500 hover:bg-green-600 text-white p-2 lg:p-3 rounded-lg transition">
                            <i class="fas fa-paper-plane lg:mr-1"></i>
                            <span class="hidden lg:inline">Send</span>
                        </button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="chat-window w-full lg:w-8/12 bg-white flex items-center justify-center lg:h-[600px] h-[calc(100vh-112px)] text-gray-500 text-lg">
                <div class="text-center p-6">
                    <i class="fas fa-comments text-4xl mb-3 text-gray-300"></i>
                    <p>No chat selected</p>
                    <p class="text-sm mt-2">Select a conversation from the list</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        window.onload = function() {
            const chatMessages = document.getElementById("chatMessages");
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Auto-focus message input when chat opens
            const messageInput = document.querySelector("input[name='message']");
            if (messageInput) {
                messageInput.focus();
            }
        };

        // Handle mobile view transitions
        document.addEventListener('DOMContentLoaded', function() {
            // This ensures proper display when navigating back
            if (window.innerWidth <= 768) {
                const urlParams = new URLSearchParams(window.location.search);
                const bookId = urlParams.get('book_id');

                if (bookId) {
                    document.querySelector('.chat-list').style.display = 'none';
                    document.querySelector('.chat-window').style.display = 'flex';
                } else {
                    document.querySelector('.chat-list').style.display = 'block';
                    document.querySelector('.chat-window').style.display = 'none';
                }
            }
        });
    </script>
</body>

</html>