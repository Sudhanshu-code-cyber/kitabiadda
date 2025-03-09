<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About Us - ReadRainbow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://www.transparenttextures.com/patterns/white-wall-3.png');
            background-color: #FBFFE4;
        }

        .ribbon {
            background: #3D8D7A;
            color: white;
            padding: 12px 30px;
            font-size: 1.8rem;
            font-weight: bold;
            display: inline-block;
            border-radius: 0 0.5rem 0.5rem 0;
            position: relative;
        }

        .ribbon::before {
            content: '';
            position: absolute;
            top: 0;
            left: -20px;
            width: 0;
            height: 0;
            border-top: 40px solid #3D8D7A;
            border-left: 20px solid transparent;
        }

        .frame-box {
            border: 6px solid #B3D8A8;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="text-gray-800 font-sans">

    <!-- Header (Ribbon Style) -->
    <div class="text-center mt-10">
        <div class="ribbon">About ReadRainbow</div>
        <p class="text-sm mt-2 text-gray-700">Your One-Stop Destination to Buy & Sell New and Pre-Loved Books</p>
    </div>

    <!-- Framed Main Content -->
    <main class="max-w-5xl mx-auto px-4 py-12 space-y-12">

        <section class="frame-box p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Who We Are</h2>
            <p class="mt-4 text-lg leading-relaxed text-center">
                ReadRainbow is a book lover's paradise. We provide a platform where you can discover new books,
                buy your favorite ones at affordable prices, and even sell your old books to fellow readers.
                Whether you're a passionate reader or just getting started, ReadRainbow helps you keep the pages turning.
            </p>
        </section>

        <section class="frame-box p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">What We Do</h2>
            <ul class="mt-4 list-disc list-inside space-y-2 text-lg text-gray-800">
                <li>📚 Sell brand new books across all genres</li>
                <li>📦 Help users buy second-hand books in great condition</li>
                <li>🔄 Let readers sell their pre-loved books easily</li>
                <li>💬 Build a community for book lovers to connect</li>
            </ul>
        </section>

        <section class="frame-box p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Our Mission</h2>
            <p class="mt-4 text-lg text-center leading-relaxed">
                We aim to make reading affordable, sustainable, and accessible to everyone.
                By encouraging book reuse and sharing, we're building a community that values
                stories, learning, and the joy of reading.
            </p>
        </section>

        <section class="frame-box p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Why Choose ReadRainbow?</h2>
            <ul class="mt-4 list-disc list-inside space-y-2 text-lg text-gray-800">
                <li>Affordable book prices</li>
                <li>Eco-friendly book reuse system</li>
                <li>Easy-to-use platform for selling old books</li>
                <li>Fast shipping and secure payment options</li>
                <li>Constantly updated catalog with latest titles</li>
            </ul>
        </section>

        <section class="frame-box p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] text-center">Join the ReadRainbow Journey</h2>
            <p class="mt-4 text-lg text-center leading-relaxed">
                Whether you want to sell the books you’ve already read or find your next favorite novel, ReadRainbow is here for you.
                Let’s read, share, and grow—together.
            </p>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-[#3D8D7A] text-white text-center py-6 mt-10">
        <p>&copy; 2025 ReadRainbow. All rights reserved.</p>
    </footer>

</body>

</html>