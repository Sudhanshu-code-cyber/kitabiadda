<?php
    $connect = new mysqli("localhost","root", "","readrainbow") or die("error connecting to database");

// message 
function message($mass)
{
    echo "<script>alert('$mass')</script>";
}

function redirect($page){
    echo "<script>window.open('$page', '_self')</script>";
}


?>