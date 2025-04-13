<?php
    $connect = new mysqli("localhost","root", "","kitabiadda") or die("error connecting to database");


    // project configration
    define("PROJECT_NAME", "KitabiAdda");

    session_start();

    // get user information
    function getUser(){
            global $connect;
            $email = $_SESSION['user'];
            $query = $connect->query("select * from users where email='$email'");
            $userData = $query->fetch_array();
            return $userData;
    }

     // get user information
     function getAdminDetails(){
        global $connect;
        $email = $_SESSION['admin'];
        $query = $connect->query("select * from users where email='$email' and isAdmin=1");
        $adminData = $query->fetch_array();
        return $adminData;
}

    // redirect If Not Authentication Function
    function redirectIfNotAuth(){
        if(!isset($_SESSION["user"])){
            redirect("login.php");
        }
    }

// message 
function message($mass)
{
    echo "<script>
        alert('$mass');
        window.history.back();
    </script>";
}

function redirect($page){
    echo "<script>window.open('$page', '_self')</script>";
}


function getPostedTime($post_date) {
    if (empty($post_date)) {
        return 'Recently';
    }
    
    // If it's already a timestamp (numeric)
    if (is_numeric($post_date)) {
        $timestamp = $post_date;
    } 
    // If it's a MySQL datetime string
    else {
        $timestamp = strtotime($post_date);
    }
    
    // Fallback if conversion fails
    if (!$timestamp) {
        return 'Recently';
    }
    
    $diff = time() - $timestamp;
    
    if ($diff < 60) return 'Just now';
    if ($diff < 3600) return floor($diff/60) . ' min ago';
    if ($diff < 86400) return floor($diff/3600) . ' hours ago';
    if ($diff < 604800) {
        $days = floor($diff/86400);
        return $days == 1 ? 'Yesterday' : $days . ' days ago';
    }
    if ($diff < 2592000) {
        $weeks = floor($diff/604800);
        return $weeks == 1 ? '1 week ago' : $weeks . ' weeks ago';
    }
    
    $months = floor($diff/2592000);
    return $months == 1 ? '1 month ago' : $months . ' months ago';
}

?>