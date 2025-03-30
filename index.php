<?php include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadRainbow | Book</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<style>
    /* Hide scrollbar for Webkit browsers (Chrome, Safari, Edge) */
    #bookScroll::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for Firefox */
    #bookScroll {
        scrollbar-width: none;
    }

    /* Container styling for smooth scrolling */
    #bookScroll {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    /* Same styles for the second carousel */
    #bookScroll2::-webkit-scrollbar {
        display: none;
    }

    #bookScroll2 {
        scrollbar-width: none;
    }

    #bookScroll2 {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }

    #bookScroll3::-webkit-scrollbar {
        display: none;
    }

    #bookScroll3 {
        scrollbar-width: none;
    }

    #bookScroll3 {
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
    }
</style>

<body
    class="bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <!-- body section -->

    <!-- First Carousel -->
    <div id="default-carousel" class="relative mt-22 w-full" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative z-5 xl:h-[400px] h-[160px] mt-28 sm:h-[200px] md:h-[200px] lg:h-[300px] overflow-hidden">
        <!-- Carousel Items -->
        <a href="">
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="assets/banner/2.png" class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-fit md:object-fit md:h-full lg-fit" 
            alt="Slide 1">
        </div>
        </a>
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="assets/banner/Etsy Banner.png" class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-cover md:h-full" alt="Slide 2">
        </div>
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="assets/banner/shop.png" class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-cover md:h-full" alt="Slide 3">
        </div>
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="assets/banner/crs4.png" class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-cover md:h-full" alt="Slide 4">
        </div>
    </div>

    <!-- Slider indicators -->
    <div class="absolute bottom-5 left-1/2 flex -translate-x-1/2 space-x-2">
        <button class="w-3 h-3 rounded-full bg-white" aria-label="Slide 1" data-carousel-slide-to="0"></button>
        <button class="w-3 h-3 rounded-full bg-gray-400" aria-label="Slide 2" data-carousel-slide-to="1"></button>
        <button class="w-3 h-3 rounded-full bg-gray-400" aria-label="Slide 3" data-carousel-slide-to="2"></button>
        <button class="w-3 h-3 rounded-full bg-gray-400" aria-label="Slide 4" data-carousel-slide-to="3"></button>
    </div>

    <!-- Slider controls -->
    <button type="button" class="absolute top-1/2 left-0 z-10 p-2 bg-white/50 rounded-full" data-carousel-prev>
        <span>&#10094;</span>
    </button>
    <button type="button" class="absolute top-1/2 right-0 z-10 p-2 bg-white/50 rounded-full" data-carousel-next>
        <span>&#10095;</span>
    </button>
</div>

    <!-- Book Sets Section for New Books -->

    <?php include_once "includes/newRelease.php"; ?>

    <!-- Book Sets Section for Old Books (Second Carousel) -->
    <?php include_once "includes/oldBook.php"; ?>



    <!-- Book Sets Section for Old Books (Third Carousel) -->
    <?php include_once "includes/e-Book.php"; ?>

    <?php
    include_once "includes/footer2.php";
    ?>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>