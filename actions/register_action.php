<?php
    include_once "../config/connect.php";

    if (isset($_POST["register"])) {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
        $gender = $_POST["gender"];
        $password = $_POST["password"];
        if(!preg_match("/^[a-zA-Z]+(?:[\s-][a-zA-Z]+)*$/",$name)){
            message("Incorrect name");
            redirect("../register.php");
            exit();
        }
        if(!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/",$email)){
            message("Invalid email");
            redirect("../register.php");
            exit();
        }
        if(!preg_match("/^[6-9]\d{9}$/",$contact)){
            message("Invalid Contact");
            redirect("../register.php");
            exit();
        }
        if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/",$password)){
            message("Invalid password");
            redirect("../register.php");
            exit();
        }
        $password = md5($password);

        // checkEmail if this email already exist
            $checkEmail = $connect->query("select email from users where email='$email'");
            if($checkEmail->num_rows > 0){
                message("User already Registered");
                redirect("../login.php");
                exit();
            }
        $query = $connect->query("insert into users (name, email, contact,gender, password) values('$name','$email','$contact','$gender','$password')");

        if($query){
            redirect("../login.php");
        }
        else{
            message("Something Went Wrong");
        }
    }
?>