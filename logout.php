<?php
    include_once "config/connect.php";
    session_destroy();
    redirect("login.php");
?>