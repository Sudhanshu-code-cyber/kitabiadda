<?php
    include_once "../config/connect.php";

    if (isset($_FILES["dp_image"]['name'])) {
        $dp = $_FILES['dp_image']['name'];
        $tmp_dp = $_FILES['dp_image']['tmp_name'];

        move_uploaded_file($tmp_dp, "../assets/user_dp/$dp");

        $user = getUser();
        $user_id = $user["user_id"];

        $quary = $connect->query("update users set dp='$dp' where user_id='$user_id'");
        if($quary){
            redirect("../profile.php");
        }
        else{
            message("something Went Wrong while inserting dp");
        }

    }
?>