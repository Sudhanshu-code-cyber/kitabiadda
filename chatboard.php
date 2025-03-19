<?php include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$callingseller_id = $connect->query("select * from books where version='old'");
$seller_id = mysqli_fetch_array($callingseller_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex  mt-36 border-t border-gray-300">
        <div class="w-4/12 border-r border-gray-300 bg-white">
            <div class="flex justify-between items-center bg-[#B3D8A8] border-b p-4 border-gray-300">
                <h2 class="text-xl font-bold text-gray-900">INBOX</h2>
                <div class="flex items-center space-x-2">
                    <form action="" method="" class="flex items-center border border-gray-500 rounded-full overflow-hidden">
                        <input type="search" name="search" class="py-2 px-3 outline-none w-40" placeholder="Search Chats">
                        <button type="submit" name="search_now" class="bg-black text-white p-2 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </form>
                    <div class="relative">
                        <button id="dropdownButton" data-dropdown-toggle="dropdown" class="p-2 rounded-full hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                        <div id="dropdown" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete All Chats</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h2 class="text-gray-600 font-semibold">Quick Filter</h2>
                <div class="flex gap-3 mt-3">
                    <button class="py-2 px-4 border border-gray-600 rounded-full hover:bg-gray-300">All</button>
                    <button class="py-2 px-4 border border-gray-600 rounded-full hover:bg-gray-300">Meeting</button>
                    <button class="py-2 px-4 border border-gray-600 rounded-full hover:bg-gray-300">Unread</button>
                    <button class="py-2 px-4 border border-gray-600 rounded-full hover:bg-gray-300">Important</button>
                </div>
            </div>
            <div class="p-2">
                <div class="flex justify-between items-center border p-3 rounded-lg bg-[#A3D1C6]">
                    <div class="flex items-center gap-4">
                        <img src="https://img.bookchor.com/images/cover/bc/9780670095940.jpg" class="h-20 border border-gray-300 rounded-lg" />
                        <div>
                            <h2 class="text-lg font-semibold">Raju</h2>
                            <p class="text-sm text-gray-600">Science Book</p>
                            <span class="text-xs ml-2">Hii</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-gray-500 text-sm">Yesterday</span>
                        <button id="chatDropdownButton" data-dropdown-toggle="chatDropdown" class="p-2 rounded-full hover:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                            </svg>
                        </button>
                        <div id="chatDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white shadow-lg rounded-md">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete Chat</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Multiple Delete</a></li>
                                <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Mark as Important</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-8/12 bg-white flex flex-col h-[500px] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <div class="flex items-center gap-4 ml-3">
                    <img src="https://img.bookchor.com/images/cover/bc/9780670095940.jpg" class="h-14 w-14 border border-gray-300 rounded-full">
                    <h2 class="text-lg font-semibold"><?= $seller_id['fullname']; ?></h2>
                </div>
                <div class="relative">
                    <button id="callDropdownButton" data-dropdown-toggle="callDropdown" class="p-2 rounded-full hover:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                    </button>
                    <div id="callDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md border">
                        <ul class="py-2 text-sm text-gray-700">
                            <li class="px-4 py-2 border-b">📞 <strong>Call:</strong> +91 9876543210</li>
                            <li>
                                <a href="#" class="block px-4 py-2 text-green-600 font-semibold hover:bg-gray-100">Request a Call</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="p-4 flex justify-between mx-6">
                <h2 class="text-xl font-semibold"> Science Book :-</h2>
                <p class="text-xl font-semibold text-gray-600">₹ 100</p>
            </div>
            <div class="flex-1 p-4 overflow-y-auto h-[400px] bg-gray-100">
                <?php if ($seller_id['seller_id'] == $user['user_id']): ?>
                    <!-- Seller viewing their own messages (optional content here) -->
                <?php else: ?>
                    <a href="">
                        <?php
                        $user_id = $user['user_id'];
                        $seller = $seller_id['seller_id'];

                        // Show messages where seller is receiver and user is sender (Left Side)
                        $callingchat = $connect->query("SELECT * FROM message WHERE sender_id = '$user_id' AND receiver_id = '$seller'");
                        while ($msg = $callingchat->fetch_array()):
                        ?>
                            <div class="flex items-end justify-end mb-4">
                                <div class="gap-4 grid grid-cols-1">
                                    <div class="bg-green-500 text-white p-3 rounded-lg shadow max-w-xs">
                                        <p><?= $msg['message']; ?></p>
                                        <span class="text-xs text-white">10:32 AM</span>
                                    </div>
                                </div>
                                <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" alt="" class="h-10 w-10 rounded-full border">
                            </div>
                        <?php endwhile; ?>

                        <?php
                        // Show messages where seller is sender and user is receiver (Right Side)
                        $callingchat = $connect->query("SELECT * FROM message WHERE sender_id = '$seller' AND receiver_id = '$user_id'");
                        while ($msg = $callingchat->fetch_array()):
                        ?>
                            <div class="flex items-start space-x-3 mb-4">
                                <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" alt="" class="h-10 w-10 rounded-full border">
                                <div class="bg-white p-3 rounded-lg shadow max-w-xs">
                                    <p class="text-gray-700"><?= $msg['message']; ?>hello</p>
                                    <span class="text-xs text-gray-500">10:30 AM</span>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </a>
                <?php endif; ?>
            </div>

            <div class="p-4 border-t flex items-center gap-2 bg-white">
                <form action="" method="post" class="flex w-full gap-2">
                    <input type="text" name="message" placeholder="Type a message..." class="flex-1 p-3 border rounded-lg outline-none focus:ring focus:ring-green-200">
                    <button name="send_msg" class="bg-green-500 text-white p-3 rounded-lg shadow hover:bg-green-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>

                    </button>
                    <?php
                    if (isset($_POST['send_msg'])) {
                        $product_id = $seller_id['id'];
                        $sender_id = $user['user_id'];
                        $reciver_id = $seller_id['seller_id'];
                        $msg = $_POST['message'];

                        $query = $connect->query("insert into message (product_id, sender_id , receiver_id, message) value('$product_id','$sender_id','$reciver_id','$msg')");

                        if ($query) {
                            redirect("chatboard.php");
                        }
                    }
                    ?>




                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>