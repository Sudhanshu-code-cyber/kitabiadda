<?php
    if(!isset($_SESSION['user'])){
        redirect("../login.php");
    }
?>