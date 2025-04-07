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