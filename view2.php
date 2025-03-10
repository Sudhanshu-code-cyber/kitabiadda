<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
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
    <div class="flex mt-30">
        <div class="p-5 w-full">
            <div class="flex gap-20 items-center border-gray-800 border-2  space-x-4 bg-blue-100 p-6 rounded-lg shadow-lg">
                <div class="flex flex-col space-y-2">
                    <img src="images/color palatte.png" alt="Thumbnail 1"
                        class="w-16 h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/color palatte.png')">
                    <img src="images/middle3-photp.png" alt="Thumbnail 2"
                        class="w-16 h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/middle3-photp.png')">
                    <img src="images/Picsart_25-02-07_13-38-15-429.jpg" alt="Thumbnail 3"
                        class="w-16 h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                        onclick="changeImage('images/Picsart_25-02-07_13-38-15-429.jpg')">
                </div>

                <div class="w-64 rounded-lg overflow-hidden shadow-lg">
                    <img id="mainBookImage" src="images/color palatte.png" alt="Book Image"
                        class="w-full h-[22rem] object-contain">
                </div>
            </div>

            <script>
                function changeImage(src) {
                    document.getElementById("mainBookImage").src = src;
                }
            </script>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>