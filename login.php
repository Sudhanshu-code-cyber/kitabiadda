<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900">

    <div class="relative w-full h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('assets/login-bg.webp');">

        <div class="relative bg-transparent backdrop-blur-sm p-5  rounded border shadow-xl w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-100 mb-5">Login</h2>

            <form action="actions/login_action.php" method="post" class="flex flex-col gap-3">
                <div>
                    <label class="text-gray-100 text-lg">Email Address</label>
                    <input type="email" name="email"
                        class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="text-gray-100 text-lg">Password</label>
                    <input type="password" name="password"
                        class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <button type="submit" name="login"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">login</button>
                <p class="text-lg text-center font-semibold text-gray-100 mt-3">
                    Don't have an account? <a href="register.php" class="text-blue-500 hover:underline">Register Now</a>
                </p>
            </form>
        </div>
    </div>

</body>

</html>