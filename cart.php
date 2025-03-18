<?php include_once "config/connect.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<nav class="mt-12">
<?php include_once "includes/header.php"; ?>
</nav>

    <div class="container mx-auto p-10">
        <!-- Navbar -->
        

        <!-- Cart Section -->
        <div class="flex flex-col md:flex-row mt-6 gap-6">
            <!-- Product List -->
            <div class="w-full md:w-2/3 bg-white p-4 shadow-md rounded h-[500px] overflow-y-auto">
                <h2 class="text-lg font-semibold mb-4">Your Cart</h2>
                <div class="space-y-4">
                    <!-- Product Item -->
                    <div class="flex items-center gap-4 border-b pb-4">
                        <img src="https://picsum.photos/100" class="w-20 h-20 rounded" alt="Product">
                        <div class="flex-1">
                            <h3 class="font-semibold">Product Name</h3>
                            <p class="text-sm text-gray-500">Seller: RetailNet</p>
                            <p class="text-green-500 font-semibold">₹899 <span class="text-gray-500 line-through">₹1,999</span></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>1</span>
                            <button class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border-b pb-4">
                        <img src="https://picsum.photos/100" class="w-20 h-20 rounded" alt="Product">
                        <div class="flex-1">
                            <h3 class="font-semibold">Product Name</h3>
                            <p class="text-sm text-gray-500">Seller: RetailNet</p>
                            <p class="text-green-500 font-semibold">₹899 <span class="text-gray-500 line-through">₹1,999</span></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>1</span>
                            <button class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border-b pb-4">
                        <img src="https://picsum.photos/100" class="w-20 h-20 rounded" alt="Product">
                        <div class="flex-1">
                            <h3 class="font-semibold">Product Name</h3>
                            <p class="text-sm text-gray-500">Seller: RetailNet</p>
                            <p class="text-green-500 font-semibold">₹899 <span class="text-gray-500 line-through">₹1,999</span></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>1</span>
                            <button class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border-b pb-4">
                        <img src="https://picsum.photos/100" class="w-20 h-20 rounded" alt="Product">
                        <div class="flex-1">
                            <h3 class="font-semibold">Product Name</h3>
                            <p class="text-sm text-gray-500">Seller: RetailNet</p>
                            <p class="text-green-500 font-semibold">₹899 <span class="text-gray-500 line-through">₹1,999</span></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>1</span>
                            <button class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 border-b pb-4">
                        <img src="https://picsum.photos/100" class="w-20 h-20 rounded" alt="Product">
                        <div class="flex-1">
                            <h3 class="font-semibold">Product Name</h3>
                            <p class="text-sm text-gray-500">Seller: RetailNet</p>
                            <p class="text-green-500 font-semibold">₹899 <span class="text-gray-500 line-through">₹1,999</span></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button class="px-2 py-1 bg-gray-200 rounded">-</button>
                            <span>1</span>
                            <button class="px-2 py-1 bg-gray-200 rounded">+</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Price Details -->
            <div class="w-full md:w-1/3 bg-white p-4 shadow-md rounded h-fit">
                <h2 class="text-lg font-semibold mb-4">Price Details</h2>
                <div class="space-y-2 text-gray-700">
                    <p class="flex justify-between"><span>Price (3 items)</span> <span>₹2,499</span></p>
                    <p class="flex justify-between text-green-500"><span>Discount</span> <span>- ₹500</span></p>
                    <p class="flex justify-between"><span>Delivery</span> <span class="text-green-500">Free</span></p>
                    <hr>
                    <p class="flex justify-between text-lg font-semibold"><span>Total</span> <span>₹1,999</span></p>
                </div>
                <button class="w-full bg-orange-500 text-white py-2 mt-4 rounded">PLACE ORDER</button>
            </div>
        </div>
    </div>
</body>
</html>
