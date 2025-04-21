<?php
include "../config/connect.php";
session_start();

if (!isset($_SESSION['user'])) {
    die("Unauthorized access");
}

// Get user ID
$user_id = $_SESSION['user']['id'];

// Get category info from session or POST
$cat_id = $_POST['cat_id'] ?? null;
$subcat_id = $_POST['subcat_id'] ?? null;

// Prepare the bookset insert
$bookset_stmt = $connect->prepare("INSERT INTO booksets 
    (user_id, cat_id, subcat_id, created_at) 
    VALUES (?, ?, ?, NOW())");
$bookset_stmt->bind_param("iii", $user_id, $cat_id, $subcat_id);
$bookset_stmt->execute();
$bookset_id = $connect->insert_id;

// Process each book
foreach ($_POST['books'] as $book_id => $book_data) {
    // Handle file upload
    $image_path = '';
    if (!empty($_FILES['books']['tmp_name'][$book_id]['image'])) {
        $upload_dir = "../uploads/books/";
        $file_name = uniqid() . '_' . basename($_FILES['books']['name'][$book_id]['image']);
        $target_file = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['books']['tmp_name'][$book_id]['image'], $target_file)) {
            $image_path = $file_name;
        }
    }

    // Insert book data
    $book_stmt = $connect->prepare("INSERT INTO books 
        (bookset_id, name, author, mrp, image_path, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())");
    $book_stmt->bind_param("issds", 
        $bookset_id,
        $book_data['name'],
        $book_data['author'],
        $book_data['mrp'],
        $image_path
    );
    $book_stmt->execute();
}

// Redirect to success page
header("Location: bookset_success.php?id=$bookset_id");
exit();
?>