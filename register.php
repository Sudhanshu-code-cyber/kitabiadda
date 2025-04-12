<?php
// Example usage: show message from query string (?msg=Your+account+has+been+created)
$message = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Join Our Book Community | kitabiadda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #f8fafc, #e0f2f1);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .form-card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.4s ease;
        }

        .form-card:hover {
            transform: translateY(-5px);
        }

        .input-group {
            transition: all 0.3s ease;
        }

        .input-group:focus-within {
            transform: translateX(5px);
        }

        .form-input {
            border-left: 4px solid transparent;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-left-color: #3D8D7A;
            box-shadow: 0 0 0 3px rgba(61, 141, 122, 0.15);
        }

        .btn-register {
            background: #3D8D7A;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .benefit-item {
            transition: all 0.3s ease;
        }

        .benefit-item:hover {
            transform: translateX(10px);
        }

        .floating-books {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .form-wrapper {
            width: 100%;
            max-width: 1024px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="form-wrapper">
            <div class="w-full bg-white shadow-xl max-w-8xl rounded-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">
                <!-- Left Side - Motivation -->
                <div class="hidden lg:flex bg-[#3D8D7A] text-white p-10 flex-col justify-center space-y-6">
                    <div class="animate-float mb-8 flex justify-center items-center">
                        <svg class="book-icon w-32 h-32" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold">Welcome to kitabiadda!</h2>
                    <p class="text-lg">Discover, share, and fall in love with books all over again. 📚</p>
                </div>

                <!-- Right Side - Form -->
                <div class="bg-[#A3D1C6] p-8 md:p-10">
                    <div class="mb-6 text-center">
                        <img src="assets/logo5.png" alt="BookStore Logo" class="h-12 mx-auto mb-2">
                        <h2 class="text-2xl font-bold text-gray-800">Create Your Account</h2>
                        <p class="text-gray-500 text-sm">We can't wait to have you on board!</p>
                    </div>

                    <?php if ($message): ?>
                        <div id="message-box" class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
                            <?= htmlspecialchars($message) ?>
                        </div>
                    <?php endif; ?>

                    <form action="actions/register_action.php" method="post" class="space-y-5">
                        <div class="input-group">
                            <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="name" placeholder="Enter your full name"
                                    class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#3D8D7A]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="input-group">
                                <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email" name="email" placeholder="your@email.com"
                                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#3D8D7A]">
                                </div>
                            </div>

                            <div class="input-group">
                                <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="text" name="contact" placeholder="+1234567890"
                                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#3D8D7A]">
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <label class="block text-gray-700 font-medium mb-2">Gender</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-venus-mars text-gray-400"></i>
                                </div>
                                <select name="gender"
                                    class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#3D8D7A] appearance-none">
                                    <option value="">Select your gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                    <option value="prefer-not-to-say">Prefer not to say</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="input-group">
                                <label class="block text-gray-700 font-medium mb-2">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="password" placeholder="Create password"
                                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#3D8D7A]">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">At least 8 characters</p>
                            </div>

                            <div class="input-group">
                                <label class="block text-gray-700 font-medium mb-2">Confirm Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input type="password" name="confirm_password" placeholder="Confirm password"
                                        class="form-input w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:border-[#3D8D7A]">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" id="terms" name="terms"
                                class="rounded border-gray-300 text-[#3D8D7A] focus:ring-[#3D8D7A]">
                            <label for="terms" class="ml-2 text-sm text-gray-600">
                                I agree to the <a href="#" class="text-[#3D8D7A] hover:underline">Terms of Service</a> and <a
                                    href="#" class="text-[#3D8D7A] hover:underline">Privacy Policy</a>
                            </label>
                        </div>

                        <button type="submit" name="register"
                            class="btn-register w-full text-white py-3 rounded-lg font-medium mt-2">
                            Sign Up <i class="fas fa-arrow-right ml-2"></i>
                        </button>

                        <div class="text-center text-sm text-gray-600 mt-4">
                            Already part of our story? <a href="login.php"
                                class="text-[#3D8D7A] font-medium hover:underline">Sign in here</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
   
    <?php include_once "includes/footer2.php"; ?>
</body>

</html>