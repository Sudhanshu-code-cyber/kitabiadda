<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="flex mt-6 border-t border-gray-300">
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

                    <!-- Dropdown Menu -->
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

            <div class="p-4 bg-[#A3D1C6]">
                <div class="flex justify-between items-center border p-3 rounded-lg bg-white">
                    <div class="flex items-center gap-4">
                        <img src="https://img.bookchor.com/images/cover/bc/9780670095940.jpg" class="h-20 border border-gray-300 rounded-lg" />
                        <div>
                            <h2 class="text-lg font-semibold">Raju Singh</h2>
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

        <!-- Chat Window -->
        <div class="w-8/12 bg-white">
            <div class="flex p-2 border-b gap-2">
                <img src="https://img.bookchor.com/images/cover/bc/9780670095940.jpg" class="h-20 border border-gray-300 rounded-lg" />
                <div class="p-4">
                    <h2 class="text-lg font-semibold">Raju Singh</h2>
                </div>
            </div>

        </div>
    </div>

    <!-- Flowbite Script -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>