<?php
    $connect = new mysqli("localhost","root", "","readrainbow") or die("error connecting to database");

    session_start();

    // get user information
    function getUser(){
            global $connect;
            $email = $_SESSION['user'];
            $query = $connect->query("select * from users where email='$email'");
            $userData = $query->fetch_array();
            return $userData;
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