<?php include_once "../config/connect.php";?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - Kitabiadda</title>
    <link rel="icon" href="favicon.ico" />
    <meta name="description" content="Learn about Kitabiadda - your destination to buy and sell books." />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body class="bg-[#FBFFE4] text-gray-800 font-sans bg-[url('https://www.transparenttextures.com/patterns/white-wall-3.png')]">

    <!-- Header -->
    <?php include_once "../includes/header.php"; ?>
    <?php include_once "../includes/subheader.php"; ?>

    <!-- Ribbon Header -->
    <div class="relative w-fit mx-auto mt-40">
        <div class="bg-[#3D8D7A] text-white text-2xl font-bold py-3 px-8 rounded-r-lg relative z-10">
            About Kitabiadda
        </div>
        <div class="absolute left-[-20px] top-0 w-0 h-0 border-t-[48px] border-t-[#3D8D7A] border-l-[20px] border-l-transparent z-0"></div>
        <p class="text-sm mt-2 text-center text-gray-700">Your One-Stop Destination to Buy & Sell New and Pre-Loved Books</p>
    </div>

    <!-- Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-12 space-y-12">

        <!-- Section: Who We Are -->
        <section class="border-4 border-[#B3D8A8] bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Who We Are</h2>
            <p class="mt-4 text-lg leading-relaxed text-center">
                Kitabiadda is a book lover's paradise. We provide a platform where you can discover new books,
                buy your favorite ones at affordable prices, and even sell your old books to fellow readers.
                Whether you're a passionate reader or just getting started, Kitabiadda helps you keep the pages turning.
            </p>
        </section>

        <!-- Section: What We Do -->
        <section class="border-4 border-[#B3D8A8] bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">What We Do</h2>
            <ul class="mt-4 list-disc list-inside space-y-2 text-lg text-gray-800">
                <li>📚 Sell brand new books across all genres</li>
                <li>📦 Help users buy second-hand books in great condition</li>
                <li>🔄 Let readers sell their pre-loved books easily</li>
                <li>💬 Build a community for book lovers to connect</li>
            </ul>
        </section>

        <!-- Section: Our Mission -->
        <section class="border-4 border-[#B3D8A8] bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Our Mission</h2>
            <p class="mt-4 text-lg text-center leading-relaxed">
                We aim to make reading affordable, sustainable, and accessible to everyone.
                By encouraging book reuse and sharing, we're building a community that values
                stories, learning, and the joy of reading.
            </p>
        </section>

        <!-- Section: Why Choose Us -->
        <section class="border-4 border-[#B3D8A8] bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Why Choose Kitabiadda?</h2>
            <ul class="mt-4 list-disc list-inside space-y-2 text-lg text-gray-800">
                <li>Affordable book prices</li>
                <li>Eco-friendly book reuse system</li>
                <li>Easy-to-use platform for selling old books</li>
                <li>Fast shipping and secure payment options</li>
                <li>Constantly updated catalog with latest titles</li>
            </ul>
        </section>

        <!-- Section: Join Us -->
        <section class="border-4 border-[#B3D8A8] bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Join the Kitabiadda Journey</h2>
            <p class="mt-4 text-lg text-center leading-relaxed">
                Whether you want to sell the books you’ve already read or find your next favorite novel, Kitabiadda is here for you.
                Let’s read, share, and grow—together.
            </p>
        </section>

    </main>

    <!-- Footer -->
    <?php include_once "../includes/footer2.php"; ?>
</body>

</html>