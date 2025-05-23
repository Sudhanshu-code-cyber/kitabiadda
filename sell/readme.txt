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
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../login.php';
                } else if (result.isDenied) {
                    window.location.href = '$previousPage';
                }
            });

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
    $call_cat = mysqli_query($connect, "SELECT * FROM sub_category WHERE id='$id_subcat'");
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

        .input-box:focus + .floating-label,
        .input-box:not(:placeholder-shown) + .floating-label,
        .input-box.has-value + .floating-label,
        textarea:focus + .floating-label,
        textarea:not(:placeholder-shown) + .floating-label {
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
        
        .textarea-container textarea:focus + .floating-label,
        .textarea-container textarea:not(:placeholder-shown) + .floating-label {
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

<body class="bg-[var(--accent)]">
    <nav class="bg-[var(--primary)] text-white p-4 fixed w-full top-0 z-50 shadow-md">
        <div class="max-w-5xl mx-auto flex justify-between items-center container-padding">
            <a href="javascript:history.back()" class="text-white text-2xl">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-bold text-center flex-1 nav-title">SELL YOUR BOOK</h1>
            <a href="#" class="text-white text-2xl">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-20 mb-10 container-padding">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- Book Details Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Book Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 form-grid">
                    <div class="relative">
                        <input type="text" name="book_name" placeholder=" " class="input-box border rounded w-full p-3" id="bookName" required>
                        <label for="bookName" class="floating-label">Book Name*</label>
                    </div>
                    <div class="relative">
                        <input type="text" name="book_author" placeholder=" " class="input-box border rounded w-full p-3" id="author" required>
                        <label for="author" class="floating-label">Author*</label>
                    </div>
                    <div class="relative">
                        <input type="number" placeholder=" " name="mrp" class="input-box border rounded w-full p-3" id="mrp" required>
                        <label for="mrp" class="floating-label">MRP*</label>
                    </div>
                    <div class="relative">
                        <input type="number" placeholder=" " name="sell_price" class="input-box border rounded w-full p-3" id="sellingPrice" required>
                        <label for="sellingPrice" class="floating-label">Selling Price*</label>
                    </div>
                    <div class="relative">
                        <input type="number" placeholder=" " name="pages" class="input-box border rounded w-full p-3" id="pages">
                        <label for="pages" class="floating-label">Total Pages</label>
                    </div>
                    <div class="relative">
                        <select class="p-3 border rounded w-full appearance-none" name="book_binding" id="bookBinding" required>
                            <option value="" selected disabled>Select Binding</option>
                            <option value="Paper Cover">Paper Cover</option>
                            <option value="Hard Cover">Hard Cover</option>
                        </select>
                        <label for="bookBinding" class="floating-label" style="background: transparent; pointer-events: none;">Binding*</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="book_category" value="<?= $cat['cat_title'] ?>" class="input-box border rounded w-full p-3" id="category" readonly>
                        <label for="category" class="floating-label">Category</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="book_sub_category" value="<?= $cat_name['sub_cat'] ?>" class="input-box border rounded w-full p-3" id="subcategory" readonly>
                        <label for="subcategory" class="floating-label">Subcategory</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="language" class="input-box border rounded w-full p-3" id="language">
                        <label for="language" class="floating-label">Language</label>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder=" " name="isbn" class="input-box border rounded w-full p-3" id="isbn">
                        <label for="isbn" class="floating-label">ISBN</label>
                    </div>
                    <div class="relative">
                        <select class="p-3 border rounded w-full appearance-none" name="publish_year" id="publishYear">
                            <option value="" selected disabled>Publish Year</option>
                            <script>
                                for (let year = new Date().getFullYear(); year >= 1950; year--) {
                                    document.write(`<option value="${year}">${year}</option>`);
                                }
                            </script>
                        </select>
                        <label for="publishYear" class="floating-label" style="background: transparent; pointer-events: none;">Publish Year</label>
                    </div>
                    <div class="relative">
                        <select class="p-3 border rounded w-full appearance-none" name="quality" id="quality" required>
                            <option value="" selected disabled>Condition</option>
                            <option value="Good">Good</option>
                            <option value="Old">Old</option>
                            <option value="New">New</option>
                        </select>
                        <label for="quality" class="floating-label" style="background: transparent; pointer-events: none;">Condition*</label>
                    </div>
                </div>
            </div>

            <!-- Location Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Location Details</h2>
                <div class="relative mb-4">
                    <input type="text" placeholder=" " class="input-box border rounded w-full p-3 pr-12" id="location" readonly>
                    <label for="location" class="floating-label">Location</label>
                    <button type="button" onclick="getLocation()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-2xl text-blue-500">
                        <i class="fas fa-map-marker-alt"></i>
                    </button>
                </div>

                <!-- Latitude & Longitude Hidden Inputs -->
                <input type="hidden" id="latitude" name="latitude" placeholder="Latitude">
                <input type="hidden" id="longitude" name="longitude" placeholder="Longitude">

                <div class="textarea-container relative mt-4">
                    <textarea placeholder=" " class="border rounded w-full p-3" rows="3" id="address" name="address" readonly><?php 
                        if (!empty($address_row)) { 
                            echo $address_row['name'] .' , '.$address_row['mobile'] .' , '. $address_row['address'] .' , '. $address_row['city'] .' , '. $address_row['state'] .' , '. $address_row['landmark'] .' , '. $address_row['pincode'];
                        } else { 
                            echo "No address found";
                        } 
                    ?></textarea>
                    <label for="address" class="floating-label">Address</label>
                </div>
            </div>

            <!-- Book Description Section -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Book Description</h2>
                <div class="textarea-container relative">
                    <textarea placeholder=" " class="border rounded w-full p-3" rows="4" id="description" name="book_description"></textarea>
                    <label for="description" class="floating-label">Enter book description...</label>
                </div>
            </div>

            <!-- Image Upload Section -->
            <div>
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Upload Images</h2>
                <p class="text-sm text-gray-500 mb-3">First image will be used as the cover photo</p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 image-upload-grid">
                    <label class="border-2 border-[var(--primary)] border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image0" class="hidden" onchange="previewImage(event, 0)" accept="image/*" required>
                        <img id="img0" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText0" class="text-[var(--primary)] text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo*</span>
                        </span>
                    </label>
                    <label class="border-2 border-gray-300 border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image1" class="hidden" onchange="previewImage(event, 1)" accept="image/*">
                        <img id="img1" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText1" class="text-gray-500 text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo</span>
                        </span>
                    </label>
                    <label class="border-2 border-gray-300 border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image2" class="hidden" onchange="previewImage(event, 2)" accept="image/*">
                        <img id="img2" src="" class="hidden w-full h-full object-cover rounded">
                        <span id="addPhotoText2" class="text-gray-500 text-center">
                            <i class="fas fa-camera text-2xl block mb-1"></i>
                            <span class="text-xs">Add Photo</span>
                        </span>
                    </label>
                    <label class="border-2 border-gray-300 border-dashed flex flex-col items-center justify-center p-4 cursor-pointer w-full h-40 sm:h-48 rounded">
                        <input type="file" name="image3" class="hidden" onchange="previewImage(event, 3)" accept="image/*">
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
                <button type="submit" class="bg-[var(--primary)] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#2e7a68] transition-colors w-full sm:w-auto" name="submit">
                    Post Book
                </button>
            </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {
            $book_name = mysqli_real_escape_string($connect, $_POST['book_name']);
            $book_author = mysqli_real_escape_string($connect, $_POST['book_author']);
            $mrp = mysqli_real_escape_string($connect, $_POST['mrp']);
            $sell_price = mysqli_real_escape_string($connect, $_POST['sell_price']);
            $pages = mysqli_real_escape_string($connect, $_POST['pages']);
            $book_category = mysqli_real_escape_string($connect, $_POST['book_category']);
            $book_sub_category = mysqli_real_escape_string($connect, $_POST['book_sub_category']);
            $language = mysqli_real_escape_string($connect, $_POST['language']);
            $isbn = mysqli_real_escape_string($connect, $_POST['isbn']);
            $publish_year = mysqli_real_escape_string($connect, $_POST['publish_year']);
            $quality = mysqli_real_escape_string($connect, $_POST['quality']);
            $book_binding = mysqli_real_escape_string($connect, $_POST['book_binding']);
            $book_description = mysqli_real_escape_string($connect, $_POST['book_description']);
            $seller_id = $user['user_id'];
            $latitude = mysqli_real_escape_string($connect, $_POST['latitude']);
            $longitude = mysqli_real_escape_string($connect, $_POST['longitude']);

            $target_dir = "../assets/images/"; 
            $image1 = $image2 = $image3 = $image4 = '';

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

            $sql = "INSERT INTO books (book_name, book_author, mrp, sell_price, book_pages, book_category, book_sub_category, language, isbn, publish_year, quality, book_binding, book_description, img1, img2, img3, img4, seller_id, latitude, longitude, version) 
            VALUES ('$book_name', '$book_author', '$mrp', '$sell_price', '$pages', '$book_category', '$book_sub_category', '$language', '$isbn', '$publish_year', '$quality', '$book_binding', '$book_description', '$image1', '$image2', '$image3', '$image4', '$seller_id', '$latitude', '$longitude', 'old')";

            if (mysqli_query($connect, $sql)) {
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Book Ad Posted Successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href='sell.php';
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error: " . addslashes(mysqli_error($connect)) . "',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }

            mysqli_close($connect);
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function previewImage(event, index) {
            const input = event.target;
            const img = document.getElementById(`img${index}`);
            const text = document.getElementById(`addPhotoText${index}`);
            const label = input.parentElement;

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    img.src = e.target.result;
                    img.classList.remove("hidden");
                    text.classList.add("hidden");
                    label.classList.remove("border-[var(--primary)]", "border-gray-300");
                    label.classList.add("border-transparent");
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function getLocation() {
            if (navigator.geolocation) {
                Swal.fire({
                    title: 'Getting Location',
                    text: 'Please wait while we get your location...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                navigator.geolocation.getCurrentPosition(function (position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    document.getElementById('location').value = `Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lng;

                    Swal.fire({
                        title: 'Success!',
                        text: 'Location captured successfully',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                }, function (error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Location access denied or unavailable. Please enable location services.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            } else {
                Swal.fire({
                    title: 'Not Supported',
                    text: 'Geolocation is not supported by this browser.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        }

        // Initialize floating labels for select elements
        document.addEventListener('DOMContentLoaded', function() {
            // Handle select elements
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value) {
                        this.classList.add('has-value');
                    } else {
                        this.classList.remove('has-value');
                    }
                });
                
                // Initialize on load if value exists
                if (select.value) {
                    select.classList.add('has-value');
                }
            });
            
            // Handle textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                if (textarea.value.trim() !== '') {
                    textarea.nextElementSibling.classList.add('floating-label-active');
                }
                
                textarea.addEventListener('input', function() {
                    if (this.value.trim() !== '') {
                        this.nextElementSibling.classList.add('floating-label-active');
                    } else {
                        this.nextElementSibling.classList.remove('floating-label-active');
                    }
                });
            });
        });
    </script>
</body>
</html>




















<div class="w-full mx-auto px-[2%]">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Old Books</h2>
        <a href="booksets1.php?bookType=old" class="text-orange-600 font-semibold hover:underline flex items-center group">
            View All
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <div class="relative group">
        <!-- Navigation Arrows -->
        <button id="scrollLeft2"
            class="hidden sm:block absolute z-10 left-0 top-1/2 -translate-y-1/2 bg-white border border-gray-200 rounded-full shadow-lg p-2 hover:bg-orange-50 hover:border-orange-200 transition-all opacity-0 group-hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <div id="bookScroll2" class="flex space-x-6 overflow-x-auto scroll-smooth px-2 pb-6 -mx-2 hide-scrollbar">
            <?php while ($book = $booksQuery->fetch_assoc()):
                $bookId = $book['id'];
                $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                $isWishlisted = ($checkWishlist->num_rows > 0);

                // Discount calculation
                $mrp = floatval($book['mrp']);
                $sell_price = floatval($book['sell_price']);
                $percentage = ($mrp > 0 && is_numeric($sell_price)) ? (($mrp - $sell_price) / $mrp * 100) : 0;

                // Posted time
                $postedTime = isset($book['post_date']) ? getPostedTime($book['post_date']) : 'Unknown';
            ?>
            <div class="bg-white p-4 rounded-xl shadow-sm hover:shadow-md border border-gray-100 w-48 sm:w-56 min-w-[12rem] sm:min-w-[14rem] relative transition-all duration-300 hover:-translate-y-1 group/card">
                
                <!-- Discount Badge -->
                <div class="absolute left-3 top-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white px-2 py-1 text-xs font-bold rounded-md shadow-md z-10">
                    <?= round($percentage); ?>% OFF
                </div>

                <!-- Wishlist Button -->
                <form method="POST" action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>" class="absolute top-3 right-3 z-10" onclick="event.stopPropagation();">
                    <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                    <button type="submit" class="cursor-pointer group/wishlist" name="toggle_wishlist" aria-label="<?= $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                             fill="<?= $isWishlisted ? 'red' : 'none'; ?>" 
                             stroke="<?= $isWishlisted ? 'red' : 'gray'; ?>" 
                             stroke-width="1.5" 
                             class="size-5 sm:size-6 transition-all duration-200 group-hover/wishlist:stroke-red-500 group-hover/wishlist:scale-110">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </button>
                </form>

                <!-- Book Click Redirect -->
                <a href="view.php?book_id=<?= $bookId; ?>" class="block h-full">
                    <div class="flex justify-center mb-3">
                        <div class="relative w-32 h-44 sm:w-40 sm:h-56 overflow-hidden rounded-lg shadow-sm group-hover/card:shadow-md transition-shadow">
                            <img src="assets/images/<?= $book['img1']; ?>" alt="<?= htmlspecialchars($book['book_name']); ?>" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover/card:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                        </div>
                    </div>

                    <!-- Book Info -->
                    <div class="px-1">
                        <h2 class="text-sm sm:text-base font-bold text-gray-800 line-clamp-2 leading-tight mb-1"><?= $book['book_name']; ?></h2>
                        <p class="text-gray-600 text-xs sm:text-sm font-medium mb-2">
                            <?= $book['book_author']; ?>
                            <span class="text-xs text-orange-500 ml-1">• <?= $book['book_category']; ?></span>
                        </p>

                        <!-- Price -->
                        <div class="flex items-center space-x-2 mb-1">
                            <p class="text-gray-400 line-through text-xs">₹<?= $book['mrp']; ?></p>
                            <p class="text-orange-600 font-bold text-base sm:text-lg">₹<?= $book['sell_price']; ?></p>
                        </div>

                        <!-- Rating and Posted Time -->
                        <div class="flex justify-between items-center mt-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="text-xs text-gray-500 ml-1">4.5</span>
                            </div>
                            <p class="text-xs text-gray-400"><?= $postedTime; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php endwhile; ?>
        </div>

        <!-- Right Arrow -->
        <button id="scrollRight2"
            class="hidden sm:block absolute z-10 right-0 top-1/2 -translate-y-1/2 bg-white border border-gray-200 rounded-full shadow-lg p-2 hover:bg-orange-50 hover:border-orange-200 transition-all opacity-0 group-hover:opacity-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>

<style>
    .hide-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none;  /* Chrome, Safari, Opera */
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

<script>
    // Carousel navigation
    document.getElementById('scrollLeft2').addEventListener('click', () => {
        document.getElementById('bookScroll2').scrollBy({ left: -200, behavior: 'smooth' });
    });
    
    document.getElementById('scrollRight2').addEventListener('click', () => {
        document.getElementById('bookScroll2').scrollBy({ left: 200, behavior: 'smooth' });
    });
</script>









































<?php
include_once "config/connect.php";

// Ensure the user is logged in
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}

$userId = $user ? $user['user_id'] : null;

// Fetch books
$booksQuery = $connect->query("SELECT * FROM books WHERE version='new' order by id DESC");
?>

<section class="mt-12 py-8 bg-gradient-to-b from-white to-[#f8faf7]">
    <div class="w-full px-4 md:px-8 lg:px-12 mx-auto max-w-7xl">

        <!-- Header with decorative elements -->
        <div class="flex justify-between items-center mb-8 relative">
            <div class="flex items-center">
                <div class="w-2 h-8 bg-[#3D8D7A] mr-3 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800 relative">
                    <span class="relative z-10">New Arrivals</span>
                    <span class="absolute -bottom-1 left-0 w-1/2 h-1 bg-[#3D8D7A] bg-opacity-30 rounded-full z-0"></span>
                </h2>
            </div>
            <a href="booksets1.php?bookType=new" class="flex items-center text-[#3D8D7A] font-semibold hover:text-[#2a6455] transition group">
                View All
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        <!-- Carousel Container -->
        <div class="relative group">

            <!-- Navigation Arrows -->
            <button id="scrollLeft" class="carousel-nav left-0 opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>

            <button id="scrollRight" class="carousel-nav right-0 opacity-0 group-hover:opacity-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <!-- Scrollable Book Cards -->
            <div id="bookScroll" class="flex space-x-6 overflow-x-auto scroll-smooth pb-8 -mx-4 px-4">
                <?php while ($book = $booksQuery->fetch_assoc()):
                    $bookId = $book['id'];
                    $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                    $isWishlisted = ($checkWishlist->num_rows > 0);
                    
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $percentage = ($mrp > 0 && is_numeric($sell_price)) ? round(($mrp - $sell_price) / $mrp * 100) : 0;
                    
                    $email = $_SESSION['user'] ?? null;
                    $cartItems = [];
                    if ($email) {
                        $callCartItem = mysqli_query($connect, "SELECT item_id FROM cart WHERE email='$email' AND direct_buy=0");
                        while ($item = mysqli_fetch_assoc($callCartItem)) {
                            $cartItems[] = $item['item_id'];
                        }
                    }
                    $isInCart = in_array($book['id'], $cartItems);
                ?>

                <!-- Book Card -->
                <div class="bg-white p-4 rounded-xl shadow-lg border border-gray-100 min-w-[180px] sm:min-w-[220px] flex-none transition-all duration-300 hover:shadow-xl hover:-translate-y-1 relative group/card">
                    <!-- Discount Ribbon -->
                    <?php if ($percentage > 0): ?>
                    <div class="absolute -top-2 -right-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg z-10">
                        <?= $percentage ?>% OFF
                    </div>
                    <?php endif; ?>

                    <!-- Wishlist Button -->
                    <form method="POST" action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>" 
                          class="absolute top-3 right-3 z-10" onclick="event.stopPropagation();">
                        <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                        <button type="submit" name="toggle_wishlist" class="p-1.5 bg-white bg-opacity-80 rounded-full shadow-md hover:scale-110 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
                                 fill="<?= $isWishlisted ? 'red' : 'none'; ?>" 
                                 stroke="red" stroke-width="1.5" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </form>

                    <!-- Book Cover -->
                    <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                        <div class="relative h-48 sm:h-56 w-full overflow-hidden rounded-lg bg-gray-100 flex items-center justify-center">
                            <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover" 
                                 class="h-full object-contain transition duration-300 group-hover/card:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                        </div>

                        <!-- Book Info -->
                        <div class="mt-4">
                            <h3 class="font-bold text-gray-800 text-sm sm:text-base line-clamp-2 leading-tight">
                                <?= $book['book_name']; ?>
                            </h3>
                            <p class="text-gray-600 text-xs sm:text-sm mt-1 truncate">
                                <?= $book['book_author']; ?>
                            </p>
                            
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center space-x-2">
                                    <?php if ($mrp > $sell_price): ?>
                                    <span class="text-gray-400 text-xs line-through">₹<?= $mrp; ?></span>
                                    <?php endif; ?>
                                    <span class="text-[#3D8D7A] font-bold text-sm sm:text-base">₹<?= $sell_price; ?></span>
                                </div>
                                <span class="text-xs px-2 py-1 bg-gray-100 rounded-full"><?= $book['book_category']; ?></span>
                            </div>
                        </div>
                    </a>

                    <!-- Add to Cart Button -->
                    <div class="mt-4 pt-3 border-t border-gray-100">
                        <button onclick="<?= $isInCart ? "window.location.href='cart.php'" : "addToCart(" . $book['id'] . ")"; ?>"
                                class="w-full flex items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-sm font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                            
                            <?php if ($isInCart): ?>
                                <!-- Tick Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>In Cart</span>
                            <?php else: ?>
                                <!-- Cart Icon with animation -->
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 absolute -top-1 -right-1 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" />
                                    </svg>
                                </div>
                                <span>Add to Cart</span>
                            <?php endif; ?>
                        </button>
                    </div>
                </div>

                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<style>
    .carousel-nav {
        @apply absolute top-1/2 -translate-y-1/2 z-10 bg-white p-2 rounded-full shadow-lg hover:bg-gray-100 transition-all duration-300;
        @apply hidden md:flex items-center justify-center w-10 h-10;
    }
    
    #bookScroll::-webkit-scrollbar {
        height: 6px;
    }
    
    #bookScroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #bookScroll::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    #bookScroll::-webkit-scrollbar-thumb:hover {
        background: #a1a1a1;
    }
</style>

<script>
    // Scroll functionality
    const scrollContainer = document.getElementById("bookScroll");
    const leftButton = document.getElementById("scrollLeft");
    const rightButton = document.getElementById("scrollRight");
    
    // Calculate scroll amount based on card width
    const scrollAmount = () => {
        const card = scrollContainer.querySelector('div:first-child');
        return card ? card.offsetWidth + 24 : 300; // 24px for gap
    };
    
    leftButton.onclick = () => {
        scrollContainer.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
    };
    
    rightButton.onclick = () => {
        scrollContainer.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
    };
    
    // Show/hide arrows based on scroll position
    const checkScroll = () => {
        leftButton.style.display = scrollContainer.scrollLeft > 0 ? 'flex' : 'none';
        rightButton.style.display = scrollContainer.scrollLeft < scrollContainer.scrollWidth - scrollContainer.clientWidth ? 'flex' : 'none';
    };
    
    scrollContainer.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);
    document.addEventListener('DOMContentLoaded', checkScroll);
    
    // Add to cart function
    function addToCart(bookId) {
        fetch(`cart.php?add_book=${bookId}`)
            .then(response => response.text())
            .then(data => {
                // Refresh the button state
                window.location.reload();
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
            });
    }
</script>











wishlist pages


<?php include_once "config/connect.php";
// Check if user is logged in
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
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                } else if (result.isDenied) {
                    window.location.href = '$previousPage';
                }
            });

            setTimeout(() => {
                window.location.href = '$previousPage';
            }, 5000);
        });
    </script>";

    exit();
}
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;

// Handle wishlist toggle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggleWishlist'])) {
    if (!$userId) {
        redirect("login.php");
        exit;
    }

    $bookId = intval($_POST['wishlistId']);

    // Check if book exists in wishlist
    $query = "SELECT 1 FROM wishlist WHERE user_id = $userId AND book_id = $bookId";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) > 0) {
        // Remove from wishlist
        $deleteQuery = "DELETE FROM wishlist WHERE user_id = $userId AND book_id = $bookId";
        mysqli_query($connect, $deleteQuery);
        $_SESSION['message'] = "Book removed from wishlist";
    } else {
        // Add to wishlist
        $insertQuery = "INSERT INTO wishlist (user_id, book_id) VALUES ($userId, $bookId)";
        mysqli_query($connect, $insertQuery);
        $_SESSION['message'] = "Book added to wishlist";
    }

    redirect("wishlist.php");
    exit;
}

// Fetch wishlist items
$booksResult = [];
$countWishlist = 0;

if ($userId) {
    $query = "SELECT books.* FROM wishlist JOIN books ON books.id = wishlist.book_id WHERE wishlist.user_id = $userId";
    $booksResult = mysqli_query($connect, $query);

    $countQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id = $userId";
    $countResult = mysqli_query($connect, $countQuery);
    $countWishlist = mysqli_fetch_assoc($countResult)['count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist | Book Haven</title>
    <link href="./src/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .book-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .heart-btn {
            transition: all 0.3s ease;
        }
        .heart-btn:hover {
            transform: scale(1.2);
        }
        .empty-wishlist {
            background-image: url('https://cdn.dribbble.com/users/5107895/screenshots/14532312/media/a7e6c2e9333d0989e3a54c95dd8321d7.jpg');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 400px;
        }
        .discount-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(135deg, #ff6b6b, #ff8e8e);
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .price-tag {
            background: linear-gradient(135deg, #3D8D7A, #2F6D5E);
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>

<body class="bg-gradient-to-b from-[#FBFFE4] to-[#e8f5d8] min-h-screen">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>

    <main class="container mx-auto px-4 py-8">
        <!-- Wishlist Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div class="flex items-center mb-4 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-[#3D8D7A] to-[#2F6D5E]">
                        My Wishlist
                    </span>
                </h1>
                <span class="ml-3 px-3 py-1 bg-[#3D8D7A] text-white rounded-full text-sm font-semibold animate-bounce">
                    <?= $countWishlist ?> item<?= $countWishlist != 1 ? 's' : '' ?>
                </span>
            </div>
            
            <?php if ($countWishlist > 0): ?>
            <div class="flex space-x-2">
                <button class="px-4 py-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white rounded-lg flex items-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export List
                </button>
                <button class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Clear All
                </button>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($countWishlist == 0): ?>
            <!-- Empty Wishlist State -->
            <div class="empty-wishlist flex flex-col items-center justify-center text-center p-8 rounded-xl bg-white shadow-lg mt-10">
                <div class="max-w-md">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Your Wishlist is Feeling Lonely</h2>
                    <p class="text-gray-600 mb-6">Looks like you haven't added any books to your wishlist yet. Start exploring our collection and save your favorites!</p>
                    <a href="index.php" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-[#3D8D7A] to-[#2F6D5E] text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Books
                    </a>
                </div>
            </div>
        <?php else: ?>
            <!-- Wishlist Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php while ($book = mysqli_fetch_assoc($booksResult)): ?>
                    <?php
                    $bookId = $book['id'];
                    $mrp = floatval($book['mrp']);
                    $sell_price = floatval($book['sell_price']);
                    $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                    ?>
                    <div class="book-card bg-white rounded-xl overflow-hidden relative group">
                        <!-- Discount Badge -->
                        <?php if ($discount > 0): ?>
                            <span class="discount-badge"><?= $discount ?>% OFF</span>
                        <?php endif; ?>
                        
                        <!-- Heart Button -->
                        <form method="POST" action="wishlist.php" class="absolute top-3 right-3 z-10">
                            <input type="hidden" name="wishlistId" value="<?= $bookId ?>">
                            <button type="submit" name="toggleWishlist" class="heart-btn bg-white p-2 rounded-full shadow-md">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="red" class="w-6 h-6">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                            </button>
                        </form>
                        
                        <!-- Book Image -->
                        <a href="view.php?book_id=<?= $bookId ?>" class="block">
                            <div class="h-64 overflow-hidden flex items-center justify-center p-4 bg-gray-50">
                                <img src="assets/images/<?= $book['img1'] ?>" alt="<?= htmlspecialchars($book['book_name']) ?>" 
                                    class="h-full object-contain transition duration-300 group-hover:scale-105">
                            </div>
                            
                            <!-- Book Details -->
                            <div class="p-4">
                                <h3 class="font-bold text-gray-800 mb-1 truncate"><?= $book['book_name'] ?></h3>
                                <p class="text-sm text-gray-600 mb-2"><?= $book['book_author'] ?></p>
                                
                                <div class="flex items-center justify-between mt-3">
                                    <div>
                                        <?php if ($mrp > $sell_price): ?>
                                            <span class="text-xs text-gray-500 line-through mr-2">₹<?= $mrp ?></span>
                                        <?php endif; ?>
                                        <span class="price-tag font-bold">₹<?= $sell_price ?></span>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-gray-100 rounded-full"><?= ucfirst($book['version']) ?></span>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Action Buttons -->
                        <div class="px-4 pb-4">
                            <?php if ($book['version'] == "new"): ?>
                                <a href="cart.php?add_book_to_wishlist=<?= $book['id'] ?>" class="block w-full">
                                    <button class="w-full flex items-center justify-center gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white py-2 px-4 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        Add to Cart
                                    </button>
                                </a>
                            <?php else: ?>
                                <a href="chatboard.php?book_id=<?= $book['id'] ?>" class="block w-full">
                                    <button class="w-full flex items-center justify-center gap-2 bg-[#3D8D7A] hover:bg-[#2a6455] text-white py-2 px-4 rounded-lg transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                        </svg>
                                        Chat Seller
                                    </button>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
            
            <!-- Wishlist Summary -->
            <div class="mt-10 bg-white rounded-xl shadow-md p-6 max-w-3xl mx-auto">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Wishlist Summary</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-[#3D8D7A]"><?= $countWishlist ?></div>
                        <div class="text-sm text-gray-600">Total Items</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-[#3D8D7A]"><?= $countWishlist ?></div>
                        <div class="text-sm text-gray-600">New Books</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-[#3D8D7A]">0</div>
                        <div class="text-sm text-gray-600">Used Books</div>
                    </div>
                </div>
                <button class="mt-6 w-full bg-gradient-to-r from-[#3D8D7A] to-[#2F6D5E] text-white py-3 px-4 rounded-lg font-medium hover:shadow-lg transition">
                    Move All to Cart
                </button>
            </div>
        <?php endif; ?>
    </main>

    <?php include_once "includes/footer2.php"; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        // Animation for empty wishlist illustration
        document.addEventListener('DOMContentLoaded', function() {
            const emptyWishlist = document.querySelector('.empty-wishlist');
            if (emptyWishlist) {
                emptyWishlist.style.backgroundPositionY = '0px';
                let position = 0;
                setInterval(() => {
                    position = (position + 1) % 20;
                    emptyWishlist.style.backgroundPositionY = position + 'px';
                }, 100);
            }
        });
    </script>
</body>

</html>













 <div class="block  group/cart">
                            <div class="mt-3  sm:mt-4 border-t border-gray-200 pt-2 sm:pt-3">
                                <button
                                    class="w-full flex cursor-pointer items-center justify-center gap-2 <?= $isInCart ? 'bg-green-600 hover:bg-green-700' : 'bg-[#3D8D7A] hover:bg-[#2a6455]' ?> text-white text-xs sm:text-sm font-medium py-2 px-2 rounded-lg shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-[1.02] active:scale-95"
                                    onclick="<?= $isInCart ? "window.location.href='cart.php'" : "addToCart(" . $book['id'] . ")"; ?>">

                                    <!-- Icon -->
                                    <div class="relative">
                                        <?php if ($isInCart): ?>
                                            <!-- Tick Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                            </svg>
                                        <?php else: ?>
                                            <!-- Cart Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-5 h-5 text-white group-hover/cart:-translate-y-1 transition-transform"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4L7 13zM7 13a1 1 0 100 2 1 1 0 000-2zM17 13a1 1 0 100 2 1 1 0 000-2z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9.5l1.5 1.5 3-3" />
                                            </svg>
                                        <?php endif; ?>
                                    </div>

                                    <span class=""><?= $isInCart ? 'Go to Cart' : 'Add to Cart'; ?></span>

                                    <?php if (!$isInCart): ?>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4 opacity-0 group-hover/cart:opacity-100 transition-opacity duration-200"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    <?php endif; ?>
                                </button>

                            </div>
                        </div>







####Ankur add_bookset_details.php
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
            <a href="../index.php" class="text-white text-2xl">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>


    <div class="max-w-3xl mx-auto bg-white p-6 shadow-lg rounded-lg mt-20">


        <form action="../actions/sellBook_action.php" method="post" enctype="multipart/form-data">
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
            <div class="mb-6 bg-white p-6 rounded-lg shadow-sm">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-6">Profile Details</h2>

                <!-- Name and Contact -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="relative">
                        <input type="text" value="<?= htmlspecialchars($user['name']); ?>" name="name"
                            class="input-box border border-gray-300 rounded-lg w-full p-3 px-4 focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent"
                            id="name">
                        <label for="name" class="floating-label">Full Name</label>
                    </div>
                    <div class="relative">
                        <input type="text" value="<?= htmlspecialchars($user['contact']); ?>" name="contact"
                            class="input-box border border-gray-300 rounded-lg w-full p-3 px-4 focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent"
                            id="contact">
                        <label for="contact" class="floating-label">Contact Number</label>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Address Details</h3>
                    <?php 
                        $callAdd = $connect->query("select * from user_address where email='$user_email'");
                        $add = $callAdd->fetch_array();
                    if ($callAdd->num_rows > 0): ?>
                        <div class="relative">
                            <textarea name="address" rows="3" id="address"
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4 focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent"
                                readonly><?= htmlspecialchars($add['landmark'] . ", " . $add['address'] . ", " . $add['locality'] . ", " . $add['city'] . ", " . $add['state'] . ", " . $add['pincode']); ?>
                    </textarea>
                            <label for="address" class="floating-label">Your Address</label>
                        </div>
                    <?php else: ?>
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 text-yellow-500">
                                    <i class="fas fa-exclamation-circle text-xl"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        No address found. Please add your address to continue.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="toggleAddressForm()"
                            class="w-full md:w-auto px-6 py-2 bg-[var(--primary)] hover:bg-[#2e7a68] text-white rounded-lg font-medium transition-colors flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i> Add Address Now
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Hidden Address Form (Initially) -->
                <div id="addressForm" class="hidden bg-gray-50 p-4 rounded-lg mb-6">
                    <h4 class="text-lg font-medium text-gray-800 mb-4">Add New Address</h4>
                    <div id="newAddressForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="relative">
                            <input type="text" name="landmark" placeholder=" "
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4">
                            <label class="floating-label">Landmark</label>
                        </div>
                        <div class="relative">
                            <input type="text" name="address" placeholder=" "
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4">
                            <label class="floating-label">Street Address</label>
                        </div>
                        <div class="relative">
                            <input type="text" name="locality" placeholder=" "
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4">
                            <label class="floating-label">Locality</label>
                        </div>
                        <div class="relative">
                            <input type="text" name="city" placeholder=" "
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4">
                            <label class="floating-label">City</label>
                        </div>
                        <div class="relative">
                            <input type="text" name="state" placeholder=" "
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4">
                            <label class="floating-label">State</label>
                        </div>
                        <div class="relative">
                            <input type="text" name="pincode" placeholder=" "
                                class="input-box border border-gray-300 rounded-lg w-full p-3 px-4">
                            <label class="floating-label">Pincode</label>
                        </div>
                        <!-- <div class="md:col-span-2 flex justify-end gap-3 mt-2">
                            <button type="button" onclick="toggleAddressForm()"
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-[var(--primary)] hover:bg-[#2e7a68] text-white rounded-lg font-medium transition-colors" name="add_address">
                                Save Address
                            </button>
                        </div> -->
                    </div>
                    <?php
                      
                    ?>
                </div>

                <!-- Location Section -->
                <div class="relative">
                    <input type="text" placeholder=" "
                        class="input-box border border-gray-300 rounded-lg w-full p-3 px-4 pr-12" id="location"
                        readonly>
                    <label for="location" class="floating-label">Your Location</label>
                    <button type="button" onclick="getLocation()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-blue-500 hover:text-blue-700">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </button>
                </div>

                <!-- Hidden Latitude/Longitude Inputs -->
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
            </div>

            <script>
                // Toggle address form visibility
                function toggleAddressForm() {
                    const form = document.getElementById('addressForm');
                    form.classList.toggle('hidden');
                }

                // Handle form submission (you'll need to implement AJAX or form action)
                document.getElementById('newAddressForm').addEventListener('submit', function (e) {
                    e.preventDefault();
                    // Add your form submission logic here
                    alert('Address saved!'); // Replace with actual save functionality
                    toggleAddressForm();
                });

                // Geolocation function (unchanged from your original)
                function getLocation() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function (position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            document.getElementById('location').value = `Lat: ${lat}, Lng: ${lng}`;
                            document.getElementById('latitude').value = lat;
                            document.getElementById('longitude').value = lng;
                        }, function (error) {
                            alert("Location access denied or unavailable.");
                        });
                    } else {
                        alert("Geolocation is not supported by this browser.");
                    }
                }
            </script>

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
                    name="submit_book">
                    Post Book
                </button>
            </div>
        </form>

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