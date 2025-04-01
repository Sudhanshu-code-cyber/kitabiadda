<?php
include "../config/connect.php";

if (!isset($_SESSION['user'])) {
    $previousPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '🔒 Access Denied!',
                text: 'Please login first to continue.',
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Login Now',
                denyButtonText: 'Go Back',
                allowOutsideClick: false, // बाहर क्लिक करने से बंद न हो
                allowEscapeKey: false, // ESC दबाने से बंद न हो
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../login.php'; // Login Page पर जाएं
                } else if (result.isDenied) {
                    window.location.href = '$previousPage'; // पिछली पेज पर जाएं
                }
            });

            // ⏳ 5 सेकंड बाद Auto Redirect पिछले पेज पर
            setTimeout(() => {
                window.location.href = '$previousPage';
            }, 5000);
        });
    </script>";

    exit();
}

if (isset($_SESSION['user'])) {
    $user = getUser();
}
$user_email = $user['email'];
$address_query = mysqli_query($connect, "SELECT * FROM user_address WHERE email = '$user_email'");
$address_row = mysqli_fetch_assoc($address_query);
$user_address = $address_row['address'] ?? '';
if ($_GET['subcat']) {
    $id_subcat = $_GET['subcat'];
    $call_cat = mysqli_query($connect, "SELECT * FROM sub_category  WHERE id='$id_subcat'");
    $cat_name = mysqli_fetch_array($call_cat);

}
$cat_id = $cat_name['cat_id'];
$call_cat = mysqli_query($connect, "SELECT * FROM category where id='$cat_id'");
$cat = mysqli_fetch_assoc($call_cat);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Your Ad - Sell Your Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
        :root {
            --primary: #3D8D7A;
            --secondary: #B3D8A8;
            --accent: #FBFFE4;
            --light: #A3D1C6;
        }

        .floating-label {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: white;
            padding: 0 5px;
            transition: all 0.3s ease;
            color: gray;
        }

        .input-box:focus+.floating-label,
        .input-box:not(:placeholder-shown)+.floating-label {
            top: 5px;
            font-size: 12px;
            color: var(--primary);
        }
    </style>
</head>

<body class="bg-[var(--accent)] ">
<nav class="bg-[var(--primary)] text-white p-4 fixed w-full top-0 z-50 shadow-md">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <a href="javascript:history.back()" class="text-white text-2xl">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-bold text-center flex-1">SELL YOUR BOOK</h1>
            <a href="#" class="text-white text-2xl">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>


    <div class="max-w-3xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-20">
        

        <form action="" method="post" enctype="multipart/form-data">
            <!-- Book Details Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Book Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative">
                        <input type="text" name="book_name" placeholder=" " class="input-box border rounded w-full p-3"
                            id="bookName">
                        <label for="bookName" class="floating-label">Book Name</label>
                    </div>
                    <div class="relative">
                        <input type="text" name="book_author" placeholder=" "
                            class="input-box border rounded w-full p-3" id="author">
                        <label for="author" class="floating-label">Author</label>
                    </div>
                    <div class="relative">
                        <input type="number" placeholder=" " name="mrp" class="input-box border rounded w-full p-3"
                            id="mrp">
                        <label for="mrp" class="floating-label">MRP</label>
                    </div>
                    <div class="relative">
                        <input type="number" placeholder=" " name="sell_price"
                            class="input-box border rounded w-full p-3" id="sellingPrice">
                        <label for="sellingPrice" class="floating-label">Selling Price</label>
                    </div>
                    <div class="relative">
                        <input type="number" placeholder=" " name="pages" class="input-box border rounded w-full p-3"
                            id="pages">
                        <label for="pages" class="floating-label">Total Pages</label>
                    </div>
                    <select class="p-3 border rounded w-full" name="book_binding">
                        <option value="">Select Binding</option>
                        <option value="Paper Cover">Paper Cover</option>
                        <option value="Hard Cover">Hard Cover</option>
                        <!-- <option value="New">New</option> -->
                    </select>
                    <div class="relative">
                        <input type="text" placeholder=" " name="book_category" value="<?= $cat['cat_title'] ?>"
                            class="input-box border rounded w-full p-3" id="category" readonly>
                        <label for="category" class="floating-label">Category</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="book_sub_category" value="<?= $cat_name['sub_cat'] ?>"
                            class="input-box border rounded w-full p-3" id="subcategory" readonly>
                        <label for="subcategory" class="floating-label">Subcategory</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="language" class="input-box border rounded w-full p-3"
                            id="language">
                        <label for="language" class="floating-label">Language</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="isbn" class="input-box border rounded w-full p-3"
                            id="isbn">
                        <label for="isbn" class="floating-label">ISBN</label>
                    </div>
                    <select class="p-3 border rounded w-full" name="publish_year">
                        <option>Publish Year</option>
                        <script>
                            for (let year = new Date().getFullYear(); year >= 1950; year--) {
                                document.write(`<option>${year}</option>`);
                            }
                        </script>
                    </select>
                    <select class="p-3 border rounded w-full" name="quality">
                        <option value="">Condition</option>
                        <option value="Good">Good</option>
                        <option value="Old">Old</option>
                        <option value="New">New</option>
                    </select>
                </div>
            </div>

            <!-- Location Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Location Details</h2>
                <div class="relative">
                    <input type="text" placeholder=" " class="input-box border rounded w-full p-3 pr-12" id="location" readonly>
                    <label for="location" class="floating-label">Location</label>
                    <button type="button" onclick="getLocation()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-2xl text-blue-500">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                </div>

                <!-- Latitude & Longitude Hidden Inputs -->
                <input type="text" id="latitude" name="latitude" placeholder="Latitude" class="border rounded p-3 w-full mt-2" hidden>
                <input type="text" id="longitude" name="longitude" placeholder="Longitude" class="border rounded p-3 w-full mt-2" hidden>

                <script>
                    function getLocation() {
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function (position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;

                                document.getElementById('location').value = `Lat: ${lat}, Lng: ${lng}`;
                                document.getElementById('latitude').value = lat;
                                document.getElementById('longitude').value = lng;

                                // alert("Location Captured!");
                            }, function (error) {
                                alert("Location access denied or unavailable.");
                            });
                        } else {
                            alert("Geolocation is not supported by this browser.");
                        }
                    }
                </script>


               <div class="relative mt-4">
    <textarea placeholder=" " class="input-box border rounded w-full p-3" rows="3" id="address">
        <?php 
        if (!empty($address_row)) { 
            echo $address_row['name'] .' , '.$address_row['mobile'] .' , '. $address_row['address'] .' , '. $address_row['city'] .' , '. $address_row['state'] .' , '. $address_row['landmark'] .' , '. $address_row['pincode'];
        } else { 
            echo "No address found"; // Default message if data is missing
        } 
        ?>
    </textarea>
    <label for="address" class="floating-label">Address</label>
</div>

            </div>

            <!-- Book Description Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Book Description</h2>
                <div class="relative">
                    <textarea placeholder=" " class="input-box border rounded w-full p-3" rows="4" id="description"
                        name="book_description"></textarea>
                    <label for="description" class="floating-label">Enter book description...</label>
                </div>
            </div>

            <!-- Image Upload Section -->
            <div>
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Upload Images</h2>
                <div class="grid grid-cols-4 gap-4">
                    <label
                        class="border-2 border-[var(--primary)] flex flex-col items-center justify-center p-4 cursor-pointer w-full h-48 rounded">
                        <input type="file" name="image0" class="hidden" onchange="previewImage(event, 0)">
                        <img id="img0" src="" class="hidden w-full h-full object-cover">
                        <span id="addPhotoText0" class="text-[var(--primary)]">📷 Add Photo</span>
                    </label>
                    <label
                        class="border-2 border-gray-300 flex flex-col items-center justify-center p-4 cursor-pointer w-full h-48 rounded">
                        <input type="file" name="image1" class="hidden" onchange="previewImage(event, 1)">
                        <img id="img1" src="" class="hidden w-full h-full object-cover">
                        <span id="addPhotoText1" class="text-gray-500">📷 Add Photo</span>
                    </label>
                    <label
                        class="border-2 border-gray-300 flex flex-col items-center justify-center p-4 cursor-pointer w-full h-48 rounded">
                        <input type="file" name="image2" class="hidden" onchange="previewImage(event, 2)">
                        <img id="img2" src="" class="hidden w-full h-full object-cover">
                        <span id="addPhotoText2" class="text-gray-500">📷 Add Photo</span>
                    </label>
                    <label
                        class="border-2 border-gray-300 flex flex-col items-center justify-center p-4 cursor-pointer w-full h-48 rounded">
                        <input type="file" name="image3" class="hidden" onchange="previewImage(event, 3)">
                        <img id="img3" src="" class="hidden w-full h-full object-cover">
                        <span id="addPhotoText3" class="text-gray-500">📷 Add Photo</span>
                    </label>
                </div>
            </div>

            <!-- Post Your Ad Button -->
            <div class="text-center mt-6">
                <button class="bg-[var(--primary)] text-white px-6 py-3 rounded-lg font-bold hover:bg-[#3D8D7A]"
                    name="submit">
                    Post Book
                </button>
            </div>
        </form>
        <?php

        if (isset($_POST['submit'])) {
            $book_name = $_POST['book_name'];
            $book_author = $_POST['book_author'];
            $mrp = $_POST['mrp'];
            $sell_price = $_POST['sell_price'];
            $pages = $_POST['pages'];
            $book_category = $_POST['book_category'];
            $book_sub_category = $_POST['book_sub_category'];
            $language = $_POST['language'];
            $isbn = $_POST['isbn'];
            $publish_year = $_POST['publish_year'];
            $quality = $_POST['quality'];
            $book_binding = $_POST['book_binding'];
            
            $book_description = $_POST['book_description'];
            $seller_id = $user['user_id'];
            $latitude = $_POST['latitude'] ;
            $longitude = $_POST['longitude'] ;

            $target_dir = "../assets/images/"; 
            $image1 = "image0";
            $image2 = "image1";
            $image3 = "image2";
            $image4 = "image3";

            if (!empty($_FILES["image0"]["name"])) {
                $image1 = time() . "_" . basename($_FILES["image0"]["name"]);
                move_uploaded_file($_FILES["image0"]["tmp_name"], $target_dir . $image1);
            }
            if (!empty($_FILES["image1"]["name"])) {
                $image2 = time() . "_" . basename($_FILES["image1"]["name"]);
                move_uploaded_file($_FILES["image1"]["tmp_name"], $target_dir . $image2);
            }
            if (!empty($_FILES["image2"]["name"])) {
                $image3 = time() . "_" . basename($_FILES["image2"]["name"]);
                move_uploaded_file($_FILES["image2"]["tmp_name"], $target_dir . $image3);
            }
            if (!empty($_FILES["image3"]["name"])) {
                $image4 = time() . "_" . basename($_FILES["image3"]["name"]);
                move_uploaded_file($_FILES["image3"]["tmp_name"], $target_dir . $image4);
            }

            $sql = "INSERT INTO books (book_name, book_author, mrp, sell_price, book_pages, book_category, book_sub_category, language, isbn, publish_year, quality,book_binding,  book_description, img1, img2, img3, img4,seller_id,latitude, longitude,version) 
            VALUES ('$book_name', '$book_author', '$mrp', '$sell_price', '$pages', '$book_category', '$book_sub_category', '$language', '$isbn', '$publish_year', '$quality','$book_binding', '$book_description', '$image1', '$image2', '$image3', '$image4','$seller_id','$latitude', '$longitude','old')";

            if (mysqli_query($connect, $sql)) {
                echo "<script>alert('Book Ad Posted Successfully!'); window.location.href='sell.php';</script>";
            } else {
                echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
            }

            mysqli_close($connect);
        }
        ?>


    </div>

    <script>
        function previewImage(event, index) {
            const input = event.target;
            const img = document.getElementById(`img${index}`);
            const text = document.getElementById(`addPhotoText${index}`);

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    img.classList.remove("hidden");
                    text.classList.add("hidden");
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

</body>

</html>