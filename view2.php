<?php include_once "config/connect.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookHub - Second-Hand Books Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-[#FBFFE4] text-gray-800  bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')] font-sans">
    <?php include_once "includes/header.php";?>
    <?php include_once "includes/subheader.php";?>
    <div class="mt-28 flex w-full bg-white rounded-lg shadow-sm overflow-hidden border border-gray-200">
        <!-- Header with platform name -->
        
        <div class="w-6/12 h-[400px] bg-red-100">
           <div class="relative w-full max-w-md mx-auto">
                <!-- Image Container -->
                <div class="overflow-hidden h- rounded-lg">
                    <img id="carousel-image"
                        src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Book Cover" class="h-[400px] w-full object-contain transition-opacity duration-500">
                </div>

                <!-- Navigation Buttons -->
              <div class="flex justify-between">
              <button id="prevBtn"
                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-black text-white p-2 rounded-full bg-opacity-50 hover:bg-opacity-80">
                    ◀
                </button>
                <button id="nextBtn"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-black text-white p-2 rounded-full bg-opacity-50 hover:bg-opacity-80">
                    ▶
                </button>
              </div>

                <!-- Image Counter -->
                <div id="image-counter"
                    class="absolute bottom-2 right-2 bg-black text-white px-2 py-1 rounded text-sm bg-opacity-50">
                    1/4
                </div>
            </div>

            <script>
                const images = [
                    "https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1529148482759-b35b25c5ff01?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80",
                    "https://images.unsplash.com/photo-1532009877282-3340270e0529?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                ];

                let currentIndex = 0;
                const imageElement = document.getElementById("carousel-image");
                const counterElement = document.getElementById("image-counter");

                document.getElementById("prevBtn").addEventListener("click", () => {
                    currentIndex = (currentIndex === 0) ? images.length - 1 : currentIndex - 1;
                    updateImage();
                });

                document.getElementById("nextBtn").addEventListener("click", () => {
                    currentIndex = (currentIndex === images.length - 1) ? 0 : currentIndex + 1;
                    updateImage();
                });

                function updateImage() {
                    imageElement.style.opacity = "0";
                    setTimeout(() => {
                        imageElement.src = images[currentIndex];
                        counterElement.textContent = (currentIndex + 1) + "/" + images.length;
                        imageElement.style.opacity = "1";
                    }, 300);
                }
            </script>
        </div>
        
        <!-- Main content -->
        <div class="p-5 w-6/12">
            <!-- Book Details Section -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Book Details</h2>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Condition</p>
                        <p class="font-medium">Good (Highlighted in some pages)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Edition</p>
                        <p class="font-medium">3rd Edition (2020)</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-medium">Computer Science</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Pages</p>
                        <p class="font-medium">420</p>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Description</h2>
                <p class="text-gray-700 mb-3">
                    Clean copy of "Introduction to Algorithms" with minimal wear. Some highlighting in first few
                    chapters.
                    Includes all original content. No torn pages or water damage. Perfect for CS students.
                </p>
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-3">
                    <p class="font-bold text-yellow-800 text-2xl">₹450</p>
                    <p class="text-gray-800 font-medium text-lg">Introduction to Algorithms by Cormen</p>
                    <p class="text-sm text-gray-600 mt-1">Original Price: ₹1200 (You save 62%)</p>
                </div>
            </div>

            <!-- Seller Info -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <div class="flex items-center mb-3">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mr-3">
                        <span class="text-blue-800 font-medium text-xl">RS</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">Rahul Sharma</p>
                        <p class="text-sm text-gray-600">Seller since 2023</p>
                        <div class="flex items-center mt-1 text-yellow-400">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-gray-600 text-sm ml-1">4.5 (12 reviews)</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-3 mt-3">
                    <button id="chatBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition duration-200">
                        <i class="fas fa-comment-dots mr-2"></i>Chat
                    </button>
                </div>
            </div>

            <!-- Location Info -->
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">Location</h2>
                <div class="flex items-center text-gray-600 mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                    <span>Vijay Nagar, Delhi, India</span>
                </div>
                <div class="text-sm text-gray-500 mb-4">
                    <span>Posted on Apr 2, 2025</span>
                    <span class="mx-2">•</span>
                    <span>Last updated 2 days ago</span>
                </div>

                <!-- Interactive Map -->
                <div class="mt-6">
                    <iframe class="w-full h-64 rounded-lg" 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3157.687502634852!2d92.72131!3d11.6789!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTHCsDQwJzQ0LjQiTiA5MsKwNDMnMTkuMSJF!5e0!3m2!1sen!2sin!4v1616748401553!5m2!1sen!2sin" 
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
                <a href="https://www.google.com/maps/place/Vijay+Nagar,+Delhi" target="_blank" rel="noopener noreferrer"
                    class="text-blue-600 text-sm font-medium inline-block">
                    <i class="fas fa-external-link-alt mr-1"></i> Open in Maps
                </a>
            </div>

            <!-- Footer with AD ID -->
            <div class="flex justify-between items-center text-sm text-gray-500 border-t pt-3 mt-4">
                <span>AD ID: BK1801736603</span>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <i class="far fa-flag mr-1"></i> Report
                    </a>
                    <a href="#" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-ban mr-1"></i> Block
                    </a>
                </div>
            </div>
        </div>

        <!-- Fixed Bottom Action Bar (for mobile) -->
        <div class="md:hidden sticky bottom-0 bg-white border-t border-gray-200 p-3">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-bold text-lg">₹450</p>
                    <p class="text-xs text-gray-500">Negotiable</p>
                </div>
                <button id="buyNowBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg font-medium">
                    Buy Now
                </button>
            </div>
        </div>
    </div>

    <script>
        // Chat Button Functionality
        document.getElementById('chatBtn').addEventListener('click', function() {
            // Check if user is logged in (you'll need to implement this check)
            <?php if(isset($_SESSION['user'])): ?>
                window.location.href = 'chat.php?seller_id=123'; // Replace with actual seller ID
            <?php else: ?>
                window.location.href = 'login.php?redirect=chat.php?seller_id=123';
            <?php endif; ?>
        });

        // Buy Now Button Functionality
        document.getElementById('buyNowBtn').addEventListener('click', function() {
            <?php if(isset($_SESSION['user'])): ?>
                window.location.href = 'checkout.php?book_id=123'; // Replace with actual book ID
            <?php else: ?>
                window.location.href = 'login.php?redirect=checkout.php?book_id=123';
            <?php endif; ?>
        });

        // Report Button Functionality
        document.querySelector('a[href="#"]').addEventListener('click', function(e) {
            e.preventDefault();
            alert('Report functionality will be implemented soon.');
        });

        // Block Button Functionality
        document.querySelectorAll('a[href="#"]')[1].addEventListener('click', function(e) {
            e.preventDefault();
            alert('Block functionality will be implemented soon.');
        });
    </script>

    <?php include_once "includes/footer2.php";?>
</body>
</html>