<?php
include_once "../config/connect.php";

// Ensure the user is logged in
if(isset($_SESSION['user'])){
    $user = getUser();
}

$userId = $user['user_id']; // Get logged-in user ID


if (isset($_POST['toggle_wishlist'])) {
    $bookId = $_POST['wishlist_id'];

    // Check if the book is already in the wishlist
    $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
    $book = $check->fetch_array();

    if ($check->num_rows > 0) {
        // Remove from wishlist
        $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
    } else {
        // Add to wishlist
        $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
    }
    
}

// Redirect back to the same page
redirect("../index.php");
?>

