<?php
include_once "../config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$user_email = $user['email'];
// fetch address details
$callAdd = $connect->query("select * from user_address where email='$user_email'");
$add = $callAdd->fetch_array();

if (isset($_POST['submit_book'])) {
    $book_name = mysqli_real_escape_string($connect, $_POST['book_name']);
    $book_author = mysqli_real_escape_string($connect, $_POST['book_author']);
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
    $contact = $_POST['contact'];
    $book_description = mysqli_real_escape_string($connect, $_POST['book_description']);

    // Address Details
    $name = $_POST['name'];
    $email = $user_email;
    $pincode = $_POST['pincode'];
    $locality = $_POST['locality'];
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $city = $_POST['city'];
    $state = $_POST['state'];
    $landmark = $_POST['landmark'];
    $seller_id = $user['user_id'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];


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
        message("Enter total pages of book");
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

    if (empty($contact) || !preg_match("/^[6-9]\d{9}$/", $contact)) {
        message("Contact must be a valid 10 digit mobile number");
        exit();
    }

    if ($callAdd->num_rows == 0) {
        if (empty($landmark)) {
            message("please Add Full Address to continue");
            exit();
        }

        if (empty($locality)) {
            message("please Add Full Address to continue");
            exit();
        }

        if (empty($city)) {
            message("please Add Full Address to continue");
            exit();
        }
        if (empty($state)) {
            message("please Add Full Address to continue");
            exit();
        }
        if (empty($pincode)) {
            message("please Add Full Address to continue");
            exit();
        }
    }
    if (empty($book_description) || strlen($book_description) < 10) {
        message("Description must be at least 10 characters long.");
        exit();
    }
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
            
            $to = $user_email;
            $subject = "Product Sale Details - KitabiAdda";

            // HTML Email Template
            $message = "
        <html>
        <head>
            <title>Product Sale Details</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    padding: 20px;
                }
                .container {
                    background-color: #ffffff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0,0,0,0.1);
                    max-width: 600px;
                    margin: auto;
                }
                .product-details {
                    border-top: 2px solid #ccc;
                    margin-top: 20px;
                    padding-top: 20px;
                }
                .product-image {
                    max-width: 100%;
                    height: auto;
                    border-radius: 8px;
                    margin-top: 20px;
                }
                .product-name {
                    font-size: 24px;
                    font-weight: bold;
                    color: #2c3e50;
                    margin-top: 10px;
                }
                .product-price {
                    font-size: 20px;
                    color: #27ae60;
                    margin-top: 5px;
                }
                .product-description {
                    font-size: 16px;
                    margin-top: 10px;
                    color: #7f8c8d;
                }
                .footer {
                    margin-top: 20px;
                    font-size: 12px;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Hello,</h2>
                <p>Thank you for listing your product on <strong>KitabiAdda</strong>.</p>
                <p>Here are the details of the product you recently sold:</p>

                <div class='product-details'>
                    <img src='https://kitabiadda.com/assets/images/$image1' alt='Product Image' class='product-image'>
                    <p class='product-name'>Product Name: $book_name</p>
                    <p class='product-price'>Price: ₹$sell_price</p>
                    <p class='product-description'>
                        Description: $book_description.
                    </p>
                </div>

                <br>
                <p>Thank you for using <strong>KitabiAdda</strong> to sell your product. We wish you more successful sales!</p>
                <br>
                <p>Regards,<br><strong>KitabiAdda Team</strong></p>

                <div class='footer'>
                    <p>If you didn't list this product, please contact support immediately.</p>
                </div>
            </div>
        </body>
        </html>
    ";

            // Headers
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= "From: KitabiAdda <no-reply@kitabiadda.in>\r\n";
            $headers .= "Reply-To: support@kitabiadda.com\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Send Mail
            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('Book Ad Posted Successfully!'); window.location.href='../index.php';</script>";
            } else {
                echo "❌ Failed to send product details. Please try again later.";
            }
        } else {
            echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";



        }
    }
}
?>