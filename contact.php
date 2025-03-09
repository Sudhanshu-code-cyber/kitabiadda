<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - ReadRainbow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
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
    </style>
</head>

<body class="text-gray-800 font-sans">

    <!-- Header -->
    <div class="text-center mt-10">
        <div class="ribbon">Contact Us</div>
        <p class="text-sm mt-2 text-gray-700">We'd love to hear from you! Reach out to us anytime.</p>
    </div>

    <!-- Main Section -->
    <main class="max-w-5xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">

        <!-- Contact Info -->
        <div class="bg-white rounded-xl shadow-lg border-4 border-[#B3D8A8] p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] mb-4">Get in Touch</h2>
            <p class="text-lg mb-4">Have a question, feedback, or just want to chat? Drop us a message and our team will get back to you as soon as possible.</p>

            <div class="space-y-4 text-lg">
                <p>📍 <strong>Address:</strong> 123 Book Lane, Storyville, India - 123456</p>
                <p>📞 <strong>Phone:</strong> +91-9876543210</p>
                <p>✉️ <strong>Email:</strong> support@readrainbow.in</p>
                <p>🕒 <strong>Working Hours:</strong> Mon - Sat (9:00 AM - 7:00 PM)</p>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-white rounded-xl shadow-lg border-4 border-[#B3D8A8] p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] mb-4">Send a Message</h2>

            <form class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-medium">Your Name</label>
                    <input type="text" placeholder="Enter your name"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3D8D7A]" required />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" placeholder="Enter your email"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3D8D7A]" required />
                </div>

                <div>
                    <label class="block text-gray-700 font-medium">Message</label>
                    <textarea placeholder="Write your message here..." rows="5"
                        class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-[#3D8D7A]" required></textarea>
                </div>

                <button type="submit"
                    class="bg-[#3D8D7A] text-white px-6 py-2 rounded-md hover:bg-[#2F6C5D] transition-all">Send
                    Message</button>
            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-[#3D8D7A] text-white text-center py-6 mt-10">
        <p>&copy; 2025 ReadRainbow. All rights reserved.</p>
    </footer>

</body>

</html>