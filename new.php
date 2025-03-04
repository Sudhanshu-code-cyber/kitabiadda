<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Header with Dropdown</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-white shadow-md">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold text-blue-600">Logo</a>
            <input type="search" placeholder="search product" class="border-2 w-60">
            
            <nav class="hidden md:flex space-x-6">
                <a href="#" class="text-gray-700 hover:text-blue-600">Home</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">About</a>
                <a href="#" class="text-gray-700 hover:text-blue-600">Wishlist</a>
            </nav>
            
            <div class="relative">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Profile</button>
                <div class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg hidden group-hover:block">
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Wishlist</a>
                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Orders</a>
                    <a href="#" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Logout</a>
                </div>
            </div>
        </div>
    </header>
</body>
</html>
