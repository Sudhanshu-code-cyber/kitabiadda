<?php include_once "config/connect.php"; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Us - ReadRainbow</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#FBFFE4] text-gray-800 font-sans">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="relative w-fit mx-auto mt-40">
        <div class="bg-[#3D8D7A] text-white text-2xl font-bold py-3 px-8 rounded-r-lg relative z-10">
            Contact Us
        </div>
        <div class="absolute left-[-20px] top-0 w-0 h-0 border-t-[48px] border-t-[#3D8D7A] border-l-[20px] border-l-transparent z-0"></div>
        <p class="text-sm mt-2 text-center text-gray-700">We'd love to hear from you! Reach out to us anytime.</p>
    </div>

    <main class="max-w-5xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">

        <div class="bg-white rounded-xl shadow-lg border-4 border-[#B3D8A8] p-6">
            <h2 class="text-2xl font-semibold text-[#3D8D7A] mb-4">Get in Touch</h2>
            <p class="text-lg mb-4">Have a question, feedback, or just want to chat? Drop us a message and our team will get back to you as soon as possible.</p>

            <div class="space-y-4 text-lg">
                <p>📍 <strong>Address:</strong> Purnea (Bihar)</p>
                <p>📞 <strong>Phone:</strong> +91-9876543210</p>
                <p>✉️ <strong>Email:</strong> readrainbow12@gmail.com</p>
                <p>🕒 <strong>Working Hours:</strong> Mon - Sat (9:00 AM - 7:00 PM)</p>
            </div>
        </div>

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
    <?php include_once "includes/footer2.php"; ?>
</body>

</html>