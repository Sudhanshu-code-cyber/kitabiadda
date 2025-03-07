<?php include_once "config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
        function changeImage(src) {
            document.getElementById("mainImage").src = src;
        }
    </script>
</head>

<body class="">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <div class="max-w-7xl w-screen   p-6 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Small Images -->
            <div class="md:col-span-8 flex flex-col gap-2 relative">


                <!-- Main Image -->
                <div class="md:col-span-9  relative">
                    <div class="md:col-span-12 flex justify-center relative">
                        <button onclick="prevImage()"
                            class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md border border-gray-300 hover:bg-gray-100 transition">
                            <i class="bi bi-arrow-left"></i>
                        </button>

                        <img id="mainImage" src="images/color palatte.png?random=1"
                            class="w-full h-120 object-cover rounded-lg shadow-lg border border-gray-300 cursor-pointer"
                            alt="Main Image" onclick="openFullScreen()">

                        <button onclick="nextImage()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md border border-gray-300 hover:bg-gray-100 transition">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>

                </div>
                <hr>
                <div class="md:col-span-3 flex  gap-2 items-center">
                    <img src="images/color palatte.png?random=1"
                        class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition"
                        onclick="changeImage(0)">
                    <img src="images/defaultUser.webp?random=2"
                        class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition"
                        onclick="changeImage(1)">
                    <img src="images/navbar.png?random=3"
                        class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition"
                        onclick="changeImage(2)">
                    <img src="images/20221013_211226.jpg?random=4"
                        class="thumbnail w-20 h-20 object-cover rounded-lg cursor-pointer border-2 border-gray-300 hover:border-blue-500 transition"
                        onclick="changeImage(3)">
                </div>
                <hr>
                <div class="md:col-span-12 flex justify-center relative">
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 w-full">
                        <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                        <p class="text-gray-700 mt-2">
                            Neet all pcb module (hindi) book's chemistry biology and nd biology and physics
                            Neet all pcb module (hindi) book's chemistry biology and nd biology and physics
                            Neet all pcb module (hindi) book's chemistry biology and nd biology and physics
                        </p>
                    </div>
                </div>
                <div class="md:col-span-12 flex justify-center relative">
                    <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 w-full max-w-4xl">
                        <div class="flex items-center text-gray-700 px-4">
                            <!-- Previous Arrow -->
                            <button id="prevBtn" class="text-gray-500 hover:text-gray-700 text-2xl">
                                &#10094;
                            </button>

                            <!-- Content Container (Slider) -->
                            <div id="sliderWrapper" class="overflow-hidden w-full px-2">
                                <div id="sliderContent" class="flex space-x-6 transition-transform duration-300">

                                    <!-- ITEM 1 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">📚</span>
                                        <p class="text-sm text-gray-500">ISBN-10</p>
                                        <p class="text-lg font-semibold">0857197681</p>
                                    </div>

                                    <!-- ITEM 2 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">📚</span>
                                        <p class="text-sm text-gray-500">ISBN-13</p>
                                        <p class="text-lg font-semibold">9780857197689</p>
                                    </div>

                                    <!-- ITEM 3 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">📖</span>
                                        <p class="text-sm text-gray-500">Page Number</p>
                                        <p class="text-lg font-semibold">256</p>
                                    </div>

                                    <!-- ITEM 4 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">🌐</span>
                                        <p class="text-sm text-gray-500">Language</p>
                                        <p class="text-lg font-semibold">English</p>
                                    </div>

                                    <!-- ITEM 5 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">📰</span>
                                        <p class="text-sm text-gray-500">Imprint</p>
                                        <p class="text-lg font-semibold">Harriman House</p>
                                    </div>

                                    <!-- ITEM 6 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">⚖️</span>
                                        <p class="text-sm text-gray-500">Weight (gr)</p>
                                        <p class="text-lg font-semibold">272</p>
                                    </div>

                                    <!-- ITEM 7 -->
                                    <div class="flex flex-col items-center min-w-[140px]">
                                        <span class="text-2xl">📏</span>
                                        <p class="text-sm text-gray-500">Dimension (mm)</p>
                                        <p class="text-lg font-semibold">134x22x216</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Next Arrow -->
                            <button id="nextBtn" class="text-gray-500 hover:text-gray-700 text-2xl">
                                &#10095;
                            </button>
                        </div>

                        <!-- "See all details" Link at Last -->
                        <div class="text-center mt-4">
                            <a href="#" class="text-blue-600 text-sm font-semibold hover:underline">See all details</a>
                        </div>
                    </div>
                </div>

                <script>
                    let slider = document.getElementById("sliderContent");
                    let wrapper = document.getElementById("sliderWrapper");
                    let position = 0;
                    const step = 160; // Scroll step

                    document.getElementById("prevBtn").addEventListener("click", () => {
                        position = Math.min(position + step, 0);
                        slider.style.transform = `translateX(${position}px)`;
                    });

                    document.getElementById("nextBtn").addEventListener("click", () => {
                        let maxScroll = wrapper.clientWidth - slider.scrollWidth;
                        position = Math.max(position - step, maxScroll);
                        slider.style.transform = `translateX(${position}px)`;
                    });
                </script>


            </div>



            <!-- Details Section -->
            <div class="md:col-span-4 flex flex-col gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-300 flex flex-col space-y-2">
                    <!-- Price and Icons -->
                    <div class="flex justify-between items-center">
                        <h3 class="text-2xl font-bold text-blue-600">₹3,000</h3>
                        <div class="flex space-x-3">
                            <!-- Share Icon -->
                            <button class="text-gray-500 hover:text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 7h5m0 0v5m0-5L9 18l-4-4" />
                                </svg>
                            </button>
                            <!-- Heart Icon -->
                            <button class="text-gray-500 hover:text-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.29 3.71a5.5 5.5 0 00-7.78 7.78l8.49 8.49 8.49-8.49a5.5 5.5 0 00-7.78-7.78L12 2.92l-.71-.71z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Product Title -->
                    <p class="text-gray-700">Sell NEET book module and books</p>

                    <!-- Location and Date -->
                    <div class="flex justify-between text-sm text-gray-500">
                        <p>Ambedkar Puram, Kanpur, Uttar Pradesh</p>
                        <p>Today</p>
                    </div>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-300">
                    <!-- User Info Section -->
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <!-- Avatar -->
                            <div class="w-10 h-10 bg-teal-300 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-6 h-6 text-teal-900">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 14c3.866 0 7 1.343 7 3v2H5v-2c0-1.657 3.134-3 7-3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 10a4 4 0 100-8 4 4 0 000 8z" />
                                </svg>
                            </div>
                            <!-- Name -->
                            <p class="font-semibold text-gray-900">Satyam</p>
                        </div>
                        <!-- Arrow Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-5 h-5 text-gray-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>

                    <!-- Chat Button -->
                    <button
                        class="mt-4 w-full border border-gray-400 text-gray-900 font-semibold py-2 rounded-lg hover:bg-gray-100 transition">
                        Chat with Seller
                    </button>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-300">
                    <p class="text-gray-900 font-semibold">Posted in</p>
                    <p class="text-blue-600">Ambedkar Puram, Kanpur, Uttar Pradesh</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-md border border-gray-300">
                    <?php
                    // Dynamic Latitude & Longitude
                    $latitude = 25.5940947;  // Replace with database value
                    $longitude = 85.1375645; // Replace with database value
                    ?>
                    <!-- Google Maps Embed -->
                    <iframe class="w-full h-60 rounded-lg"
                        src="https://www.google.com/maps?q=25°47'44.1,87°06'36.1&output=embed" allowfullscreen=""
                        loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>


            </div>

            <div id="fullscreenModal"
                class="fixed top-0 left-0 w-full h-full bg-black bg-opacity-90 flex justify-center items-center hidden">
                <button onclick="prevImage()"
                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md border border-gray-300 hover:bg-gray-100 transition">
                    ⬅️
                </button>

                <img id="fullscreenImage" class="max-w-full max-h-full rounded-lg">

                <button onclick="nextImage()"
                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow-md border border-gray-300 hover:bg-gray-100 transition">
                    ➡️
                </button>

                <button onclick="closeFullScreen()"
                    class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
            </div>

            <script>
                const images = [
                    "images/color palatte.png?random=1",
                    "images/defaultUser.webp?random=2",
                    "images/navbar.png?random=3",
                    "images/20221013_211226.jpg?random=4"
                ];

                let currentIndex = 0;

                function changeImage(index) {
                    currentIndex = index;
                    document.getElementById("mainImage").src = images[currentIndex];
                }

                function prevImage() {
                    currentIndex = (currentIndex - 1 + images.length) % images.length;
                    document.getElementById("mainImage").src = images[currentIndex];
                    document.getElementById("fullscreenImage").src = images[currentIndex];
                }

                function nextImage() {
                    currentIndex = (currentIndex + 1) % images.length;
                    document.getElementById("mainImage").src = images[currentIndex];
                    document.getElementById("fullscreenImage").src = images[currentIndex];
                }

                function openFullScreen() {
                    document.getElementById("fullscreenImage").src = images[currentIndex];
                    document.getElementById("fullscreenModal").classList.remove("hidden");
                }

                function closeFullScreen() {
                    document.getElementById("fullscreenModal").classList.add("hidden");
                }

                document.addEventListener("keydown", function (event) {
                    if (event.key === "ArrowLeft") prevImage();
                    if (event.key === "ArrowRight") nextImage();
                    if (event.key === "Escape") closeFullScreen();
                });
            </script>
        </div>
    </div>

</body>

</html>