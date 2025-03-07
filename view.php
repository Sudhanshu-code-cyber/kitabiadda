<?php include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script>
        function changeImage(src) {
            document.getElementById("mainImage").src = src;
        }
    </script>
</head>
<body class="bg-gray-100">
<?php include_once "includes/header.php"; ?>
<?php include_once "includes/subheader.php"; ?>

<div class="max-w-6xl w-screen bg-white shadow-lg rounded-lg p-6 mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        <!-- Small Images -->
        <div class="md:col-span-2 flex flex-col gap-2 items-center">
            <img src="images/color palatte.png?random=1" class="w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition" onclick="changeImage(this.src)">
            <img src="images/Screenshot 2024-05-19 19195.png" class="w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition" onclick="changeImage(this.src)">
            <img src="images/navbar.png?random=3" class="w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition" onclick="changeImage(this.src)">
            <img src="images/20221013_211226.jpg?random=4" class="w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition" onclick="changeImage(this.src)">
        </div>
        
        <!-- Main Image -->
        <div class="md:col-span-6 flex justify-center">
            <img id="mainImage" src="images/color palatte.png?random=1" class="w-full max-w-lg h-auto object-cover rounded-lg shadow-lg border border-gray-300" alt="Main Image">
        </div>
        
        <!-- Details Section -->
        <div class="md:col-span-4 flex flex-col gap-4">
            <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-300 text-center">
                <h3 class="text-2xl font-bold text-blue-600">₹3,000</h3>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-300 text-center">
                <p class="text-gray-600"><strong>Location:</strong> Ambedkar Puram, Kanpur, Uttar Pradesh</p>
                <button class="mt-2 w-full bg-green-500 text-white font-semibold py-2 rounded-lg hover:bg-green-600 transition">Chat with Seller</button>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-300 text-center">
                <p class="text-gray-700 font-semibold">Sell NEET Book Module and Books</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
