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

            // ⏳ Auto Redirect after 5 seconds
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 5000);
        });
    </script>";
    exit();
}

$searchUser = isset($_GET['search_users']) ? trim($_GET['search_users']) : '';

$book_id = $_GET['book_id'] ?? null;
$sellerdata = null;
$sellerInfo = null;

if ($book_id) {
    $getbook = $connect->query("SELECT * FROM books WHERE id = '$book_id'");
    $sellerdata = mysqli_fetch_array($getbook);

    if ($sellerdata) {
        $seller_id = $sellerdata['seller_id'];
        $getSellerInfo = $connect->query("SELECT name, contact, dp FROM users WHERE user_id = '$seller_id'");
        $sellerInfo = mysqli_fetch_assoc($getSellerInfo);
        $sellerContact = $sellerInfo;
    }
}

$chatUsersQuery = $connect->query("SELECT DISTINCT 
        seller_id, 
        books.id as book_id, 
        books.book_name, 
        users.name,
        (SELECT message FROM message 
         WHERE (sender_id = '$user_id' OR receiver_id = '$user_id') 
         AND product_id = books.id 
         ORDER BY msg_time DESC LIMIT 1) as last_message,
        (SELECT msg_time FROM message 
         WHERE (sender_id = '$user_id' OR receiver_id = '$user_id') 
         AND product_id = books.id 
         ORDER BY msg_time DESC LIMIT 1) as last_message_time
    FROM message 
    JOIN books ON message.product_id = books.id 
    JOIN users ON books.seller_id = users.user_id 
    WHERE (message.sender_id = '$user_id' OR message.receiver_id = '$user_id')
    " . ($searchUser ? "AND (users.name LIKE '%$searchUser%' OR books.book_name LIKE '%$searchUser%' OR 
        (SELECT message FROM message 
         WHERE (sender_id = '$user_id' OR receiver_id = '$user_id') 
         AND product_id = books.id 
         ORDER BY msg_time DESC LIMIT 1) LIKE '%$searchUser%')" : "") . "
    ORDER BY last_message_time DESC");

$chatList = [];
while ($chatRow = mysqli_fetch_assoc($chatUsersQuery)) {
    $chatList[] = $chatRow;
}
// Get total chat count
$chatCountQuery = $connect->query("SELECT COUNT(DISTINCT books.id) as total_chats 
    FROM message 
    JOIN books ON message.product_id = books.id 
    WHERE message.sender_id = '$user_id' OR message.receiver_id = '$user_id'");
$chatCountData = mysqli_fetch_assoc($chatCountQuery);
$totalChats = $chatCountData['total_chats'] ?? 0;

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

// Handle chat deletion - UPDATED to use product_id
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
                margin-top: 7.5rem
            }

            .chat-window {
                height: 100%;
                display: <?= $book_id ? 'flex' : 'none' ?>;
                margin-top: 3rem
            }

            .back-button {
                display: flex !important;
            }
        }

        /* Call Drawer Styles */
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

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="chat-container flex flex-col lg:flex-row lg:mt-32">


        <!-- Chat List -->
        <div class="chat-list w-full lg:w-4/12 border-r border-gray-200 bg-white lg:h-[600px] h-full overflow-y-auto shadow-sm">
            <!-- Header with Search -->
            <div class="p-4 bg-gradient-to-r from-[#B3D8A8] to-[#9BC58D] flex flex-col sm:flex-row justify-between items-center gap-3 border-b border-gray-200 sticky top-0 z-10">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    INBOX(<?= $totalChats ?>)
                </h2>
                <form action="" method="get" class="w-full sm:w-auto">
                    <div class="relative flex outline-none">
                        <input type="search"
                            name="search_users"
                            value="<?= htmlspecialchars($searchUser) ?>"
                            placeholder="Search conversations..."
                            class="block w-full px-4 py-1 bg-white/90 rounded-l-lg text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-0 text-sm"
                            aria-label="Search conversations">
                        <button type="submit"
                            class=" bg-[#3D8D7A] text-white font-medium rounded-r-lg px-4 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <?php if (!empty($searchUser)): ?>
                <div class="p-2 text-center bg-gray-50 text-sm text-gray-600">
                    <?php if (!empty($chatList)): ?>
                        Showing results for: "<span class="font-medium"><?= htmlspecialchars($searchUser) ?></span>"
                    <?php else: ?>
                        No results found for: "<span class="font-medium"><?= htmlspecialchars($searchUser) ?></span>"
                    <?php endif; ?>
                    <a href="chatboard.php" class="ml-2 text-[#3D8D7A] hover:underline">Clear search</a>
                </div>
            <?php endif; ?>

            <!-- Chat List -->
            <?php if (!empty($chatList)): ?>
                <div class="divide-y divide-gray-100">
                    <?php foreach ($chatList as $chat):
                        $bookImgQuery = $connect->query("SELECT img1 FROM books WHERE id = '{$chat['book_id']}'");
                        $bookImgRow = mysqli_fetch_assoc($bookImgQuery);
                        $activeClass = ($book_id == $chat['book_id']) ? 'bg-[#E8F5F2] border-l-4 border-[#3D8D7A]' : 'hover:bg-gray-50';
                    ?>
                        <div class="relative">
                            <a href="chatboard.php?book_id=<?= $chat['book_id']; ?>" class="block transition duration-150 ease-in-out <?= $activeClass ?>">
                                <div class="flex items-center gap-4 p-4 rounded-lg">
                                    <div class="relative flex-shrink-0">
                                        <img src="assets/images/<?= $bookImgRow['img1']; ?>" class="h-14 w-14 rounded-lg object-cover border border-gray-200 shadow-sm" />
                                        <?php if (rand(0, 1)): ?>
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

                            <!-- Delete Icon - UPDATED to use product_id -->
                            <a
                                href="?product_id=<?= $chat['book_id']; ?>"
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
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="flex flex-col items-center justify-center p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-500">
                        <?= empty($searchUser) ? 'No conversations yet' : 'No matching conversations found' ?>
                    </h3>
                    <p class="text-sm text-gray-400 mt-1">
                        <?= empty($searchUser) ? 'Start a chat to see messages here' : 'Try a different search term' ?>
                    </p>
                    <?php if (!empty($searchUser)): ?>
                        <a href="chatboard.php" class="mt-3 text-sm text-[#3D8D7A] hover:underline">
                            Show all conversations
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Chat Window -->
        <?php if ($sellerdata && $sellerInfo): ?>
            <?php
            $bookImgQuery = $connect->query("SELECT img1 FROM books WHERE id = '$book_id'");
            $bookImgRow = mysqli_fetch_assoc($bookImgQuery);
            ?>
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
                        <button id="open-drawer" class="px-4 ml-4 py-2 bg-[#3D8D7A] text-white rounded-md hover:bg-[#2c6b5b] transition">
                            <i class="fas fa-phone mr-2"></i>
                        </button>

                        <!-- Dynamic Call Drawer -->
                        <div id="call-drawer" class="fixed top-0 right-0 z-50 mt-40 w-80 h-screen p-4 bg-white shadow-lg transform translate-x-full transition-transform duration-300">
                            <h2 class="text-lg font-bold text-gray-800 mb-4">Contact Seller</h2>

                            <div class="flex flex-col items-center">
                                <img src="assets/user_dp/<?= $sellerContact['dp'] ?? 'default-profile.jpg' ?>"
                                    alt="<?= htmlspecialchars($sellerContact['name']) ?>"
                                    class="rounded-full mb-3 h-20 w-20 object-cover">
                                <p class="text-lg font-semibold"><?= htmlspecialchars($sellerContact['name']) ?></p>
                                <p class="text-gray-500"><?= htmlspecialchars($sellerContact['contact']) ?></p>

                                <div class="mt-4 space-x-4">
                                    <a href="tel:<?= htmlspecialchars($sellerContact['contact']) ?>"
                                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                        <i class="fas fa-phone mr-2"></i>Call Now
                                    </a>
                                    <button id="close-drawer" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                        <i class="fas fa-times mr-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>

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
        // Select drawer and buttons
        const drawer = document.getElementById("call-drawer");
        const openBtn = document.getElementById("open-drawer");
        const closeBtn = document.getElementById("close-drawer");

        // Open drawer
        openBtn.addEventListener("click", () => {
            drawer.classList.remove("translate-x-full");
            // Add backdrop
            const backdrop = document.createElement("div");
            backdrop.id = "drawer-backdrop";
            backdrop.className = "fixed inset-0 bg-black bg-opacity-50 z-40";
            backdrop.addEventListener("click", () => {
                drawer.classList.add("translate-x-full");
                backdrop.remove();
            });
            document.body.appendChild(backdrop);
        });

        // Close drawer
        closeBtn.addEventListener("click", () => {
            drawer.classList.add("translate-x-full");
            const backdrop = document.getElementById("drawer-backdrop");
            if (backdrop) backdrop.remove();
        });

        // Close drawer when pressing escape
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                drawer.classList.add("translate-x-full");
                const backdrop = document.getElementById("drawer-backdrop");
                if (backdrop) backdrop.remove();
            }
        });

        // Auto-scroll to bottom of chat messages
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