<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Simple Blog Page - KitabiAdda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-[#FBFFE4] text-gray-800">

    <!-- Hero -->
    <section class="bg-gradient-to-r from-[#B3D8A8] to-[#3D8D7A] text-white py-16 text-center">
        <div class="max-w-3xl mx-auto px-4">
            <h1 class="text-4xl font-bold mb-4">KitabiAdda Blog</h1>
            <p class="text-lg mb-6">Discover book reviews, literary insights & more</p>
            <div class="relative max-w-xl mx-auto">
                <input type="text" placeholder="Search blog posts..."
                    class="w-full px-5 py-3 rounded-full focus:ring-2 focus:ring-[#3D8D7A] shadow-md border-none" />
                <button class="absolute right-2 top-2 bg-[#3D8D7A] p-2 text-white rounded-full">
                    🔍
                </button>
            </div>
        </div>
    </section>

    <!-- Main Section -->
    <main class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Blog Posts -->
        <section class="lg:col-span-2 space-y-10">
            <!-- Blog Card -->
            <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-lg transition">
                <img src="https://source.unsplash.com/800x400/?books,reading" class="w-full h-60 object-cover" />
                <div class="p-6 space-y-3">
                    <h2 class="text-2xl font-semibold">The Art of Reading Consistently</h2>
                    <p class="text-sm text-gray-600">March 5, 2025 • 6 min read</p>
                    <p class="text-gray-700">Learn how to develop a sustainable and enjoyable reading habit in the digital age...</p>
                    <a href="#" class="text-[#3D8D7A] font-medium inline-flex items-center">Read more →</a>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-lg transition">
                <img src="https://source.unsplash.com/800x400/?library,bookshelf" class="w-full h-60 object-cover" />
                <div class="p-6 space-y-3">
                    <h2 class="text-2xl font-semibold">Top 10 Books to Read in 2025</h2>
                    <p class="text-sm text-gray-600">February 12, 2025 • 8 min read</p>
                    <p class="text-gray-700">From gripping fiction to insightful nonfiction, explore our must-read picks for this year...</p>
                    <a href="#" class="text-[#3D8D7A] font-medium inline-flex items-center">Read more →</a>
                </div>
            </div>
        </section>

        <!-- Sidebar -->
        <aside class="space-y-8">
            <!-- About Widget -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold text-[#3D8D7A] mb-2">About</h3>
                <p class="text-sm text-gray-600">Welcome to KitabiAdda’s blog — your go-to space for book reviews, tips & inspiration.</p>
            </div>

            <!-- Categories Widget -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold text-[#3D8D7A] mb-2">Categories</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-[#3D8D7A]">📚 Book Reviews</a></li>
                    <li><a href="#" class="hover:text-[#3D8D7A]">🧠 Reading Tips</a></li>
                    <li><a href="#" class="hover:text-[#3D8D7A]">👩‍💼 Author Interviews</a></li>
                    <li><a href="#" class="hover:text-[#3D8D7A]">📅 Events</a></li>
                </ul>
            </div>

            <!-- Popular Posts -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-bold text-[#3D8D7A] mb-2">Popular Posts</h3>
                <ul class="space-y-4 text-sm">
                    <li>
                        <a href="#" class="block hover:text-[#3D8D7A]">📖 How to Choose Your Next Book</a>
                    </li>
                    <li>
                        <a href="#" class="block hover:text-[#3D8D7A]">🏬 Best Bookstores in India</a>
                    </li>
                    <li>
                        <a href="#" class="block hover:text-[#3D8D7A]">💡 Digital vs Physical Books</a>
                    </li>
                </ul>
            </div>
        </aside>
    </main>

    <!-- Footer -->
    <footer class="bg-[#3D8D7A] text-white text-center py-6 mt-12">
        <p>© 2025 KitabiAdda. All rights reserved.</p>
    </footer>
</body>

</html> 