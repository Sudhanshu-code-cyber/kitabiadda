<?php
include_once "../config/connect.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KitabiAdda Blog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .category-tag:hover {
            background-color: #3D8D7A;
            color: white;
        }

        .read-more:hover .arrow {
            transform: translateX(3px);
        }
    </style>
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "../includes/header.php"; ?>
    <?php include_once "../includes/subheader.php"; ?>
    <section class="bg-gradient-to-r mt-28 from-[#B3D8A8] to-[#3D8D7A] text-white py-16 md:py-24">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">KitabiAdda Blog</h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">Discover literary insights, book reviews, and reading inspiration</p>

            <div class="max-w-2xl mx-auto relative">
                <input type="text" placeholder="Search blog posts..."
                    class="w-full px-6 py-3 rounded-full border-0 focus:ring-2 focus:ring-[#3D8D7A] shadow-lg">
                <button class="absolute right-2 top-2 bg-[#3D8D7A] text-white p-2 rounded-full hover:bg-[#2c6b5b]">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Blog Posts Section -->
            <div class="lg:w-2/3">
                <!-- Featured Post -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden mb-10">
                    <img src="https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Featured Blog Post" class="w-full h-64 md:h-80 object-cover">

                    <div class="p-6 md:p-8">
                        <div class="flex items-center mb-4">
                            <span class="bg-[#E8F5F2] text-[#3D8D7A] text-xs font-semibold px-3 py-1 rounded-full">Featured</span>
                            <span class="text-gray-500 text-sm ml-4">June 15, 2023</span>
                        </div>

                        <h2 class="text-2xl md:text-3xl font-bold mb-3">The Ultimate Guide to Building Your Personal Library</h2>

                        <p class="text-gray-600 mb-4">Discover how to curate a personal library that reflects your reading journey and inspires your literary adventures...</p>

                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="category-tag bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full cursor-pointer transition">Bookshelves</span>
                            <span class="category-tag bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full cursor-pointer transition">Organization</span>
                            <span class="category-tag bg-gray-100 text-gray-800 text-xs px-3 py-1 rounded-full cursor-pointer transition">Reading</span>
                        </div>

                        <a href="blog-post.php" class="read-more text-[#3D8D7A] font-medium flex items-center transition">
                            Read more <span class="arrow ml-1 transition">→</span>
                        </a>
                    </div>
                </div>

                <!-- Blog Posts Grid -->
                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Blog Post 1 -->
                    <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden transition duration-300">
                        <img src="https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
                            alt="Blog Post" class="w-full h-48 object-cover">

                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="text-gray-500 text-sm">May 28, 2023</span>
                                <span class="text-gray-500 text-sm mx-2">•</span>
                                <span class="text-gray-500 text-sm">8 min read</span>
                            </div>

                            <h3 class="text-xl font-bold mb-2">10 Must-Read Books for Summer 2023</h3>

                            <p class="text-gray-600 mb-4 text-sm">Our curated selection of the hottest summer reads to enjoy by the pool or at the beach...</p>

                            <a href="blog-post.php" class="read-more text-[#3D8D7A] text-sm font-medium flex items-center">
                                Read more <span class="arrow ml-1 transition">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Blog Post 2 -->
                    <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden transition duration-300">
                        <img src="https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
                            alt="Blog Post" class="w-full h-48 object-cover">

                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="text-gray-500 text-sm">April 15, 2023</span>
                                <span class="text-gray-500 text-sm mx-2">•</span>
                                <span class="text-gray-500 text-sm">6 min read</span>
                            </div>

                            <h3 class="text-xl font-bold mb-2">How to Develop a Consistent Reading Habit</h3>

                            <p class="text-gray-600 mb-4 text-sm">Practical tips to help you read more books and make reading a daily habit that sticks...</p>

                            <a href="blog-post.php" class="read-more text-[#3D8D7A] text-sm font-medium flex items-center">
                                Read more <span class="arrow ml-1 transition">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Blog Post 3 -->
                    <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden transition duration-300">
                        <img src="https://images.unsplash.com/photo-1506880018603-83d5b814b5a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
                            alt="Blog Post" class="w-full h-48 object-cover">

                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="text-gray-500 text-sm">March 22, 2023</span>
                                <span class="text-gray-500 text-sm mx-2">•</span>
                                <span class="text-gray-500 text-sm">10 min read</span>
                            </div>

                            <h3 class="text-xl font-bold mb-2">The Benefits of Reading Before Bed</h3>

                            <p class="text-gray-600 mb-4 text-sm">Discover how reading before sleep can improve your mental health and sleep quality...</p>

                            <a href="blog-post.php" class="read-more text-[#3D8D7A] text-sm font-medium flex items-center">
                                Read more <span class="arrow ml-1 transition">→</span>
                            </a>
                        </div>
                    </div>

                    <!-- Blog Post 4 -->
                    <div class="blog-card bg-white rounded-xl shadow-md overflow-hidden transition duration-300">
                        <img src="https://images.unsplash.com/photo-1512820790803-83ca734da794?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80"
                            alt="Blog Post" class="w-full h-48 object-cover">

                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <span class="text-gray-500 text-sm">February 10, 2023</span>
                                <span class="text-gray-500 text-sm mx-2">•</span>
                                <span class="text-gray-500 text-sm">12 min read</span>
                            </div>

                            <h3 class="text-xl font-bold mb-2">Classic Literature Worth Revisiting</h3>

                            <p class="text-gray-600 mb-4 text-sm">Timeless classics that offer new insights with each reading and why they remain relevant today...</p>

                            <a href="blog-post.php" class="read-more text-[#3D8D7A] text-sm font-medium flex items-center">
                                Read more <span class="arrow ml-1 transition">→</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex justify-center mt-12">
                    <nav class="flex items-center space-x-2">
                        <a href="#" class="px-3 py-1 rounded-md bg-[#3D8D7A] text-white">1</a>
                        <a href="#" class="px-3 py-1 rounded-md hover:bg-gray-100">2</a>
                        <a href="#" class="px-3 py-1 rounded-md hover:bg-gray-100">3</a>
                        <a href="#" class="px-3 py-1 rounded-md hover:bg-gray-100">Next →</a>
                    </nav>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <!-- About Widget -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h3 class="text-xl font-bold mb-4 text-[#3D8D7A]">About KitabiAdda Blog</h3>
                    <p class="text-gray-600 mb-4">Welcome to our literary corner where we share book reviews, reading tips, and all things book-related from the KitabiAdda community.</p>
                    <a href="about.php" class="text-[#3D8D7A] font-medium flex items-center">
                        Learn more <span class="arrow ml-1 transition">→</span>
                    </a>
                </div>

                <!-- Categories Widget -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                    <h3 class="text-xl font-bold mb-4 text-[#3D8D7A]">Categories</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-700 hover:text-[#3D8D7A] flex justify-between"><span>Book Reviews</span> <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">24</span></a></li>
                        <li><a href="#" class="text-gray-700 hover:text-[#3D8D7A] flex justify-between"><span>Reading Tips</span> <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">18</span></a></li>
                        <li><a href="#" class="text-gray-700 hover:text-[#3D8D7A] flex justify-between"><span>Author Interviews</span> <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">12</span></a></li>
                        <li><a href="#" class="text-gray-700 hover:text-[#3D8D7A] flex justify-between"><span>Literary Events</span> <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">9</span></a></li>
                        <li><a href="#" class="text-gray-700 hover:text-[#3D8D7A] flex justify-between"><span>Book Clubs</span> <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full">7</span></a></li>
                    </ul>
                </div>

                <!-- Popular Posts Widget -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4 text-[#3D8D7A]">Popular Posts</h3>
                    <div class="space-y-4">
                        <a href="#" class="flex items-start gap-3 group">
                            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80"
                                alt="Popular Post" class="w-16 h-16 object-cover rounded-md">
                            <div>
                                <h4 class="font-medium text-gray-800 group-hover:text-[#3D8D7A]">How to Choose Your Next Book</h4>
                                <span class="text-xs text-gray-500">May 5, 2023</span>
                            </div>
                        </a>
                        <a href="#" class="flex items-start gap-3 group">
                            <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80"
                                alt="Popular Post" class="w-16 h-16 object-cover rounded-md">
                            <div>
                                <h4 class="font-medium text-gray-800 group-hover:text-[#3D8D7A]">Best Bookstores in India</h4>
                                <span class="text-xs text-gray-500">April 18, 2023</span>
                            </div>
                        </a>
                        <a href="#" class="flex items-start gap-3 group">
                            <img src="https://images.unsplash.com/photo-1584824486509-112e4181ff6b?ixlib=rb-1.2.1&auto=format&fit=crop&w=100&q=80"
                                alt="Popular Post" class="w-16 h-16 object-cover rounded-md">
                            <div>
                                <h4 class="font-medium text-gray-800 group-hover:text-[#3D8D7A]">Digital vs Physical Books</h4>
                                <span class="text-xs text-gray-500">March 30, 2023</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Newsletter Section -->
    <?php include_once "../includes/footer2.php"; ?>
</body>

</html>