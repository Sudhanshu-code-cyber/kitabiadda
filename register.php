<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 min-h-screen">

    <div class="flex flex-col md:flex-row items-center justify-center min-h-screen bg-cover bg-center bg-fixed p-4"
        style="background-image: url('assets/login-bg.webp');">

        <!-- Logo and Slogan Section -->
        <div class="md:mr-12 text-center md:text-left  md:mb-0 w-full md:w-auto">
            <div class="flex flex-col justify-center items-center md:justify-start">
                <img src="assets/logo5.png" alt="BookStore Logo" class="h-16 md:h-20 w-auto">
                <h1 class="font-bold text-white">
                    Buy - Read - Sell
                </h1>
            </div>

        </div>

        <!-- Registration Form Section -->
        <div class="bg-transparent backdrop-blur-sm p-5 rounded border shadow-xl w-full md:w-96">
            <h2 class="text-2xl font-bold text-center text-gray-100 mb-5">Create an Account</h2>

            <form action="actions/register_action.php" method="post" class="flex flex-col gap-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="md:col-span-2">
                        <label class="text-gray-100 text-lg">Full Name</label>
                        <input type="text" name="name"
                            class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="text-gray-100 text-lg">Email Address</label>
                        <input type="email" name="email"
                            class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="text-gray-100 text-lg">Contact</label>
                        <input type="text" name="contact"
                            class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-gray-100 text-lg">Gender</label>
                        <select name="gender" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-gray-100 text-lg">Password</label>
                        <input type="password" name="password"
                            class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="text-gray-100 text-lg">Confirm Password</label>
                        <input type="password" name="confirm_password"
                            class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                    </div>
                </div>
                <button type="submit" name="register"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition mt-2">
                    Register
                </button>
                <p class="text-lg text-center font-semibold text-gray-100 mt-3">
                    Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login here</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>