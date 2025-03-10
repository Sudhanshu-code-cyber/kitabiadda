<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
if(!isset($_GET['book_id'])){
    redirect("index.php");
}
$book_id = $_GET["book_id"];
$query = $connect->query("select * from books where id='$book_id'");
if($query->num_rows == 0){
    redirect("index.php");
}
$book = $query->fetch_array();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadRainbow | Details</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex p-10 bg-white mt-30">
            <div
             class="flex gap-20 items-center w-5/12 border-gray-300 border-r-2 space-x-4 p-6">
                <div class="flex flex-col space-y-2">
                    <img src="images/<?= $book['img1'];?>" alt="Thumbnail 1"
                        class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/<?= $book['img1'];?>')">
                    <img src="images/<?= $book['img2'];?>" alt="Thumbnail 2"
                        class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/<?= $book['img2'];?>')">
                    <img src="images/<?= $book['img3'];?>" alt="Thumbnail 3"
                        class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/<?= $book['img3'];?>')">
                    <img src="images/<?= $book['img4'];?>" alt="Thumbnail 3"
                        class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/<?= $book['img4'];?>')">
                </div>

                <div class="w-64 rounded-lg overflow-hidden shadow-lg">
                    <img id="mainBookImage" src="images/<?= $book['img1'];?>" alt="Book Image"
                        class="w-full h-full object-cover">
                </div>
            </div>
            <div class="w-7/12 flex flex-col gap-2 p-6">
                <h1 class="text-2xl font-semibold"><?= $book['book_name'];?></h1>
                <p class="text-orange-400 text-sm font-semibold"><?= $book['book_category'];?></p>
                <h3 class="text-lg font-semibold">Author: <span class="text-[#3D8D7A]"><?= $book['book_author'];?></span></h3>
                <div class="flex gap-5 mb-5">
                    <div class="border-2 border-orange-300 hover:border-orange-500 h-22 w-42 flex flex-col rounded pt-1 px-2">
                        <p class="text-lg p-0 font-semibold">E-BOOK</p>
                        <p class="text-gray-700 font-semibold">Price: <span class="text-xl text-red-500">₹<?= $book['e_book_price'];?></span></p>
                        <?=
                       $book['e_book_price'] != null ? "<span class='text-green-500 text-sm'>Available Now</span>" : "<span class='text-red-500 text-sm'>Not Available</span>";
                        ?>
                    </div>
                    <div class="border-2 border-orange-300 hover:border-orange-500 h-22 w-42 flex flex-col rounded pt-1 px-2">
                        <p class="text-lg font-semibold"><?=$book['book_binding'];?></p>
                        <p>40% off</p>
                        <p class="text-gray-700 font-semibold">Price: ₹<del class="text-sm"><?=$book['mrp'];?></del> <span class="text-xl text-red-500">₹<?=$book['sell_price'];?></span></p>
                    </div>
                </div>
                <hr class="text-gray-300">
                <div>
                    <h1 class="text-xl text-gray-600 mt-2 font-semibold">Book Details :-</h1>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button class="text-lg text-orange-600 border border-orange-500 p-3 rounded font-semibold">Add To Cart</button>
                    <button class="text-lg bg-orange-600 text-white p-3 rounded font-semibold">Buy Now</button>
                </div>

            </div>
            <script>
                function changeImage(src) {
                    document.getElementById("mainBookImage").src = src;
                }
            </script>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>