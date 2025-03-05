<?php
    include_once "../config/connect.php";

    if (isset($_POST["register"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
        $gender = $_POST["gender"];
        $password = md5($_POST["password"]);

        $query = $connect->query("insert into users (name, email, contact,gender, password) values('$name','$email','$contact','$gender','$password')");

        if($query){
            redirect("../login.php");
        }
        else{
            message("Something Went Wrong");
        }
    }
?>