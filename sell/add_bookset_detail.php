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