<?php include_once "config/connect.php";
$otp = rand(11111,99999);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen px-4">

    <div class="w-full max-w-sm p-6 bg-white rounded-lg shadow-lg">
        <!-- Title -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-5">Enter Existing Email</h2>

        <!-- Login Form -->
        <form action="submit_otp.php" method="POST" class="space-y-4">

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter your email" required>
                    
                    <input type="hidden" name="otp" value="<?php echo $otp ?>">

                    
            </div>

            

            <!-- Login Button -->
            <button type="submit" name="login"
                class="w-full bg-blue-500 text-white p-3 rounded-md font-bold text-lg hover:bg-blue-600 transition duration-300">Forget Password</button>

            <!-- Forgot Password & Signup -->
            <div class="flex justify-between text-sm text-gray-600 mt-3">
                <a href="login.php" class="hover:underline">Login </a>
                <a href="signup.php" class="text-blue-500 hover:underline">Create Account</a>
            </div>
        </form>
        

        

    </div>

</body>

</html>