<?php
    include_once "../config/connect.php";

    if (isset($_POST["login"])) {
        $email = $_POST["email"];
        $password = md5($_POST["password"]);

        $query = $connect->query("select * from users where email='$email' and password='$password'");

        if($query){
            redirect("../index.php");
        }
        else{
            message("Something Went Wrong");
        }
    }
?>