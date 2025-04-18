<?php include_once "config/connect.php"; ?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    $otp = $_POST['otp'];

    $call_user = mysqli_query($connect, "SELECT * FROM users WHERE email='$email'");
    if (!$call_user) {
        die("Query failed: " . mysqli_error($connect));
    }

    $user = mysqli_fetch_assoc($call_user);

    if ($user) {
        $to = $email;
        $subject = "Reset Password OTP - KitabiAdda";

        // HTML Email Template
        $message = "
            <html>
            <head>
                <title>Reset Password OTP</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }
                    .container {
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0,0,0,0.1);
                        max-width: 600px;
                        margin: auto;
                    }
                    .otp {
                        font-size: 20px;
                        font-weight: bold;
                        color: #2c3e50;
                    }
                    .footer {
                        margin-top: 20px;
                        font-size: 12px;
                        color: #888;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Hello,</h2>
                    <p>You have requested to reset your password on <strong>KitabiAdda</strong>.</p>
                    <p>Your One Time Password (OTP) is:</p>
                    <p class='otp'>$otp</p>
                    <p>Please use this OTP within the next 5 minutes to proceed.</p>
                    <br>
                    <p>Regards,<br><strong>KitabiAdda Team</strong></p>
                    <div class='footer'>
                        <p>If you didn't request this, please ignore this email.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        // Headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: KitabiAdda <no-reply@kitabiadda.in>\r\n";
        $headers .= "Reply-To: support@kitabiadda.com\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();

        // Send Mail
        if (mail($to, $subject, $message, $headers)) {
            echo "";
        } else {
            echo "❌ Failed to send OTP. Please try again later.";
        }
    } else {
        echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Email not Registered!',
                        text: 'This email address is not registered with KitabiAdda.',
                        confirmButtonText: 'Try Another Email',
                        confirmButtonColor: '#d33',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        backdrop: true
                    }).then(function() {
                        window.location.replace('forgetPassword.php');
                    });
            
                    // Extra fallback: force redirect after 5 seconds
                    setTimeout(function() {
                        window.location.replace('forgetPassword.php');
                    }, 5000);
                });
            </script>
            ";
    }

}
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
                <h1 class="text-4xl font-bold mb-4 text-center">Welcome Back! </h1>
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
                    <h2 class="text-2xl font-bold text-gray-800">Enter Your OTP</h2>
                    <!-- <p class="text-gray-600 mt-2">Enter your Email to continue</p> -->
                </div>

                <!-- OTP Sent Message + Timer -->
<div class="mb-4 text-center">
    <p class="text-green-600 font-semibold text-lg">OTP is sent</p>
    <p class="text-gray-700">This OTP will expire in <span id="timer" class="font-bold">05:00</span></p>
</div>

<!-- Your Form -->
<form action="" method="POST" class="space-y-6" onsubmit="return validateOtpMatch()">
    <!-- Email Input -->
    <div class="space-y-4">
        <label class="block text-gray-700 text-sm font-medium">Enter OTP</label>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-key text-gray-500"></i>
            </div>
            <input type="number" id="inputOtp" name="otp" maxlength="6" placeholder="Enter 6-digit OTP"
                class="bg-white w-full pl-10 pr-4 py-3 rounded-lg border focus:outline-none" required>

            <!-- Hidden OTP values -->
            <input type="hidden" id="correctOtp" name="otp_verify" value="<?php echo $otp ?>">
            <input type="hidden" name="otpEmail" value="<?= $email ?>">
        </div>

        <!-- Verify OTP -->
        <button type="submit" name="verify"
            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-medium">
            Verify OTP
        </button>
    </div>
</form>

<!-- Timer Script -->
<script>
    let timeLeft = 5 * 60; // 5 minutes in seconds
    const timerElement = document.getElementById('timer');

    const countdown = setInterval(() => {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;

        // Pad with zero if needed
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        timerElement.textContent = `${minutes}:${seconds}`;
        timeLeft--;

        if (timeLeft < 0) {
            clearInterval(countdown);
            alert('OTP has expired. Please request a new one.');
            // Optional: Disable the form or redirect
            // document.querySelector('form').reset(); // Reset form
            // window.location.href = "resendOtp.php"; // Or redirect to resend page
        }
    }, 1000);
</script>


                <!-- 🔐 JS for OTP match -->
                <script>
                    function validateOtpMatch() {
                        const inputOtp = document.getElementById("inputOtp").value.trim();
                        const correctOtp = document.getElementById("correctOtp").value.trim();

                        if (inputOtp !== correctOtp) {
                            // SweetAlert2 for user-friendly alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid OTP',
                                text: 'The OTP you entered is incorrect. Please try again.',
                                confirmButtonColor: '#d33',
                            });
                            return false; // ❌ prevent form submission
                        }

                        return true; // ✅ OTP matched, allow form submission
                    }
                </script>

                <!-- SweetAlert2 CDN (add once on your page if not already added) -->
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            </div>
        </div>
        <div class="fixed top-20 left-10 w-16 h-16 rounded-full bg-primary opacity-20 blur-xl -z-10"></div>
        <div class="fixed bottom-20 right-10 w-24 h-24 rounded-full bg-secondary opacity-20 blur-xl -z-10"></div>
        <div class="fixed top-1/3 right-20 w-12 h-12 rounded-full bg-accent opacity-20 blur-xl -z-10"></div>
    </div>
    <!-- Floating decorative elements -->
    <?php include_once "includes/footer2.php"; ?>
    <?php
    if (isset($_POST['verify'])) {

        $otp = $_POST['otp_verify'];
        $otpEmail = $_POST['otpEmail'];
        $verify_otp = $_POST['otp'];
        if ($otp == $verify_otp) {
            $email = $_POST["email"];
            // $password = md5($_POST["password"]);
    
            $query = $connect->query("select * from users where email='$otpEmail' ");
            $data = $query->fetch_array();
            $count = $query->num_rows;
            if ($count) {
                if ($data['isAdmin'] == 1) {
                    $_SESSION['admin'] = $otpEmail;
                    redirect("admin/index.php");
                } else {
                    if ($count > 0) {
                        $_SESSION['user'] = $otpEmail;
                        redirect('index.php');
                    } else {
                        message("username or password is incorrect");
                        redirect("login.php");
                    }
                }
            } else {
                message("username or password is incorrect");
                redirect("../login.php");
            }

        }
    }


    ?>

</body>

</html>