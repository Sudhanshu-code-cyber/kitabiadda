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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;

        }

        .login-container {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            overflow: hidden;
        }

        .input-field {
            background: rgba(255, 255, 255, 0.3);
            border: none;
            color: #2d3748;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            background: rgba(255, 255, 255, 0.4);
            box-shadow: 0 0 0 3px rgba(61, 141, 122, 0.3);
        }

        .login-btn {
            background: linear-gradient(135deg, #3D8D7A 0%, #2a6355 100%);
            transition: all 0.3s ease;
            color: white;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(61, 141, 122, 0.6);
        }

        .social-btn {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.3);
            color: #2d3748;
        }

        .social-btn:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.4);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .book-icon {
            filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.2));
        }

        .text-primary {
            color: #3D8D7A;
        }

        .bg-primary {
            background-color: #3D8D7A;
        }

        .bg-secondary {
            background-color: #A3D1C6;
        }

        .bg-accent {
            background-color: #B3D8A8;
        }
    </style>
</head>

<body class="">
    <div class="min-h-screen bg-[#FBFFE4] flex items-center justify-center p-4">
        <div class="login-container flex flex-col md:flex-row w-full max-w-6xl">
            <!-- Left Side - Illustration -->
            <div class="hidden md:flex flex-col items-center justify-center bg-primary text-white w-full md:w-1/2 p-8">
                <div class="animate-float mb-8">
                    <svg class="book-icon w-32 h-32" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h1 class="text-4xl font-bold mb-4 text-center">Welcome Back!</h1>
                <p class="text-center text-white text-opacity-90 max-w-md">
                    Dive back into your reading journey. Access your personalized bookshelf and continue where you left
                    off.
                </p>
                <div class="mt-8 flex space-x-4">
                    <div class="w-16 h-1 bg-white bg-opacity-50 rounded-full"></div>
                    <div class="w-16 h-1 bg-white rounded-full"></div>
                    <div class="w-16 h-1 bg-white bg-opacity-50 rounded-full"></div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-8 bg-secondary md:p-12 flex flex-col justify-center">
                <div class="text-center mb-8">
                    <img src="assets/logo5.png" alt="BookStore Logo" class="h-12 mx-auto mb-2">
                    <h2 class="text-2xl font-bold text-gray-800">Login to Your Account</h2>
                    <p class="text-gray-600 mt-2">Enter your details to continue</p>
                </div>

                <form action="#" method="post" class="space-y-6" onsubmit="return false">
                    <!-- Email Input -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 text-sm font-medium">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-500"></i>
                            </div>
                            <input type="email" name="email" id="email" placeholder="your@email.com"
                                class="bg-white w-full pl-10 pr-4 py-3 rounded-lg border focus:outline-none" required>
                        </div>
                    </div>

                    <!-- Send OTP Button -->
                    <button type="button" onclick="sendOtp()" id="sendOtpBtn"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                        Send OTP
                    </button>

                    <!-- OTP Section (Initially Hidden) -->
                    <div id="otpSection" class="space-y-4 hidden">
                        <div class="flex justify-between items-center">
                            <label class="block text-gray-700 text-sm font-medium">Enter OTP</label>
                            <span id="timer" class="text-sm text-green-600 font-semibold">05:00</span>
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-key text-gray-500"></i>
                            </div>
                            <input type="text" name="otp" id="otp" maxlength="6" placeholder="Enter 6-digit OTP"
                                class="bg-white w-full pl-10 pr-4 py-3 rounded-lg border focus:outline-none">
                        </div>

                        <!-- Verify OTP Button -->
                        <button type="submit"
                            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-medium">
                            Verify OTP
                        </button>
                    </div>
                </form>

                <!-- Scripts -->
                <script>
                    let timerInterval;
                    function sendOtp() {
                        document.getElementById('otpSection').classList.remove('hidden');
                        document.getElementById('sendOtpBtn').disabled = true;
                        startTimer(5 * 60); // 5 minutes
                    }

                    function startTimer(duration) {
                        let timer = duration, minutes, seconds;
                        timerInterval = setInterval(() => {
                            minutes = Math.floor(timer / 60);
                            seconds = timer % 60;
                            minutes = minutes < 10 ? "0" + minutes : minutes;
                            seconds = seconds < 10 ? "0" + seconds : seconds;
                            document.getElementById('timer').textContent = `${minutes}:${seconds}`;
                            if (--timer < 0) {
                                clearInterval(timerInterval);
                                document.getElementById('timer').textContent = "Expired";
                            }
                        }, 1000);
                    }
                </script>

            </div>
        </div>
        <div class="fixed top-20 left-10 w-16 h-16 rounded-full bg-primary opacity-20 blur-xl -z-10"></div>
        <div class="fixed bottom-20 right-10 w-24 h-24 rounded-full bg-secondary opacity-20 blur-xl -z-10"></div>
        <div class="fixed top-1/3 right-20 w-12 h-12 rounded-full bg-accent opacity-20 blur-xl -z-10"></div>
    </div>
    <!-- Floating decorative elements -->
    <?php include_once "includes/footer2.php"; ?>

</body>

</html>