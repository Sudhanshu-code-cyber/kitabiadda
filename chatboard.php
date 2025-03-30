<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
    $user_id = $user['user_id'];
} else {
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
                allowOutsideClick: false, 
                allowEscapeKey: false, 
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php'; 
                } else if (result.isDenied) {
                    window.location.href = 'index.php';
                }
            });

            // ⏳ 5 सेकंड बाद Auto Redirect पिछले पेज पर
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 5000);
        });
    </script>";

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
    <?php include_once "includes/subheader.php"; ?>

    <div class="chat-container flex flex-col lg:flex-row mt-16 lg:mt-32">
        <!-- Mobile back button (only visible in mobile view when chat is open) -->
        <div class="lg:hidden back-button items-center p-2 bg-[#B3D8A8] hidden <?= $book_id ? 'flex' : 'hidden' ?>">
            <a href="chatboard.php" class="text-gray-700 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to conversations
            </a>
        </div>

        <!-- Chat List -->
        <div class="chat-list w-full lg:w-4/12 border-r border-gray-200 bg-white lg:h-[600px] h-full overflow-y-auto shadow-sm">
            <!-- Header with Search -->
            <div class="p-4 bg-gradient-to-r from-[#B3D8A8] to-[#9BC58D] flex flex-col sm:flex-row justify-between items-center gap-3 border-b border-gray-200 sticky top-0 z-10">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    INBOX
                </h2>
                <form action="" method="get" class="w-full sm:w-auto">
                    <div class="relative flex rounded-lg shadow-md ring-1  ring-white/20 focus-within:ring-2 focus-within:ring-[#3D8D7A] transition-all duration-200">
                        <input type="search"
                            name="search_users"
                            placeholder="Search conversations..."
                            class="block w-full px-4 py-2 bg-white/90 rounded-l-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-0 text-sm"
                            aria-label="Search conversations">
                        <button type="submit"
                            name="search"
                            class="inline-flex  border-3  items-center px-4 py-2 bg-[#3D8D7A] text-white font-medium rounded-r-lg hover:bg-[#2c6b5b] transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Chat List -->
            <?php if (!empty($chatList)): ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($chatList as $chat):
                    if(isset($_POST['search'])){
                        $search = $_POST['search_users'];

                        $query = $connect->query("select * from users where ");

                    }



                        $bookImgQuery = $connect->query("SELECT img1 FROM books WHERE id = '{$chat['book_id']}'");
                        $bookImgRow = mysqli_fetch_assoc($bookImgQuery);
                        $activeClass = ($book_id == $chat['book_id']) ? 'bg-[#E8F5F2] border-l-4 border-[#3D8D7A]' : 'hover:bg-gray-50';

                        // Get last message ID for delete functionality
                        $lastMsgQuery = $connect->query("SELECT message_id FROM message 
                                   WHERE (sender_id = '$user_id' OR receiver_id = '$user_id')
                                   AND product_id = '{$chat['book_id']}'
                                   ORDER BY msg_time DESC LIMIT 1");
                        $lastMsg = mysqli_fetch_assoc($lastMsgQuery);
                    ?>
                        <div class="relative">
                            <a href="chatboard.php?book_id=<?= $chat['book_id']; ?>" class="block transition duration-150 ease-in-out <?= $activeClass ?>">
                                <div class="flex items-center gap-4 p-4 rounded-lg">
                                    <div class="relative flex-shrink-0">
                                        <img src="assets/images/<?= $bookImgRow['img1']; ?>" class="h-14 w-14 rounded-lg object-cover border border-gray-200 shadow-sm" />
                                        <?php if (rand(0, 1)): ?>
                                            <span class="absolute -top-1 -right-1 h-3 w-3 rounded-full bg-green-500 border-2 border-white"></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between items-baseline">
                                            <h2 class="text-sm font-semibold text-gray-800 truncate"><?= htmlspecialchars($chat["name"]); ?></h2>
                                            <p class="text-xs text-gray-500"><?= date('h:i A', strtotime($chat['last_message_time'] ?? 'now')) ?></p>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate"><?= htmlspecialchars($chat["book_name"]); ?></p>
                                        <p class="text-xs text-gray-500 mt-1 truncate">
                                            <?= !empty($chat['last_message']) ? htmlspecialchars($chat['last_message']) : 'Start a conversation' ?>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- Delete Icon - Now using correct message ID -->
                            <?php if ($lastMsg): ?>

                                <a
                                    href="?chat_id=<?= $lastMsg['message_id']; ?>"
                                    onclick="return confirm('Are you sure you want to delete this chat?');"
                                    class="absolute top-10 right-2 text-red-600 hover:text-red-800 transition">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="size-6 text-gray-400">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </a>
                                <?php
                                if (isset($_GET['chat_id'])) {
                                    $chat_id = $_GET['chat_id'];

                                    $query = $connect->query("DELETE FROM message WHERE message_id='$chat_id'");

                                    if ($query) {
                                        // Redirect immediately to remove chat_id from URL
                                       redirect("chatboard.php");
                                        exit();
                                    }
                                }
                                ?>

                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-500">No conversations yet</h3>
                    <p class="text-sm text-gray-400 mt-1">Start a chat to see messages here</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Chat Window -->
        <?php if ($sellerdata && $sellerInfo): ?>
            <div class="chat-window w-full lg:w-8/12 bg-white flex flex-col lg:h-[600px] h-[calc(100vh-112px)]">
                <div class="flex items-center justify-between p-8 border-b sticky top-0 bg-white z-10">
                    <div class="flex items-center gap-3">
                        <div class="lg:hidden mr-2">
                            <a href="chatboard.php" class="text-gray-600 hover:text-gray-800">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </div>
                        <img src="assets/images/<?= $bookImgRow['img1']; ?>" class="h-14 w-14 rounded-lg object-cover border border-gray-200 shadow-sm" />
                        <h2 class="text-lg font-semibold"><?= htmlspecialchars($sellerInfo['name']); ?></h2>
                    </div>
                    <div class="flex justify-center items-center gap-10">

                        <a href="chatboard.php" class="text-red-500 hover:text-red-700 text-sm hidden lg:block">✖</a>
                    </div>
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