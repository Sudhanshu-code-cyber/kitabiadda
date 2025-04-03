<?php
    $connect = new mysqli("localhost","root", "","kitabiadda") or die("error connecting to database");

    session_start();

    // get user information
    function getUser(){
            global $connect;
            $email = $_SESSION['user'];
            $query = $connect->query("select * from users where email='$email'");
            $userData = $query->fetch_array();
            return $userData;
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
    echo "<script>alert('$mass')</script>";
}

function redirect($page){
    echo "<script>window.open('$page', '_self')</script>";
}


?>