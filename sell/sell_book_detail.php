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
            pointer-events: none;
        }

        .input-box:focus+.floating-label,
        .input-box:not(:placeholder-shown)+.floating-label,
        .input-box.has-value+.floating-label,
        textarea:focus+.floating-label,
        textarea:not(:placeholder-shown)+.floating-label {
            top: 5px;
            font-size: 12px;
            color: var(--primary);
        }

        /* For textarea floating labels */
        .textarea-container {
            position: relative;
        }

        .textarea-container .floating-label {
            top: 20px;
        }

        .textarea-container textarea:focus+.floating-label,
        .textarea-container textarea:not(:placeholder-shown)+.floating-label {
            top: 5px;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .image-upload-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .form-grid {
                grid-template-columns: 1fr !important;
            }

            .nav-title {
                font-size: 1rem !important;
            }

            .container-padding {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
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
                    <!-- <div class="relative">
                        <input type="text" placeholder=" " name="language" class="input-box border rounded w-full p-3"
                            id="language">
                        <label for="language" class="floating-label">Language</label>
                    </div> -->
                    <select class="p-3 border rounded w-full" name="language">
                        <option value="">Select language</option>
                        <option value="English">English</option>
                        <option value="Hindi">Hindi</option>
                        <!-- <option value="New">New</option> -->
                    </select>
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
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Profile Details</h2>
                <div class="flex flex-1 gap-2 w-full">
                    <div class="relative w-full">
                        <input type="text" placeholder=" " value="<?= $user['name']; ?>" name="name"
                            class="input-box border rounded w-full p-3" id="name">
                        <label for="name" class="floating-label"> </label>
                    </div>
                    <div class="relative w-full">
                        <input type="text" placeholder="" value="<?= $user['contact']; ?>" name="contact"
                            class="input-box border rounded w-full p-3" id="contact">
                        <label for="contact" class="floating-label">Mobile No.</label>
                    </div>
                </div>


                <div class="relative mt-4">
                    <textarea placeholder=" " class="input-box border rounded w-full p-3" rows="3" id="address">
        <?php
        if (!empty($address_row)) {
            echo $address_row['name'] . ' , ' . $address_row['mobile'] . ' , ' . $address_row['address'] . ' , ' . $address_row['city'] . ' , ' . $address_row['state'] . ' , ' . $address_row['landmark'] . ' , ' . $address_row['pincode'];
        } else {
            echo "No address found"; // Default message if data is missing
        }
        ?>
    </textarea>
                    <label for="address" class="floating-label">Address</label>
                </div>


                <div class="relative">
                    <input type="text" placeholder=" " class="input-box border rounded w-full p-3 pr-12" id="location"
                        readonly>
                    <label for="location" class="floating-label">Location</label>
                    <button type="button" onclick="getLocation()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-2xl text-blue-500">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                </div>

                <!-- Latitude & Longitude Hidden Inputs -->
                <input type="text" id="latitude" name="latitude" placeholder="Latitude"
                    class="border rounded p-3 w-full mt-2" hidden>
                <input type="text" id="longitude" name="longitude" placeholder="Longitude"
                    class="border rounded p-3 w-full mt-2" hidden>

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
                <p class="text-sm text-gray-500 mb-3">First image will be used as the cover photo</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 image-upload-grid">
                    <label
                        class="border-2 border-[var(--primary)] border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image0" class="hidden" onchange="previewImage(event, 0)"
                            accept="image/*" required>
                        <img id="img0" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText0" class="text-[var(--primary)] text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo*</span>
                        </span>
                    </label>
                    <label
                        class="border-2 border-gray-300 border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image1" class="hidden" onchange="previewImage(event, 1)"
                            accept="image/*">
                        <img id="img1" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText1" class="text-gray-500 text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo</span>
                        </span>
                    </label>
                    <label
                        class="border-2 border-gray-300 border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image2" class="hidden" onchange="previewImage(event, 2)"
                            accept="image/*">
                        <img id="img2" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText2" class="text-gray-500 text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo</span>
                        </span>
                    </label>
                    <label
                        class="border-2 border-gray-300 border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image3" class="hidden" onchange="previewImage(event, 3)"
                            accept="image/*">
                        <img id="img3" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText3" class="text-gray-500 text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Post Your Ad Button -->
            <div class="text-center mt-8">
                <button type="submit"
                    class="bg-[var(--primary)] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#2e7a68] transition-colors w-full sm:w-auto"
                    name="submit">
                    Post Book
                </button>
            </div>
        </form>
        <?php
        // include 'db_connection.php'; // यहाँ अपना DB connection include करो (e.g., $connect)
        
        // Start session if needed for $user
// session_start();
// $user = $_SESSION['user'];
        
        if (isset($_POST['submit'])) {
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
            if (empty($isbn) || !preg_match("/^[0-9]{10}([0-9]{3})?$/", $isbn)) {
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

            $seller_id = $user['user_id']; // Make sure you pass this securely (e.g. from session)
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
                $sql = "INSERT INTO books 
            (book_name, book_author, mrp, sell_price, book_pages, book_category, book_sub_category, language, isbn, publish_year, quality, book_binding, book_description, img1, img2, img3, img4, seller_id, latitude, longitude, version) 
            VALUES 
            ('$book_name', '$book_author', '$mrp', '$sell_price', '$pages', '$book_category', '$book_sub_category', '$language', '$isbn', '$publish_year', '$quality', '$book_binding', '$book_description', '$image1', '$image2', '$image3', '$image4', '$seller_id', '$latitude', '$longitude', 'old')";

                if (mysqli_query($connect, $sql)) {
                    echo "<script>alert('Book Ad Posted Successfully!'); window.location.href='sell.php';</script>";
                } else {
                    echo "<script>alert('Error: " . mysqli_error($connect) . "');</script>";
                }
            } else {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>❌ $error</p>";
                }
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