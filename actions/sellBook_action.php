<?php
include_once "../config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$user_email = $user['email'];

if (isset($_POST['submit_book'])) {
    $book_name = mysqli_real_escape_string($connect,$_POST['book_name']);
    $book_author = mysqli_real_escape_string($connect,$_POST['book_author']);
    $mrp = $_POST['mrp'];
    $sell_price = $_POST['sell_price'];
    $pages = $_POST['pages'];
    $book_category = $_POST['book_category'];
    $book_sub_category = $_POST['book_sub_category'];
    $language = $_POST['language'];
    $isbn = $_POST['isbn'];
    $publish_year = $_POST['publish_year'];
    $current_year = date("Y");
    $quality = $_POST['quality'];
    $book_binding = $_POST['book_binding'];
    $book_description = mysqli_real_escape_string($connect,$_POST['book_description']);


    if (empty($book_name)) {
        message("book Name is required");
        exit();
    }

    if (empty($book_author)) {
        message("Enter Book Author name");
        exit();
    }


    if (empty($mrp) || !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $mrp) || $mrp <= 0) {
        message("Enter Book Price");
        exit();
    }


    if (empty($sell_price) || !preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $sell_price) || $sell_price <= 0 || $sell_price > $mrp) {
        message("Selling price must be valid and less than or equal to MRP.");
        exit();
    }


    if (empty($pages) || !preg_match("/^[0-9]+$/", $pages) || $pages <= 0) {
        message("Pages must be a valid positive number.");
        exit();
    }


    if (empty($language)) {
        message("Language is required.");
        exit();
    }


    if (empty($publish_year)) {
        message("Publish year must be between 1900 and $current_year.");
        exit();
    }

    if (empty($quality)) {
        message("Book Condition is required.");
        exit();
    }

    if (empty($book_binding)) {
        message("Book binding type is required.");
        exit();
    }

    if (empty($book_description) || strlen($book_description) < 10) {
        message("Description must be at least 10 characters long.");
        exit();
    }
    

    // Address Details
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $user_email;
    $pincode = $_POST['pincode'];
    $locality = $_POST['locality'];
    $address = mysqli_real_escape_string($connect,$_POST['address']);
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

    $uploaded_images = array_filter([$image1, $image2, $image3, $image4]);

    if (count($uploaded_images) < 2) {
        echo "<script>
        alert('Please upload at least 2 images of the book.');
        window.history.back();
    </script>";
        exit();
    }

    // ✅ Insert only if no errors
    $fetchAdd = $connect->query("select * from user_address where email='$email'");
    if ($fetchAdd->num_rows > 0) {
        $address_sql = "UPDATE user_address SET lattitude='$latitude', longitude='$longitude' where email='$email'";
    } else {
        $address_sql = "INSERT into  user_address (name,mobile,pincode,locality,address,landmark,user_id,email,lattitude,longitude , city, state)  values('$name','$contact','$pincode','$locality','$address','$landmark','$seller_id','$email','$latitude','$longitude','$city','$state')";
    }
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
    }
}
?>