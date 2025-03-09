<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Website Footer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>

<body class="bg-gray-100">

    <footer class="bg-gray-900 text-white py-10">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- About Section -->
                <div class="fade-in">
                    <h2 class="text-xl font-semibold">About Us</h2>
                    <p class="mt-2 text-gray-400">Discover a vast collection of books across all genres and enjoy a seamless reading experience.</p>
                </div>

                <!-- Quick Links -->
                <div class="fade-in">
                    <h2 class="text-xl font-semibold">Quick Links</h2>
                    <ul class="mt-2 space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Home</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Categories</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Best Sellers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Social Links -->
                <div class="fade-in">
                    <h2 class="text-xl font-semibold">Follow Us</h2>
                    <div class="flex space-x-4 mt-2">
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition text-2xl">📘</a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition text-2xl">🐦</a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition text-2xl">📸</a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition text-2xl">🎥</a>
                    </div>
                </div>

                <!-- Newsletter Subscription -->
                <div class="fade-in">
                    <h2 class="text-xl font-semibold">Newsletter</h2>
                    <p class="mt-2 text-gray-400">Subscribe to get updates on new arrivals and offers.</p>
                    <form class="mt-4">
                        <input type="email" placeholder="Enter your email" class="w-full p-2 text-gray-800 rounded-md">
                        <button class="w-full mt-2 p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md transition">Subscribe</button>
                    </form>
                </div>
            </div>

            <hr class="my-6 border-gray-700">

            <!-- Copyright -->
            <p class="text-center text-gray-400">&copy; 2025 BookStore. All rights reserved.</p>
        </div>
    </footer>

    <script>
        gsap.from(".fade-in", {
            opacity: 0,
            y: 50,
            duration: 1,
            stagger: 0.3,
            ease: "power2.out"
        });
    </script>

</body>

</html>