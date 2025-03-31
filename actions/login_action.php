<?php
include_once "../config/connect.php";

if (isset($_POST["login"])) {
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $query = $connect->query("select * from users where email='$email' and password='$password'");
    $data = $query->fetch_array();
    $count = $query->num_rows;
    if ($count) {
        if ($data['isAdmin'] == 1) {
            $_SESSION['admin'] = $email;
            redirect("../admin/index.php");
        } else {
            if ($count > 0) {
                $_SESSION['user'] = $email;
                redirect('../index.php');
            } else {
                message("username or password is incorrect");
                redirect("../login.php");
            }
        }
    } else {
        message("username or password is incorrect");
        redirect("../login.php");
    }
}
?>