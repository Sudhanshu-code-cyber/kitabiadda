<?php include_once "config/connect.php"; ?>
<?php
require 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('642231406648-2do70qjtogm5q4tq82r7t2s14qc0jtgj.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://kitabiadda.com/');
$client->addScope(['email', 'profile']);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Fetch User Data from Google
    $oauth = new Google_Service_Oauth2($client);
    $user = $oauth->userinfo->get();

    $google_id = $user->id; 
    $name = $user->name;
    $email = $user->email; 
    $picture = $user->picture; 

    
    $query = $connect->prepare("SELECT * FROM users WHERE google_id = ?");
    $query->bind_param("s", $google_id);
    $query->execute();
    $result = $query->get_result();
    $count = $result->num_rows;

    if ($count == 0) {
       
        $insert = $connect->prepare("INSERT INTO users (google_id, name, email, dp) VALUES (?, ?, ?, ?)");
        $insert->bind_param("ssss", $google_id, $name, $email, $picture);
        if ($insert->execute()) {
            // $_SESSION['user'] = $email;
            echo "User successfully added to database!";
        } else {
            die("Database Insert Error: " . $insert->error);
        }
    } 

    $user_call = mysqli_query($connect, "SELECT * FROM users WHERE email='$email' AND google_id='$google_id'");
    $numema = mysqli_num_rows($user_call);
    $emails = mysqli_fetch_assoc($user_call);
    if ($numema == 1) {
        $_SESSION['user'] = $email;
        redirect('index.php');
    }

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=PROJECT_NAME;?></title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <style>
        /* Hide scrollbar for Webkit browsers (Chrome, Safari, Edge) */
        #bookScroll::-webkit-scrollbar,
        #bookScroll2::-webkit-scrollbar,
        #bookScroll3::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for Firefox */
        #bookScroll,
        #bookScroll2,
        #bookScroll3 {
            scrollbar-width: none;
        }

        /* Container styling for smooth scrolling */
        #bookScroll,
        #bookScroll2,
        #bookScroll3 {
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }

        /* Floating Button Styles */
        .floating-sell-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 50;
            transition: all 0.3s ease;
            min-width: show;
            
        }

        .floating-sell-btn button {
            background-color: #3D8D7A;
            color: white;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 9999px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .floating-sell-btn button:hover {
            background-color: #2c6a5a;
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }

        .floating-sell-btn button svg {
            margin-right: 8px;
            height: 24px;
            width: 24px;
        }

        /* Button scroll effects */
        .btn-scroll-down {
            opacity: 0.7;
            transform: translateY(8px);
        }
    </style>
</head>

<body class="bg-gray-50 ">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <!-- First Carousel -->
    <div id="default-carousel" class="relative mt-22 w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative z-5 xl:h-[400px] h-[160px] mt-28 sm:h-[200px] md:h-[200px] lg:h-[300px] overflow-hidden">
            <!-- Carousel Items -->
            <a href="">
                <div class="hidden duration-700 ease-in-out" data-carousel-item>
                    <img src="assets/banner/2.png"
                        class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-fit md:object-fit md:h-full lg-fit"
                        alt="Slide 1">
                </div>
            </a>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/banner/Etsy Banner.png"
                    class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-cover md:h-full"
                    alt="Slide 2">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/banner/shop.png"
                    class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-cover md:h-full"
                    alt="Slide 3">
            </div>
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img src="assets/banner/crs4.png"
                    class="absolute block w-full h-full object-fit xl:object-fit xl-contain sm:object-cover md:h-full"
                    alt="Slide 4">
            </div>
        </div>

        <!-- Slider indicators -->
        <div class="absolute bottom-5 left-1/2 flex -translate-x-1/2 space-x-2">
            <button class="w-3 h-3 rounded-full bg-white" aria-label="Slide 1" data-carousel-slide-to="0"></button>
            <button class="w-3 h-3 rounded-full bg-gray-400" aria-label="Slide 2" data-carousel-slide-to="1"></button>
            <button class="w-3 h-3 rounded-full bg-gray-400" aria-label="Slide 3" data-carousel-slide-to="2"></button>
            <button class="w-3 h-3 rounded-full bg-gray-400" aria-label="Slide 4" data-carousel-slide-to="3"></button>
        </div>

        <!-- Slider controls -->
        <button type="button" class="absolute top-1/2 left-0 z-10 p-2 bg-white/50 rounded-full" data-carousel-prev>
            <span>&#10094;</span>
        </button>
        <button type="button" class="absolute top-1/2 right-0 z-10 p-2 bg-white/50 rounded-full" data-carousel-next>
            <span>&#10095;</span>
        </button>
    </div>

    <!-- Book Sets Section for New Books -->
    <?php include_once "includes/newRelease.php"; ?>

    <!-- Book Sets Section for Old Books (Second Carousel) -->
    <?php include_once "includes/oldBook.php"; ?>

    <!-- Book Sets Section for Old Books (Third Carousel) -->
    <?php include_once "includes/e-Book.php"; ?>
    <?php //include_once "includes/booksetBook.php"; ?>

    <!-- Floating Sell Button -->
    <a href="sell/sell.php" class="floating-sell-btn flex w-full justify-center items-center xl:hidden md:hidden  ">
        <button id="sellButton" >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Sell Used Book
        </button>
    </a>

    <?php include_once "includes/footer2.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    
    <script>
        // Sell Button Functionality
        document.getElementById('sellButton').addEventListener('click', function() {
            <?php if(isset($_SESSION['user'])): ?>
                window.location.href = 'sell_book.php';
            <?php else: ?>
                window.location.href = 'login.php?redirect=sell_book.php';
            <?php endif; ?>
        });

        // Scroll Behavior for Button
        let lastScrollPosition = 0;
        const sellButton = document.getElementById('sellButton');

        window.addEventListener('scroll', function() {
            const currentScrollPosition = window.pageYOffset;
            
            if (currentScrollPosition > lastScrollPosition) {
                // Scrolling down
                sellButton.parentElement.classList.add('btn-scroll-down');
            } else {
                // Scrolling up
                sellButton.parentElement.classList.remove('btn-scroll-down');
            }
            
            lastScrollPosition = currentScrollPosition;
        });
    </script>
</body>
</html>