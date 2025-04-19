<?php
include_once "config/connect.php";
if (!isset($_SESSION['user'])) {
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
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php'; 
                } else if (result.isDenied) {
                    window.location.href = 'index.php';
                }
            });

            setTimeout(() => {
                window.location.href = 'login.php';
            }, 5000);
        });
    </script>";
    exit();
}

$user = getUser();
$user_id = $user['user_id'];

$searchUser = isset($_GET['search_users']) ? trim($_GET['search_users']) : '';
$book_id = $_GET['book_id'] ?? null;
$chat_with = $_GET['chat_with'] ?? null;

// ✅ Handle message sending
if (isset($_POST['send_msg']) && !empty($_POST['message'])) {
    $message = mysqli_real_escape_string($connect, $_POST['message']);
    $receiver_id = $_POST['receiver_id'] ?? null;

    if ($book_id && $receiver_id) {
        // 1. Save Message
        $send_message = $connect->query("INSERT INTO message (sender_id, receiver_id, product_id, message) 
                         VALUES ('$user_id', '$receiver_id', '$book_id', '$message')");

        // 2. If Insert Success
        if ($send_message) {
            // 3. Get Receiver Email
            $receiver_query = $connect->query("SELECT email, name FROM users WHERE user_id = '$receiver_id'");
            $receiver = $receiver_query->fetch_assoc();
            $receiver_email = $receiver['email'];
            $receiver_name = $receiver['name'];

            // 4. Get Sender Name
            $sender_query = $connect->query("SELECT name FROM users WHERE user_id = '$user_id'");
            $sender = $sender_query->fetch_assoc();
            $sender_name = $sender['name'];

            // fetch book detail 
            $fetch_book_msg_query = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
            $fetch_book_msg = $fetch_book_msg_query->fetch_assoc();
            $book_msg_img = $fetch_book_msg['img1'];
            $book_msg_name = $fetch_book_msg['book_name'];
            $book_msg_price = $fetch_book_msg['sell_price'];


            // 5. Prepare Email
            $subject = "New Message from $sender_name - KitabiAdda";
            $email_message = "
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .product-img {
            max-width: 100%;
                    height: auto;
                    border-radius: 8px;
                    margin-top: 20px;
        }
        .product-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0 5px;
        }
        .product-price {
            font-size: 16px;
            color: green;
        }
        .offer-box {
            background: #f9f9f9;
            padding: 15px;
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }
        .user-name {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        .offered-price {
            background: #e0e0e0;
            padding: 8px 15px;
            display: inline-block;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
        }
        .reply-btn {
            background-color: #2979ff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 6px;
            display: inline-block;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class='container'>
        <img src='https://kitabiadda.com/assets/images/$book_msg_img' alt='Book Image' class='product-img'>

        <div class='product-title'> book Name : $book_msg_name</div>
        <div class='product-price'>Price : ₹$book_msg_price</div>

        <div style='margin-top: 10px; font-size: 13px; color: #777;'>from</div>

        <div class='offer-box'>
            <div style='width:80px;height:80px;background:#ddd;border-radius:5px;margin:auto;'></div>
            <div class='user-name'>$sender_name</div>
            <div class='offered-price'>$message</div>
            <br>
            <a href='https://kitabiadda.com/chatboard.php?book_id=$book_id&chat_with=$user_id' class='reply-btn'>REPLY NOW</a>
        </div>

        <div class='footer'>
            <p>This is an automated email. Do not reply.</p>
        </div>
    </div>
</body>
</html>
";


            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: KitabiAdda <no-reply@kitabiadda.in>\r\n";

            // 6. Send Email
            mail($receiver_email, $subject, $email_message, $headers);
        }

        // 7. Redirect after message sent
        header("Location: chatboard.php?book_id=$book_id" . ($chat_with ? "&chat_with=$chat_with" : ""));
        exit();
    }
}


// ✅ Handle chat deletion
if (isset($_GET['delete_chat'])) {
    $product_id = $_GET['product_id'];
    $other_user = $_GET['other_user'];

    $connect->query("DELETE FROM message 
        WHERE product_id = '$product_id' 
        AND ((sender_id = '$user_id' AND receiver_id = '$other_user')
        OR (sender_id = '$other_user' AND receiver_id = '$user_id'))");

    header("Location: chatboard.php");
    exit();
}

// ✅ Get chat list
$chatUsersQuery = $connect->query("
    SELECT 
        c.product_id,
        c.other_user_id,
        u.name as other_user_name,
        u.dp as other_user_dp,
        b.book_name,
        b.img1 as book_image,
        b.seller_id,
        m.message as last_message,
        m.msg_time as last_message_time,
        c.unread_count
    FROM (
        SELECT 
            product_id,
            CASE 
                WHEN sender_id = '$user_id' THEN receiver_id
                ELSE sender_id
            END as other_user_id,
            MAX(message_id) as last_message_id,
            COUNT(CASE WHEN receiver_id = '$user_id' AND is_read = 0 THEN 1 END) as unread_count
        FROM message
        WHERE sender_id = '$user_id' OR receiver_id = '$user_id'
        GROUP BY product_id, other_user_id
    ) as c
    JOIN message m ON m.message_id = c.last_message_id
    JOIN users u ON u.user_id = c.other_user_id
    JOIN books b ON b.id = c.product_id
    " . ($searchUser ? "WHERE (u.name LIKE '%$searchUser%' OR b.book_name LIKE '%$searchUser%' OR m.message LIKE '%$searchUser%')" : "") . "
    ORDER BY m.msg_time DESC
");

$chatList = [];
while ($chatRow = mysqli_fetch_assoc($chatUsersQuery)) {
    $chatList[] = $chatRow;
}

// ✅ Get current chat messages if book_id is provided
$currentChat = $sellerInfo = $otherUserInfo = $bookInfo = $messages = null;

if ($book_id) {
    $bookInfo = $connect->query("SELECT * FROM books WHERE id = '$book_id'")->fetch_assoc();

    if ($bookInfo) {
        $sellerInfo = $connect->query("SELECT * FROM users WHERE user_id = '{$bookInfo['seller_id']}'")->fetch_assoc();

        $chatPartner = $chat_with ?? $bookInfo['seller_id'];
        $otherUserInfo = $connect->query("SELECT * FROM users WHERE user_id = '$chatPartner'")->fetch_assoc();

        // Mark as read
        $connect->query("UPDATE message 
                         SET is_read = 1 
                         WHERE product_id = '$book_id' 
                         AND sender_id = '$chatPartner' 
                         AND receiver_id = '$user_id'");

        // Fetch messages
        $messages = $connect->query("
            SELECT m.*, u.name as sender_name, u.dp as sender_dp 
            FROM message m
            JOIN users u ON u.user_id = m.sender_id
            WHERE product_id = '$book_id' 
            AND ((sender_id = '$user_id' AND receiver_id = '$chatPartner')
            OR (sender_id = '$chatPartner' AND receiver_id = '$user_id'))
            ORDER BY msg_time ASC
        ");
    }
}

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $query = $connect->query("DELETE FROM message WHERE product_id='$product_id'");
    if ($query) {
        header("Location: chatboard.php");
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
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Base chat container styles */
        .chat-container {
            height: calc(100vh - 112px);
            display: flex;
            flex-direction: column;
        }

        /* Chat list styles */
        .chat-list {
            height: 100%;
            overflow-y: auto;
            width: 100%;
        }

        /* Chat window styles */
        .chat-window {
            height: 100%;
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 20px;
        }

        .unread-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        /* Message bubbles */
        .message-bubble {
            max-width: 80%;
            word-wrap: break-word;
        }

        /* Responsive breakpoints */
        @media (min-width: 640px) {
            .message-bubble {
                max-width: 70%;
            }
        }

        @media (min-width: 768px) {
            .message-bubble {
                max-width: 60%;
            }

            .chat-container {
                flex-direction: row;
            }

            .chat-list {
                width: 40%;
                border-right: 1px solid #e5e7eb;
            }

            .chat-window {
                width: 60%;
            }
        }

        @media (min-width: 1024px) {
            .chat-list {
                width: 30%;
            }

            .chat-window {
                width: 70%;
            }

            .message-bubble {
                max-width: 50%;
            }
        }

        /* Mobile specific styles */
        .mobile-chat-header {
            display: flex;
            align-items: center;
            padding: 12px;
            background-color: #3D8D7A;
            color: white;
        }

        .back-button {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }

        #call-drawer {
            height: auto;
            max-height: 80vh;
            overflow-y: auto;
            border-radius: 0.5rem 0 0 0.5rem;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
        }

        #call-drawer img {
            border: 2px solid #3D8D7A;
        }

        #open-drawer {
            background-color: #3D8D7A;
            transition: background-color 0.3s;
        }

        #open-drawer:hover {
            background-color: #2c6b5b;
        }

        #drawer-backdrop {
            z-index: 40;
        }
    </style>
</head>

<body class="bg-gray-100">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="mt-30 chat-container">
        <!-- Chat List - Always visible on desktop, toggleable on mobile -->
        <div class="chat-list bg-white <?= ($book_id && $otherUserInfo && $bookInfo) ? 'hidden md:block' : 'block' ?>">
            <div class="p-4 bg-[#3D8D7A] text-white sticky top-0 z-10">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-comments mr-2"></i>
                    My Chats
                </h2>
                <form action="" method="get" class="mt-3">
                    <div class="relative">
                        <input type="search" name="search_users" value="<?= htmlspecialchars($searchUser) ?>"
                            placeholder="Search conversations..."
                            class="w-full px-4 py-2 rounded-lg bg-white text-gray-800 focus:outline-none">
                        <button type="submit" class="absolute right-3 top-2 text-gray-500">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php if (!empty($searchUser)): ?>
                <div class="p-2 bg-gray-50 text-center text-sm text-gray-600">
                    <?php if (!empty($chatList)): ?>
                        Showing results for: "<span class="font-medium"><?= htmlspecialchars($searchUser) ?></span>"
                    <?php else: ?>
                        No results found for: "<span class="font-medium"><?= htmlspecialchars($searchUser) ?></span>"
                    <?php endif; ?>
                    <a href="chatboard.php" class="ml-2 text-green-600 hover:underline">Clear search</a>
                </div>
            <?php endif; ?>

            <?php if (!empty($chatList)): ?>
                <div class="relative divide-y divide-gray-200">
                    <?php foreach ($chatList as $chat):
                        $isActive = ($book_id == $chat['product_id'] && (!$chat_with || $chat_with == $chat['other_user_id']));
                        ?>
                        <div class="group relative hover:bg-gray-50 <?= $isActive ? 'bg-gray-100' : '' ?> transition-all">
                            <a href="chatboard.php?book_id=<?= $chat['product_id'] ?>&chat_with=<?= $chat['other_user_id'] ?>"
                                class="block p-4 pr-10"> <!-- Added pr-10 for delete button space -->
                                <div class="flex items-center">
                                    <div class="relative mr-3">
                                        <img src="assets/user_dp/<?= $chat['other_user_dp'] ?: 'default.jpg' ?>"
                                            class="h-12 w-12 rounded-full object-cover border">
                                        <?php if ($chat['unread_count'] > 0): ?>
                                            <span class="unread-badge"><?= $chat['unread_count'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between">
                                            <h3 class="font-semibold truncate"><?= htmlspecialchars($chat['other_user_name']) ?>
                                            </h3>
                                            <span class="text-xs text-gray-500">
                                                <?= date('h:i A', strtotime($chat['last_message_time'])) ?>
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 truncate"><?= htmlspecialchars($chat['book_name']) ?>
                                        </p>
                                        <p class="text-xs text-gray-500 truncate mt-1">
                                            <?= strlen($chat['last_message']) > 50 ?
                                                substr(htmlspecialchars($chat['last_message']), 0, 50) . '...' :
                                                htmlspecialchars($chat['last_message']) ?>
                                        </p>
                                    </div>
                                </div>
                            </a>

                            <!-- In your chat list HTML -->
                            <a href="?product_id=<?= $chat['product_id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this chat?');"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-red-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-comment-slash text-4xl mb-3"></i>
                    <p>No conversations yet</p>
                    <p class="text-sm mt-2">Start a conversation to see messages here</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Chat Window - Hidden on mobile when not viewing a chat -->
        <div
            class="chat-window <?= ($book_id && $otherUserInfo && $bookInfo) ? 'block' : 'hidden' ?> md:block bg-white">
            <?php if ($book_id && $otherUserInfo && $bookInfo): ?>
                <!-- Mobile header with back button -->


                <!-- Desktop header -->
                <div class="md:block border-b sticky top-0 bg-white z-10">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center">
                            <img src="assets/user_dp/<?= $otherUserInfo['dp'] ?: 'default.jpg' ?>"
                                class="h-10 w-10 rounded-full object-cover border mr-3">
                            <div>
                                <h3 class="font-semibold"><?= htmlspecialchars($otherUserInfo['name']) ?></h3>
                                <p class="text-xs text-gray-500">
                                    <?= $otherUserInfo['user_id'] == $bookInfo['seller_id'] ? 'Seller' : 'Buyer' ?></p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <button id="open-drawer"
                                class="px-4 ml-4 py-2 bg-[#3D8D7A] text-white rounded-md hover:bg-[#2c6b5b] transition">
                                <i class="fas fa-phone mr-2"></i>
                            </button>
                            <a href="chatboard.php" id="close-chat-btn" class="text-red-500 hover:text-red-700 text-sm">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Call Drawer -->
                    <div id="call-drawer"
                        class="fixed top-0 right-0 z-50 mt-40 w-80 h-screen p-4 bg-white shadow-lg transform translate-x-full transition-transform duration-300">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Contact Seller</h2>
                        <div class="flex flex-col items-center">
                            <img src="assets/user_dp/<?= $otherUserInfo['dp'] ?? 'default-profile.jpg' ?>"
                                alt="<?= htmlspecialchars($otherUserInfo['name']) ?>"
                                class="rounded-full mb-3 h-20 w-20 object-cover">
                            <p class="text-lg font-semibold"><?= htmlspecialchars($otherUserInfo['name']) ?></p>
                            <p class="text-gray-500"><?= htmlspecialchars($otherUserInfo['contact']) ?></p>
                            <div class="mt-4 space-x-4">
                                <a href="tel:<?= htmlspecialchars($otherUserInfo['contact']) ?>"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                    <i class="fas fa-phone mr-2"></i>Call Now
                                </a>
                                <button id="close-drawer"
                                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                    <i class="fas fa-times mr-2"></i>Close
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 pb-3 flex justify-between items-center border-t pt-2">
                        <div class="flex items-center">
                            <img src="assets/images/<?= $bookInfo['img1'] ?>" class="h-10 w-10 rounded border mr-2">
                            <span class="font-medium"><?= htmlspecialchars($bookInfo['book_name']) ?></span>
                        </div>
                        <span class="font-bold">₹<?= number_format($bookInfo['sell_price'], 2) ?></span>
                    </div>
                </div>

                <div class="chat-messages p-4 bg-gray-100" id="chatMessages">
                    <?php if ($messages && $messages->num_rows > 0): ?>
                        <?php while ($msg = $messages->fetch_assoc()): ?>
                            <div class="mb-1 flex <?= $msg['sender_id'] == $user_id ? 'justify-end' : 'justify-start' ?>">
                                <div
                                    class="message-bubble px-4 py-2 rounded-lg 
                            <?= $msg['sender_id'] == $user_id ? 'bg-green-500 text-white' : 'bg-white text-gray-800 border border-gray-200' ?>">
                                    <p><?= htmlspecialchars($msg['message']) ?></p>
                                    <div class="flex justify-between items-end mt-1">
                                        <p class="text-xs <?= $msg['sender_id'] == $user_id ? 'text-white/80' : 'text-gray-500' ?>">
                                            <?php
                                            date_default_timezone_set('Asia/Kolkata');
                                            echo date('h:i A', strtotime($msg['msg_time']));
                                            ?>

                                        </p>

                                    </div>
                                </div>

                            </div>
                            <div class="flex justify-end mb-3">
                                <?php if ($msg['sender_id'] == $user_id && $msg['is_read']): ?>
                                    <span class="text-[10px] ml-2 text-gray-500 italic">Seen</span>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="h-full flex items-center justify-center text-gray-500">
                            <div class="text-center">
                                <i class="fas fa-comment-dots text-4xl mb-3"></i>
                                <p>No messages yet</p>
                                <p class="text-sm mt-1">Start the conversation</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="border-t p-3 bg-white sticky bottom-0">
                    <form action="" method="post" class="flex">
                        <input type="hidden" name="receiver_id" value="<?= $otherUserInfo['user_id'] ?>">
                        <input type="text" name="message" placeholder="Type a message..."
                            class="flex-1 px-4 py-2 border rounded-l-lg focus:outline-none focus:ring-1 focus:ring-green-500"
                            required autofocus>
                        <button name="send_msg" class="bg-green-500 text-white px-4 py-2 rounded-r-lg hover:bg-green-600">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            <?php else: ?>
                <div class="h-full flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-comments text-4xl mb-3"></i>
                        <p>No chat selected</p>
                        <p class="text-sm mt-1">Select a conversation from the list</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <script>
            // Handle chat closing
            document.getElementById('close-chat-btn')?.addEventListener('click', function (e) {
                e.preventDefault();
                window.location.href = 'chatboard.php';
            });

            // Handle drawer functionality
            document.getElementById('open-drawer')?.addEventListener('click', function () {
                document.getElementById('call-drawer').classList.remove('translate-x-full');
            });

            document.getElementById('close-drawer')?.addEventListener('click', function () {
                document.getElementById('call-drawer').classList.add('translate-x-full');
            });

            // Auto-scroll to bottom of chat
            function scrollToBottom() {
                const chatMessages = document.getElementById('chatMessages');
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }

            // Scroll to bottom when page loads
            document.addEventListener('DOMContentLoaded', function () {
                scrollToBottom();

                // Auto-refresh messages every 5 seconds
                const urlParams = new URLSearchParams(window.location.search);
                const bookId = urlParams.get('book_id');
                const chatWith = urlParams.get('chat_with');

                if (bookId) {
                    setInterval(function () {
                        fetch(`get_messages.php?book_id=${bookId}&chat_with=${chatWith}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.newMessages) {
                                    location.reload();
                                }
                            })
                            .catch(error => console.error('Error fetching messages:', error));
                    }, 5000);
                }
            });
        </script>
</body>

</html>
