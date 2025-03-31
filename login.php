<?php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>

<body class="bg-gray-900 min-h-screen">

    <div class="flex flex-col md:flex-row items-center justify-center min-h-screen bg-cover bg-center bg-fixed p-4"
        style="background-image: url('assets/login-bg.webp');">

        <!-- Logo and Slogan Section -->
        <div class="md:mr-12 text-center md:text-left mb-8 md:mb-0 w-full md:w-auto">
            <div class="flex flex-col items-center justify-center md:justify-start">
                <img src="assets/logo5.png" alt="BookStore Logo" class="h-16 md:h-20 w-auto">
                <h2 class="text-gray-100 font-semibold max-w-md">
                    Buy - Read - Sell
                </h2>
            </div>

        </div>

        <!-- Login Form Section -->
        <div class="bg-transparent backdrop-blur-sm p-5 rounded border shadow-xl w-full md:w-96">
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
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    Login
                </button>


                <p class="text-lg text-center font-semibold text-gray-100 mt-3">
                    Don't have an account?
                    <a href="register.php" class="text-blue-500 hover:underline">Register Now</a>
                </p>
            </form>
            <hr>
            <br>
            <?php
            require 'vendor/autoload.php';

            session_start();

            $client = new Google_Client();
            $client->setClientId('642231406648-2do70qjtogm5q4tq82r7t2s14qc0jtgj.apps.googleusercontent.com');
            $client->setClientSecret('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');
            $client->setRedirectUri('http://localhost/readrainbow/index.php');
            $client->addScope(['email', 'profile']);

            $login_url = $client->createAuthUrl();
            ?>

            <!-- <a href="">Login with Google</a> -->

            <a href="<?= $login_url ?>"
                class="flex items-center justify-center w-full px-4 py-2 text-white bg-blue-800 border border-gray-300 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 48 48">
                    <path fill="#4285F4"
                        d="M24 9.5c3.19 0 6.07 1.1 8.38 2.93l6.23-6.23C34.92 2.29 29.74 0 24 0 14.68 0 6.72 5.38 2.61 13.24l7.24 5.63C12.21 13.17 17.63 9.5 24 9.5z" />
                    <path fill="#34A853"
                        d="M46.38 24.5c0-1.5-.14-2.97-.4-4.38H24v8.31h12.69c-.5 2.5-1.92 4.63-3.94 6.16l6.22 6.22c4.06-3.75 6.41-9.3 6.41-15.81z" />
                    <path fill="#FBBC05"
                        d="M10.78 28.11c-.68-2.03-1.06-4.19-1.06-6.39s.38-4.36 1.06-6.39L3.54 9.36A23.996 23.996 0 000 21.72c0 3.78.9 7.34 2.54 10.51l8.24-4.12z" />
                    <path fill="#EA4335"
                        d="M24 48c6.49 0 11.93-2.14 15.92-5.79l-6.22-6.22c-2.19 1.47-4.92 2.31-7.7 2.31-6.37 0-11.79-3.67-14.14-8.87l-8.24 4.12C6.72 42.62 14.68 48 24 48z" />
                </svg>
                <span class="font-medium">Login with Google</span>
            </a>


        </div>
    </div>

</body>

</html>