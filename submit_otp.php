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
        $subject = "Your Otp - KitabiAdda";
        $message = "
            <html>
            <head>
                <title>KitabiAdda otp :</title>
            </head>
            <body>
                <p>Dear user,</p>
                <p>Your KitabiAdda otp is : <strong>$otp</strong></p>
                <br>
                <p>Regards,<br>KitabiAdda Team</p>
            </body>
            </html>
        ";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: KitabiAdda <Ankurchatgram@invikta.in>\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "";
        } else {
            echo "❌ Email failed to send.";
        }

    } else {
        echo "❌ Email not found in our records.";
    }
}
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
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-5">Enter otp</h2>

        <!-- Login Form -->
        <form action="" method="POST" class="space-y-4">

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Otp</label>
                <input type="number" name="otp"
                    class="w-full p-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Enter yur email" required>
                    
                
                    
                    
                    
                    <input type="hidden" name="otp_verify" value="<?php echo $otp ?>">

                    
            </div>

            

            <!-- Login Button -->
            <button type="submit" name="verify"
                class="w-full bg-blue-500 text-white p-3 rounded-md font-bold text-lg hover:bg-blue-600 transition duration-300">Submit otp</button>

            <!-- Forgot Password & Signup -->
            <div class="flex justify-between text-sm text-gray-600 mt-3">
                <a href="login.php" class="hover:underline">Login </a>
                <a href="signup.php" class="text-blue-500 hover:underline">Create Account</a>
            </div>
        </form>
        <?php
        if(isset($_POST['verify'])){
            
            $otp = $_POST['otp_verify'];
            $verify_otp = $_POST['otp'];
            if($otp == $verify_otp){
                echo "successful";
            }
        }
        
        
        ?>
        
        

    </div>

</body>

</html>