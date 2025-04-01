
SELL PAGE RISHAV

<?php
include "../config/connect.php";

if (isset($_SESSION['user'])) {
    $user = getUser();    what
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



view page

<?php
include_once "config/connect.php";

$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;
if (!isset($_GET['book_id'])) {
    redirect("index.php");
}
$book_id = $_GET["book_id"];
$query = $connect->query("select * from books where id='$book_id'");
if ($query->num_rows == 0) {
    redirect("index.php");
}
$book = $query->fetch_array();

// wishlist work
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist2'])) {
    if ($userId) {
        $bookId = $_POST['wishlist_id2'];
        $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        if ($check->num_rows > 0) {
            $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        } else {
            $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
        }
        redirect("wishlist.php");
        exit();
    } else {
        redirect("login.php");
        exit();
    }
}
$bookId = $book['id'];
$checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
$isWishlisted = ($checkWishlist->num_rows > 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadRainbow | Details</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex p-10 bg-white mt-30">
        <div class="flex gap-20 items-center w-5/12 border-gray-300 border-r-2 space-x-4 p-6">
            <div class="flex flex-col space-y-2">
                <img src="assets/images/<?= $book['img1']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img1']; ?>')">
                <img src="assets/images/<?= $book['img2']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img2']; ?>')">
                <img src="assets/images/<?= $book['img3']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img3']; ?>')">
                <img src="assets/images/<?= $book['img4']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img4']; ?>')">
            </div>

            <div class="w-64 rounded-lg overflow-hidden shadow-lg">
                <img id="mainBookImage" src="assets/images/<?= $book['img1']; ?>" alt="Book Image"
                    class="w-full h-full object-cover">
            </div>
        </div>
        <div class="w-7/12 flex flex-col gap-2 p-6">
            <div class="flex ">
                <h1 class="text-2xl font-semibold"><?= $book['book_name']; ?></h1>
                <div class="gap-4 flex ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10 px-2 py-1 text-gray-700 bg-gray-300 rounded-full">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    <div class="relative inline-block">
                        <!-- Share Button -->
                        <button id="shareBtn"
                            class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Share
                        </button>

                        <!-- Dropdown Share Options -->
                        <div id="shareDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                            <div class="py-1">
                                <!-- WhatsApp -->
                                <a href="#" onclick="shareOnWhatsApp()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png"
                                        class="w-5 h-5 mr-2" alt="WhatsApp">
                                    WhatsApp
                                </a>

                                <!-- Facebook -->
                                <a href="#" onclick="shareOnFacebook()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="https://cdn-icons-png.flaticon.com/512/124/124010.png"
                                        class="w-5 h-5 mr-2" alt="Facebook">
                                    Facebook
                                </a>

                                <!-- Twitter -->
                                <a href="#" onclick="shareOnTwitter()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png"
                                        class="w-5 h-5 mr-2" alt="Twitter">
                                    Twitter
                                </a>

                                <!-- Email -->
                                <a href="#" onclick="shareOnEmail()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                    Email
                                </a>

                                <!-- Copy Link -->
                                <a href="#" onclick="copyToClipboard()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                    Copy Link
                                </a>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Toggle dropdown
                        document.getElementById('shareBtn').addEventListener('click', function (e) {
                            e.stopPropagation();
                            document.getElementById('shareDropdown').classList.toggle('hidden');
                        });

                        // Close dropdown when clicking outside
                        document.addEventListener('click', function () {
                            document.getElementById('shareDropdown').classList.add('hidden');
                        });

                        // Share functions
                        function getShareUrl() {
                            return window.location.href;
                        }

                        function getShareText() {
                            return "Check out this book: <?= $book['book_name'] ?>";
                        }

                        // WhatsApp
                        function shareOnWhatsApp() {
                            const url = `https://wa.me/?text=${encodeURIComponent(getShareText() + ' - ' + getShareUrl())}`;
                            window.open(url, '_blank');
                        }

                        // Facebook
                        function shareOnFacebook() {
                            const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(getShareUrl())}`;
                            window.open(url, '_blank', 'width=600,height=400');
                        }

                        // Twitter
                        function shareOnTwitter() {
                            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(getShareText())}&url=${encodeURIComponent(getShareUrl())}`;
                            window.open(url, '_blank', 'width=600,height=400');
                        }

                        // Email
                        function shareOnEmail() {
                            const subject = "Check out this book: <?= $book['book_name'] ?>";
                            const body = `I thought you might like this book:\n\n${getShareText()}\n\n${getShareUrl()}`;
                            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
                        }

                        // Copy Link
                        function copyToClipboard() {
                            navigator.clipboard.writeText(getShareUrl())
                                // .then(() => alert('Link copied to clipboard!'))
                                .catch(() => {
                                    // Fallback for older browsers
                                    const input = document.createElement('input');
                                    input.value = getShareUrl();
                                    document.body.appendChild(input);
                                    input.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(input);
                                    alert('Link copied!');
                                });
                        }
                    </script>
                </div>
            </div>

            <p class="text-orange-400 text-sm font-semibold"><?= $book['book_category']; ?></p>
            <h3 class="text-lg font-semibold">Author: <span class="text-[#3D8D7A]"><?= $book['book_author']; ?></span>
            </h3>
            <div class="flex gap-5 mb-5">
                <?php if ($book['version'] != 'old'): ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="book_type" id="e_book" value="e_book" class="peer sr-only">
                        <div
                            class="border-2 border-orange-300 hover:shadow-xl rounded-lg px-3 h-22 w-42 pt-1 flex flex-col peer-checked:border-orange-700">
                            <p class="text-lg p-0 font-semibold">E-BOOK</p>

                            <p class="text-gray-700 font-semibold">Price: <span
                                    class="text-xl text-red-500">₹<?= $book['e_book_price']; ?></span></p>
                            <?=
                                $book['e_book_price'] != null ? "<span class='text-green-500 text-sm'>Available Now</span>" : "<span class='text-red-500 text-sm'>Not Available</span>";
                            ?>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="book_type" id="physical" value="physical" class="peer sr-only " checked>
                        <div
                            class="border-2 border-orange-300 hover:shadow-xl rounded-lg px-3 h-22 w-42 pt-1 flex flex-col peer-checked:border-orange-700">
                            <p class="text-lg font-semibold"><?= $book['book_binding']; ?></p>
                            <?php
                            $bookId = $book['id'];
                            $mrp = floatval($book['mrp']);
                            $sell_price = floatval($book['sell_price']);
                            $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                            ?>
                            <p><?= $discount; ?>% off</p>
                            <p class="text-gray-700 font-semibold">Price: ₹<del class="text-sm"><?= $book['mrp']; ?></del>
                                <span class="text-xl text-red-500">₹<?= $book['sell_price']; ?></span>
                            </p>
                        </div>
                    </label>
                <?php else: ?>
                    <div>
                        <p>MRP: <?= $book['mrp']; ?></p>
                        <p>Price: <?= $book['sell_price']; ?></p>
                        <p>Binding: <?= $book['book_binding']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <hr class="text-gray-300">
            <div class="flex flex-col gap-5">
                <h1 class="text-xl text-gray-600 font-semibold">Key Highlights</h1>
                <div class="grid grid-cols-5 gap-2">
                    <div class="flex items-center border-r gap-1 border-gray-300 px-3 flex-col ">
                        <p class="text-sm text-gray-500">language</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" />
                        </svg>
                        <p><?= $book['language']; ?></p>

                    </div>
                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Total Pages</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>

                        <p><?= $book['book_pages'] ?></p>
                    </div>
                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">ISBN</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-5">
                            <path
                                d="M24 32C10.7 32 0 42.7 0 56L0 456c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24L64 56c0-13.3-10.7-24-24-24L24 32zm88 0c-8.8 0-16 7.2-16 16l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zm96 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zM448 56l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0c-13.3 0-24 10.7-24 24zm-64-8l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16s-16 7.2-16 16z" />
                        </svg>

                        <p><?= $book['isbn'] ?></p>
                    </div>

                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Publish Date</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>


                        <p><?= $book['publish_year'] ?></p>
                    </div>

                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Binding</p>
                        <img src="assets/images/paperback.png" class="size-7" alt="">


                        <p><?= $book['book_binding'] ?></p>
                    </div>
                </div>
                <?php
                if ($book['version'] == "new"):
                    ?>
                    <div class="flex ">
                        <p class="mt-4 text-lg font-bold  "><span id="selectedOption"></span></p>
                    </div><?php else: ?>
                    <?php if ($book['version'] != 'new'): ?>
                        <a href="chatboard.php?book_id=<?= $book['id']; ?>" target="_blank"
                            class="py-2 px-4 bg-blue-500 font-semibold text-center text-white rounded">
                            Chat With Seller
                        </a>

                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <script>
                function changeImage(src) {
                    document.getElementById("mainBookImage").src = src;
                }
            </script>
            <script>
                function updateSelectedOption(value) {
                    const selectedOption = document.getElementById("selectedOption");
                    if (value === "e_book") {
                        selectedOption.innerHTML = `
                           <div class='grid grid-cols-2 gap-5'>
                               <a class='text-orange-500 font-semibold border-orange-500 border rounded px-5 py-2' href='cart.php?add_book=<?=
                                   $book['id'] ?>'>Get E-BOOK to Cart</a>
                             <a class='text-white bg-orange-500 font-semibold rounded px-5 py-2' href='item_checkout.php?buy_book=<?=
                                 $book['id'] ?>' class='flex'>Get E-BOOK Now</a>
                         </div>
                        `;
                    } else if (value === "physical") {
                        selectedOption.innerHTML = `
                        <div class='grid grid-cols-2 gap-5'>
                               <a class='text-orange-500 font-semibold border-orange-500 border rounded px-5 py-2' href='cart.php?add_book=<?=
                                   $book['id'] ?>'>Add Hardcopi to Cart</a>
                             <a class='text-white bg-orange-500 font-semibold rounded px-5 py-2' href='item_checkout.php?buy_book=<?=
                                 $book['id'] ?>' class=' flex'>Buy Hardcopi Now</a>
                         </div>
                        `;
                    }
                }

                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById("physical").checked = true;
                    updateSelectedOption("physical");
                });
                document.querySelectorAll('input[name="book_type"]').forEach((radio) => {
                    radio.addEventListener("change", function () {
                        updateSelectedOption(this.value);
                    });
                });
            </script>
        </div>
    </div>
    <div class="bg-white flex flex-col gap-1 mt-10 px-[5%] py-5 w-full flex">
        <div>
            <h1 class="font-semibold border-b border-gray-300 w-full py-3 text-xl">Description :-</h1>
            <p class="text-gray-700 border-b border-gray-300 py-2"><?= $book['book_description']; ?></p>
        </div>
        <div>
            <h1 class="font-semibold border-b border-gray-300 w-full py-3 text-xl">Author :-</h1>
            <p class="text-gray-700 border-b border-gray-300 py-2"><?= $book['book_author']; ?></p>
        </div>
    </div>
    <?php include_once "includes/recomended_book.php" ?>
    <?php include_once "includes/footer2.php" ?>


    <script>
        const scrollContainer = document.getElementById("bookScroll");
        document.getElementById("scrollLeft").onclick = () => scrollContainer.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
        document.getElementById("scrollRight").onclick = () => scrollContainer.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>