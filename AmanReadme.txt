
SELL PAGE RISHAV

<?php
include "../config/connect.php";

if (isset($_SESSION['user'])) {
    $user = getUser();
}
$user_email = $user['email'];
$address_query = mysqli_query($connect, "SELECT address FROM user_address WHERE email = '$user_email'");
$address_row = mysqli_fetch_assoc($address_query);
$user_address = $address_row['address'] ?? ''; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
         @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .img>upload {
            width: 120px;
            height: 50px;
            animation: fadeIn 0.8s ease-in-out;
        }

        .nav {
            background: #3d8d7a;
            animation: fadeIn 0.8s ease-in-out;

        }

        .poster {
            display: flex;
            font-size: x-large;
            align-items: center;
            animation: fadeIn 0.8s ease-in-out;
        }
       
    </style>
</head>

<body style="background-color:#FBFFE4; animation: fadeIn 0.8s ease-in-out;">
    <nav class="navbar navbar-expand-lg navbar-dark nav fixed-top">
        <div class="container justify-content-start gap-3">
            <a href="../index.php">
                <i class="bi bi-arrow-left-circle-fill text-light h2"></i>
            </a>
            <img src="../assets/images/Screenshot 2025-03-24 135151-Photoroom.png" alt="logo" class="img-fluid " style="height:40px;">


        </div>
    </nav>


    <div id="bookDetails" class="container py-5 mt-4">
        <h2 class="mb-4 text-secondary">Book Details</h2>
        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

            <div class="row g-4">

                <div class="col-md-4">
                    <label class="form-label h6">Book Name</label>
                    <input type="text" name="book_name" class="form-control" placeholder="Enter Book name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Binding</label>
                    <select name="book_binding" class="form-select">
                        <option value="">Select binding</option>
                        <option value="Paperwork">Paperwork</option>
                        <option value="Hardcover">Hardcover</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">MRP</label>
                    <input type="number" name="mrp" class="form-control" placeholder="Enter MRP" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Selling Price</label>
                    <input type="number" name="selling_price" class="form-control" placeholder="Enter selling price"
                        required>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Pages</label>
                    <input type="number" name="pages" class="form-control" placeholder="Total pages">
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Category</label>

                    <select name="category" class="form-select">
                        <option value="">Select book category</option>
                        <?php
                        $callingCat = mysqli_query($connect, "SELECT * FROM category");
                        while ($cat = mysqli_fetch_assoc($callingCat)) {
                            echo "<option value='" . $cat['cat_title'] . "'>" . $cat['cat_title'] . "</option>";
                        }
                        ?>
                    </select>

                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Sub Category</label>
                    <select name="sub_category" class="form-select">
                        <option value="">Select Sub category</option>
                        <option value="biology">Biology</option>
                        <option value="chemistry">Chemistry</option>
                        <option value="botany">Botany</option>
                        <option value="zeology">Zeology</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Language</label>
                    <input type="text" name="language" class="form-control" placeholder="Book language" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">ISBN</label>
                    <input type="text" name="isbn" class="form-control" placeholder="ISBN number">
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Publish Year</label>
                    <input type="number" name="publish_year" class="form-control" placeholder="Enter publish year"
                        required>
                </div>

                <div class="col-4">
                    <label class="form-label h6">Quality</label>
                    <select name="quality" class="form-select" name="quality">
                        <option value="New">New</option>
                        <option value="Like New">Like New</option>
                        <option value="Good">Good</option>
                        <option value="Acceptable">Acceptable</option>
                    </select>
                </div>
                <div class="col-4">
                    <label class="form-label h6">Version</label>
                    <select name="version" class="form-select">
                        <option value="">select version of book</option>
                        <option value="old">Old</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Class</label>
                    <input type="text" name="class" class="form-control" placeholder="Enter book class name" required>
                </div>
                <div class="col-4">
                    <label class="form-label h6">Location
                        <i class="bi bi-geo-alt-fill"></i>
                    </label>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <br>
                    <button type="button" onclick="getLocation()" class="btn btn-success">Get Location</button>
                </div>
                <div class="col-12">
                    <label class="form-label h6">Address</label>
                    <textarea name="address" class="form-control" rows="2"
                        placeholder="Enter Your Address"><?= htmlspecialchars($user_address) ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label h6">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                        placeholder="Describe the book"></textarea>
                </div>
                <div class="row gap-2 mt-2">
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput1').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer1" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText1" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2">front image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="file" id="fileInput1" accept="image/*" class="d-none upload" multiple name="img1"
                        onchange="previewImages(event, 'imagePreviewContainer1', 'uploadText1')">
                    <br>

                    <!-- Second Upload Section -->
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput2').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer2" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText2" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2"> image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="file" id="fileInput2" accept="image/*" class="d-none upload" multiple name="img2"
                        style="width:100px; height:40px;"
                        onchange="previewImages(event, 'imagePreviewContainer2', 'uploadText2')">
                    <br>

                    <!-- Third Upload Section -->

                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput3').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer3" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText3" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2">Back Image</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="fileInput3" accept="image/*" class="d-none upload" multiple name="img3"
                            onchange="previewImages(event, 'imagePreviewContainer3', 'uploadText3')">

                    </div>
                    <!-- Fourth Upload Section -->
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput4').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer4" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText4" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2">Extra Image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="file" id="fileInput4" accept="image/*" class="d-none upload" multiple name="img4"
                        onchange="previewImages(event, 'imagePreviewContainer4', 'uploadText4')">


                    <script>
                        function previewImages(event, previewContainerId, uploadTextId) {
                            const files = event.target.files;
                            const imagePreviewContainer = document.getElementById(previewContainerId);
                            const uploadText = document.getElementById(uploadTextId);

                            imagePreviewContainer.innerHTML = ''; // Clear previous previews

                            if (files.length > 0) {
                                uploadText.classList.add('d-none'); // Hide "Add Photos" text

                                Array.from(files).forEach((file) => {
                                    if (file && file.type.startsWith('image/')) {
                                        const reader = new FileReader();

                                        reader.onload = function (e) {
                                            const img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.className = 'img-fluid rounded';
                                            img.style.maxWidth = '100px';
                                            img.style.maxHeight = '100px';
                                            img.style.objectFit = 'cover';
                                            imagePreviewContainer.appendChild(img);
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                });
                            }
                        }

                    </script>
                </div>
            </div>


            <div class="col-12 d-flex justify-content-end">

                <a href="sell.php" class="btn btn-warning me-2 mt-4">Reset</a>
                <button type="submit" class="btn  me-2 w-25 mt-4" style="background: #a3a1c6;"
                    name="submit">Sell</button>
            </div>
    </div>
    </form>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    alert("Location captured!");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>

    <?php
    if (isset($_POST['submit'])) {
        $book_name = $_POST['book_name'];
        $book_author = $_POST['author'];
        $book_binding = $_POST['book_binding'] ?? '';
        $mrp = $_POST['mrp'];
        $price = $_POST['selling_price'];
        $pages = $_POST['pages'] ?? 0;
        $category = $_POST['category'];
        $sub_category = $_POST['sub_category'] ?? '';
        $language = $_POST['language'];
        $isbn = $_POST['isbn'] ?? '';
        $publish_year = $_POST['publish_year'];
        $quality = $_POST['quality'];
        $version = $_POST['version'] ?? '';
        $class = $_POST['class'];
        $latitude = $_POST['latitude'] ?? '';
        $longitude = $_POST['longitude'] ?? '';
        $address = $_POST['address'];
        $sbook_description = $_POST['description'] ?? '';
        $seller_id = $user['user_id'];

        $errors = [];
        if (empty($book_name) || empty($book_author) || empty($mrp) || empty($price) || empty($publish_year) || empty($language) || empty($address)) {
            $errors[] = "<script>Swal.fire('All required fields must be filled!')</script>";
            
        }

        if (!is_numeric($mrp) || !is_numeric($price) || !is_numeric($publish_year)) {
            $errors[] = "MRP, Selling Price, and Publish Year must be numeric!";
        }
        if (strlen($publish_year) != 4) {
            $errors[] = "<script>Swal.fire('public year must be 4 digit !')</script>";

        }

        if (empty($errors)) {
            $img_names = [];
            for ($i = 1; $i <= 4; $i++) {
                if (!empty($_FILES["img$i"]["name"])) {
                    $img_name = time() . "_" . basename($_FILES["img$i"]["name"]);
                    $target_path = "../assets/images/" . $img_name;
                    if (move_uploaded_file($_FILES["img$i"]["tmp_name"], $target_path)) {
                        $img_names[] = $img_name;
                    } else {
                        $img_names[] = null;
                    }
                } else {
                    $img_names[] = null;
                }
            }

            $query = "INSERT INTO books (book_name, book_author, book_binding, mrp, sell_price, book_pages, book_category, book_sub_category, language, isbn, publish_year, quality, version, class, latitude, longitude, address, book_description, img1, img2, img3, img4, seller_id) 
                VALUES ('$book_name', '$book_author', '$book_binding', '$mrp', '$price', '$pages', '$category', '$sub_category', '$language', '$isbn', '$publish_year', '$quality', '$version', '$class', '$latitude', '$longitude', '$address', '$sbook_description', '{$img_names[0]}', '{$img_names[1]}', '{$img_names[2]}', '{$img_names[3]}', '$seller_id')";

            if (mysqli_query($connect, $query)) {
                echo "<script>alert('Book added successfully!'); window.location.href='../index.php';</script>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . mysqli_error($connect) . "</div>";
            }
        } else {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        }
    }
    ?>


    </div>

    <!-- Add Bootstrap CSS -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>



aman header
<?php
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;
$userEmail = $user['email'];
?>
<div class="flex fixed w-full z-50 top-0 justify-between items-center bg-[#3D8D7A] px-[5%] py-3">
    <a href="index.php" class="text-[#FBFFE4] font-bold text-2xl tracking-wide"><img
            src="assets/images/Screenshot 2025-03-24 135151-Photoroom.png" alt="Logo"
            class="h-10 w-auto   object-contain">
    </a>
    <form action="filter.php" method="get" class="flex border rounded">
        <input type="search" name="search_book" placeholder="Search by ISBN or name..."
            class="p-2 bg-white rounded-l w-[35rem] text-black ">
        <button type="submit" name="search"
            class="bg-[#B3D8A8] font-semibold rounded-r p-2 text-slate-800">Search</button>
    </form>
    <a href="wishlist.php"
        class="relative inline-flex items-center p-1 text-sm font-medium text-center text-white rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-8 text-[#FBFFE4]">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <span class="sr-only">Notifications</span>
        <?php $countWishlistQuery = $connect->query("select * from wishlist where user_id='$userId'");
        $countWishlist = $countWishlistQuery->num_rows;
        if ($countWishlist > 0):
            ?>
            <div
                class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
                <?= $countWishlist; ?>
            </div>
        <?php endif; ?>
    </a>
    <a href="cart.php"
        class="relative inline-flex items-center p-1 text-sm font-medium text-center text-white rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-7 text-[#FBFFE4]">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
        </svg>
        <span class="sr-only">Notifications</span>
        <?php $countcartQuery = $connect->query("select * from cart where email='$userEmail' and direct_buy=0");
        $countcart = $countcartQuery->num_rows;
        if ($countcart > 0):
            ?>
        <div
            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
            <?= $countcart;?>
        </div>
        <?php endif;?>
    </a>

    <a href="chatboard.php"
        class="relative inline-flex items-center p-1 text-sm font-medium text-center text-white rounded-lg ">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 0 1-.923 1.785A5.969 5.969 0 0 0 6 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337Z" />
        </svg>
        <span class="sr-only">Notifications</span>
        <div
            class="absolute inline-flex items-center justify-center w-6 h-6 text-xs font-bold text-white bg-red-500 border-2 border-white rounded-full -top-2 -end-2 dark:border-gray-900">
            2
        </div>
    </a>

    <a href="sell/sell2.php" class="border p-2 rounded-full text-[#FBFFE4]">Sell Used Book</a>

    <?php if (isset($_SESSION['user'])): ?>
        <button id="dropdownAvatarNameButton" data-dropdown-toggle="dropdownAvatarName"
            class="flex items-center text-sm pe-1 font-medium text-[#FBFFE4] rounded-full md:me-0 border p-1 focus:ring-gray-100 relative"
            type="button">
            <span class="sr-only">Open user menu</span>
            <img class="w-8 h-8 me-2 rounded-full"
                src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" alt="user photo">
            <?= $user['name']; ?>
            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 10 6">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 4 4 4-4" />
            </svg>
        </button>

        <div id="dropdownAvatarName"
            class="absolute right-5 mt-2 hidden bg-[#B3D8A8] divide-y divide-gray-100 rounded-lg shadow-sm w-44 z-50">
            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                <div class="truncate"><?= $user['email']; ?></div>
            </div>
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <li>
                    <a href="profile.php"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">View
                        Profile</a>
                </li>
                <li>
                    <a href="contact.php "
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Help</a>
                </li>
                <li>
                    <a href="#"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                </li>
            </ul>
            <div class="py-2">
                <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
            </div>
        </div>
    <?php else: ?>
        <a href="login.php">Login</a>
    <?php endif; ?>
</div>