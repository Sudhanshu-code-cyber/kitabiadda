<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book | KitabiAdda</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <header class="bg-white shadow-md p-4">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">KitabiAdda</h1>
            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Browse Books</a>
        </div>
    </header>

    <div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <img src="book-image.jpg" alt="Book Image" class="w-full h-96 object-cover rounded-lg shadow">
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-800">The Great Gatsby</h2>
                <p class="text-gray-600 text-lg mt-2">by <span class="font-semibold">F. Scott Fitzgerald</span></p>
                <p class="text-xl font-semibold text-blue-600 mt-4">Price: ₹450</p>
                <p class="text-gray-700 mt-4"><span class="font-semibold">Category:</span> Fiction</p>
                <p class="text-gray-700 mt-2"><span class="font-semibold">Condition:</span> Like New</p>
                <p class="text-gray-700 mt-2"><span class="font-semibold">Location:</span> Mumbai, India</p>
                <div class="mt-6">
                    <h3 class="text-lg font-semibold">Seller Details</h3>
                    <p class="text-gray-700">John Doe</p>
                    <p class="text-gray-700">Phone: +91 98765 43210</p>
                </div>
                <button class="mt-6 w-full bg-green-600 text-white p-3 rounded-lg text-lg font-semibold hover:bg-green-700">Contact Seller</button>
            </div>
        </div>
    </div>

    <footer class="text-center py-6 mt-10 text-gray-600">&copy; 2025 KitabiAdda - Buy & Sell Books Easily</footer>
</body>

</html>