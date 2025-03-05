<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BookStore</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900">

    <div class="relative w-full h-screen flex items-center justify-center bg-cover bg-center" style="background-image: url('assets/login-bg.webp');">

        <div class="relative bg-transparent backdrop-blur-sm p-5  rounded border shadow-xl w-full max-w-md">
            <h2 class="text-2xl font-bold text-center text-gray-100 mb-5">Create an Account</h2>

            <form action="actions/register_action.php" method="post" class="flex flex-col gap-3">
                <div class="grid grid-cols-2 gap-2">
                <div>
                    <label class="text-gray-100 text-lg">Full Name</label>
                    <input type="text" name="name" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="text-gray-100 text-lg">Email Address</label>
                    <input type="email" name="email" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <div>
                    <label class="text-gray-100 text-lg">Contact</label>
                    <input type="text" name="contact" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                <label for="" class="text-gray-100 text-lg"></label>
                <select name="gender" id="" class="p- rounded">
                    <option value="">Select Gender</option>
                    <option value="">Male</option>
                    <option value="">Female</option>
                </select>

                <div>
                    <label class="text-gray-100 text-lg">Password</label>
                    <input type="password" name="password" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>

                <div>
                    <label class="text-gray-100 text-lg">Confirm Password</label>
                    <input type="password" name="confirm_password" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-500" required>
                </div>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Register</button>

                <p class="text-sm text-center text-gray-600 mt-3">
                    Already have an account? <a href="login.php" class="text-blue-500 hover:underline">Login here</a>
                </p>
            </form>
        </div>
    </div>

</body>
</html>
