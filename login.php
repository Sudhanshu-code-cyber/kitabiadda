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
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        }
        
        .login-container {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            overflow: hidden;
        }
        
        .input-field {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
        }
        
        .login-btn {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            transition: all 0.3s ease;
        }
        
        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(99, 102, 241, 0.6);
        }
        
        .social-btn {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
        }
        
        .social-btn:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
        
        .book-icon {
            filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.3));
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="login-container flex flex-col md:flex-row w-full max-w-6xl">
        <!-- Left Side - Illustration -->
        <div class="hidden md:flex flex-col items-center justify-center bg-gradient-to-br from-indigo-600 to-purple-600 p-12 text-white w-full md:w-1/2">
            <div class="animate-float mb-8">
                <svg class="book-icon w-32 h-32" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h1 class="text-4xl font-bold mb-4 text-center">Welcome Back!</h1>
            <p class="text-center text-indigo-100 max-w-md">
                Dive back into your reading journey. Access your personalized bookshelf and continue where you left off.
            </p>
            <div class="mt-8 flex space-x-4">
                <div class="w-16 h-1 bg-white bg-opacity-50 rounded-full"></div>
                <div class="w-16 h-1 bg-white rounded-full"></div>
                <div class="w-16 h-1 bg-white bg-opacity-50 rounded-full"></div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center">
            <div class="text-center mb-8">
                <img src="assets/logo5.png" alt="BookStore Logo" class="h-12 mx-auto mb-2">
                <h2 class="text-2xl font-bold text-white">Login to Your Account</h2>
                <p class="text-gray-300 mt-2">Enter your details to continue</p>
            </div>

            <form action="actions/login_action.php" method="post" class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" placeholder="your@email.com" 
                            class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-gray-300 text-sm font-medium">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" placeholder="••••••••" 
                            class="input-field w-full pl-10 pr-4 py-3 rounded-lg focus:outline-none">
                    </div>
                    <div class="flex justify-end">
                        <a href="#" class="text-sm text-indigo-400 hover:underline">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" name="login" 
                    class="login-btn w-full text-white py-3 rounded-lg font-medium">
                    Sign In
                </button>

                <div class="relative flex items-center justify-center my-6">
                    <div class="absolute inset-0 border-t border-gray-700"></div>
                    <div class="relative px-4 bg-transparent text-gray-400 text-sm">or continue with</div>
                </div>

                <?php
                require 'vendor/autoload.php';

                $client = new Google_Client();
                $client->setClientId('642231406648-2do70qjtogm5q4tq82r7t2s14qc0jtgj.apps.googleusercontent.com');
                $client->setClientSecret('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');
                $client->setRedirectUri('http://kitabiadda.com/');
                $client->addScope(['email', 'profile']);

                $login_url = $client->createAuthUrl();
                ?>

                <a href="<?= $login_url ?>" 
                    class="social-btn flex items-center justify-center w-full px-4 py-3 rounded-lg text-white">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 48 48">
                        <path fill="#4285F4" d="M24 9.5c3.19 0 6.07 1.1 8.38 2.93l6.23-6.23C34.92 2.29 29.74 0 24 0 14.68 0 6.72 5.38 2.61 13.24l7.24 5.63C12.21 13.17 17.63 9.5 24 9.5z"/>
                        <path fill="#34A853" d="M46.38 24.5c0-1.5-.14-2.97-.4-4.38H24v8.31h12.69c-.5 2.5-1.92 4.63-3.94 6.16l6.22 6.22c4.06-3.75 6.41-9.3 6.41-15.81z"/>
                        <path fill="#FBBC05" d="M10.78 28.11c-.68-2.03-1.06-4.19-1.06-6.39s.38-4.36 1.06-6.39L3.54 9.36A23.996 23.996 0 000 21.72c0 3.78.9 7.34 2.54 10.51l8.24-4.12z"/>
                        <path fill="#EA4335" d="M24 48c6.49 0 11.93-2.14 15.92-5.79l-6.22-6.22c-2.19 1.47-4.92 2.31-7.7 2.31-6.37 0-11.79-3.67-14.14-8.87l-8.24 4.12C6.72 42.62 14.68 48 24 48z"/>
                    </svg>
                    <span>Sign in with Google</span>
                </a>

                <div class="text-center text-gray-400 mt-6">
                    Don't have an account? 
                    <a href="register.php" class="text-indigo-400 font-medium hover:underline">Sign up</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Floating decorative elements -->
    <div class="fixed top-20 left-10 w-16 h-16 rounded-full bg-purple-600 opacity-10 blur-xl -z-10"></div>
    <div class="fixed bottom-20 right-10 w-24 h-24 rounded-full bg-indigo-600 opacity-10 blur-xl -z-10"></div>
    <div class="fixed top-1/3 right-20 w-12 h-12 rounded-full bg-blue-500 opacity-10 blur-xl -z-10"></div>
</body>

</html>