<?php
include_once "../config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$user_email = $user['email'];
if (isset($_POST['submit_book'])) {
    $errors = [];

    // Get and validate input
    $book_name = mysqli_real_escape_string($connect, $_POST['book_name']);
    if (empty($book_name) || !preg_match("/^[a-zA-Z0-9\s]{2,}$/", $book_name)) {
        $errors[] = "Book name is required and must be at least 2 characters (letters/numbers only).";
    }

    $book_author = mysqli_real_escape_string($connect, $_POST['book_author']);
    if (empty($book_author) || !preg_match("/^[a-zA-Z\s]{3,}$/", $book_author)) {
        $errors[] = "Author name is required and must be at least 3 characters (letters only).";
    }

    $mrp = $_POST['mrp'];
    if (empty($mrp) || !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $mrp) || $mrp <= 0) {
        $errors[] = "MRP must be a valid positive number.";
    }

    $sell_price = $_POST['sell_price'];
    if (empty($sell_price) || !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $sell_price) || $sell_price <= 0 || $sell_price > $mrp) {
        $errors[] = "Selling price must be valid and less than or equal to MRP.";
    }

    $pages = $_POST['pages'];
    if (empty($pages) || !preg_match("/^[0-9]+$/", $pages) || $pages <= 0) {
        $errors[] = "Pages must be a valid positive number.";
    }

    $book_category = mysqli_real_escape_string($connect, $_POST['book_category']);
    if (empty($book_category)) {
        $errors[] = "Book category is required.";
    }

    $book_sub_category = mysqli_real_escape_string($connect, $_POST['book_sub_category']);
    if (empty($book_sub_category)) {
        $errors[] = "Book sub-category is required.";
    }

    $language = mysqli_real_escape_string($connect, $_POST['language']);
    if (empty($language)) {
        $errors[] = "Language is required.";
    }

    $isbn = $_POST['isbn'];
    if (!preg_match("/^[0-9]{10}([0-9]{3})?$/", $isbn)) {
        $errors[] = "ISBN must be a 10 or 13 digit number.";
    }

    $publish_year = $_POST['publish_year'];
    $current_year = date("Y");
    if (empty($publish_year) || !preg_match("/^[0-9]{4}$/", $publish_year) || $publish_year < 1900 || $publish_year > $current_year) {
        $errors[] = "Publish year must be between 1900 and $current_year.";
    }

    $quality = mysqli_real_escape_string($connect, $_POST['quality']);
    if (empty($quality)) {
        $errors[] = "Book quality is required.";
    }

    $book_binding = mysqli_real_escape_string($connect, $_POST['book_binding']);
    if (empty($book_binding)) {
        $errors[] = "Book binding type is required.";
    }

    $book_description = mysqli_real_escape_string($connect, $_POST['book_description']);
    if (empty($book_description) || strlen($book_description) < 10) {
        $errors[] = "Description must be at least 10 characters long.";
    }

    // Address Details
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $user_email;
    $pincode = $_POST['pincode'];
    $locality = $_POST['locality'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $landmark = $_POST['landmark'];
    $seller_id = $user['user_id']; 
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    

    // File Upload
    $target_dir = "../assets/images/";
    $image1 = $image2 = $image3 = $image4 = "";

    function uploadImage($fileInput, $target_dir)
    {
        if (!empty($_FILES[$fileInput]["name"])) {
            $unique_name = time() . "_" . uniqid() . "_" . basename($_FILES[$fileInput]["name"]);
            move_uploaded_file($_FILES[$fileInput]["tmp_name"], $target_dir . $unique_name);
            return $unique_name;
        }
        return "";
    }

    $image1 = uploadImage("image0", $target_dir);
    $image2 = uploadImage("image1", $target_dir);
    $image3 = uploadImage("image2", $target_dir);
    $image4 = uploadImage("image3", $target_dir);

    // ✅ Insert only if no errors
    if (empty($errors)) {
        $address_sql = "INSERT into user_address (name,mobile,pincode,locality,address,landmark,email, lattitude, longitude, city, state ) values('$name','$contact','$pincode','$locality','$address','$landmark','$email','$latitude','$longitude','$city','$state')";
        if (mysqli_query($connect, $address_sql)) {
            $sql = "INSERT INTO books 
            (book_name, book_author, mrp, sell_price, book_pages, book_category, book_sub_category, language, isbn, publish_year, quality, book_binding, book_description, img1, img2, img3, img4, seller_id, version) 
            VALUES 
            ('$book_name', '$book_author', '$mrp', '$sell_price', '$pages', '$book_category', '$book_sub_category', '$language', '$isbn', '$publish_year', '$quality', '$book_binding', '$book_description', '$image1', '$image2', '$image3', '$image4', '$seller_id','old')";


            if (mysqli_query($connect, $sql)) {
                echo "<script>alert('Book Ad Posted Successfully!'); window.location.href='../index.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<p style='color:red;'>❌ $error</p>";
            }
        }
    }

    mysqli_close($connect);
}
?>

