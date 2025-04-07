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
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-[var(--primary)] mb-4">Profile Details</h2>
                <div class="flex flex-1 gap-2 w-full">
                    <div class="relative w-full">
                        <input type="text" placeholder=" " value="<?= $user['name']; ?>" name="name"
                            class="input-box border rounded w-full p-3" id="name">
                        <label for="name" class="floating-label"> </label>
                    </div>
                    <input type="text" placeholder="mobile no." value="<?= $address_row['mobile'] ?? ''; ?>" name="contact"
                        class="input-box border rounded w-full p-3" id="contact">

                </div>


                <div class="relative mt-4">





                    <!-- addresssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss -->
                    <div class="w-full bg-white shadow-sm rounded-sm mt-3">
                        <!-- Header -->
                        <div class="bg-[#3D8D7A] text-white font-semibold p-3 rounded-sm flex items-center space-x-2">
                            <!-- <span class="bg-[#205781] px-2 py-1 text-xs rounded">2</span> -->
                            <span>YOUR ADDRESS</span>
                        </div>

                        <!-- Address List -->
                        <div class="divide-y divide-gray-200">
                            <!-- Address Item 1 -->
                            <?php
                            $callAdd = mysqli_query($connect, "SELECT * FROM user_address WHERE email='$user_email'");
                            $noAdd = mysqli_num_rows($callAdd);

                            $address = mysqli_fetch_assoc($callAdd) ?>
                            <label class="flex items-start p-4 space-x-3 cursor-pointer bg-blue-50">

                                <!-- class="mt-1 w-4 h-4 text-blue-600 bg-black-600 focus:ring-blue-500 border-gray-300"> -->
                                <?php
                                if ($noAdd == 1) { ?>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-semibold"><?= $address['name'] ?></span>
                                            <span
                                                class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded"><?= $address['home_work'] ?></span>
                                            <span class="font-bold text-sm"><?= $address['mobile'] ?></span>
                                        </div>
                                        <p class="text-sm text-gray-600">
                                            <?= $address['address'] ?>,
                                            <?= $address['landmark'] ?>,<?= $address['locality'] ?>
                                            , <?= $address['city'] ?>
                                            District, <?= $address['state'] ?> -
                                            <span class="font-bold"><?= $address['pincode'] ?></span>
                                        </p>
                                    </div>


                                <?php } else { ?>
                                    <h1>not address found , please add address

                                    <?php } ?>


                            </label>


                            <!-- Address Item 2 (Selected) -->

                        </div>
                    </div>


                    <?php
                    // PHP + Tailwind CSS Code for Address Form with Auto-Fill Location
                    ?>

                    <div class="w-full bg-gray-100  shadow-sm rounded-sm">
                        <button id="addAddressBtn" class="text-blue-500 flex items-center p-6">
                            <span class="text-xl font-bold"></span>
                            <span class="ml-2"><?php
                            if ($noAdd == 1) {
                                echo "Edit address";
                            } else {
                                echo "Add Address";
                            }
                            ?></span>
                        </button>

                        <div id="addressForm" class="hidden bg-white p-6 mt-4 rounded-lg shadow-md">
                            <button id="useLocationBtn" class="bg-blue-500 text-white px-4 py-2 rounded-sm">Use my
                                current
                                location</button>

                            <form action="" method="POST" class="mt-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <input type="text" id="name" name="name" placeholder="Name"
                                        class="border p-2 rounded" value="<?php if ($noAdd == 1 && $address['name'] != '') {
                                            echo $address['name'];
                                        } ?>">
                                    <input type="text" id="mobile" name="mobile" placeholder="10-digit mobile number"
                                        class="border p-2 rounded" value="<?php if ($noAdd == 1 && $address['mobile'] != '') {
                                            echo $address['mobile'];
                                        } ?>">
                                    <input type="text" id="pincode" name="pincode" placeholder="Pincode"
                                        class="border p-2 rounded" value="<?php if ($noAdd == 1 && $address['pincode'] != '') {
                                            echo $address['pincode'];
                                        } ?>">
                                    <input type="text" id="locality" name="locality" placeholder="locality"
                                        class="border p-2 rounded" value="<?php if ($noAdd == 1 && $address['locality'] != '') {
                                            echo $address['locality'];
                                        } ?>">
                                    <textarea id="address" name="address" placeholder="Address (Area and Street)"
                                        class="border p-2 rounded col-span-2">
                                    <?php if ($noAdd == 1 && $address['address'] != '') {
                                        echo $address['address'];
                                    } ?>
                                </textarea>
                                    <input type="text" id="city" name="city" placeholder="City/District/Town"
                                        class="border p-2 rounded" value="<?php if ($noAdd == 1) {
                                            echo $address['city'];
                                        } ?>">
                                    <!-- <label for="state">State</label> -->
                                    <select id="state" name="state" class="border p-2 rounded">
                                        <option value="<?php if ($noAdd == 1 && $address['state'] != '') {
                                            echo $address['state'];
                                        } ?>"><?php if ($noAdd == 1 && $address['state'] != '') {
                                             echo $address['state'];
                                         } ?></option>
                                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                        <option value="Assam">Assam</option>
                                        <option value="Bihar">Bihar</option>
                                        <option value="Chhattisgarh">Chhattisgarh</option>
                                        <option value="Goa">Goa</option>
                                        <option value="Gujarat">Gujarat</option>
                                        <option value="Haryana">Haryana</option>
                                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                                        <option value="Jharkhand">Jharkhand</option>
                                        <option value="Karnataka">Karnataka</option>
                                        <option value="Kerala">Kerala</option>
                                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                                        <option value="Maharashtra">Maharashtra</option>
                                        <option value="Manipur">Manipur</option>
                                        <option value="Meghalaya">Meghalaya</option>
                                        <option value="Mizoram">Mizoram</option>
                                        <option value="Nagaland">Nagaland</option>
                                        <option value="Odisha">Odisha</option>
                                        <option value="Punjab">Punjab</option>
                                        <option value="Rajasthan">Rajasthan</option>
                                        <option value="Sikkim">Sikkim</option>
                                        <option value="Tamil Nadu">Tamil Nadu</option>
                                        <option value="Telangana">Telangana</option>
                                        <option value="Tripura">Tripura</option>
                                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                                        <option value="Uttarakhand">Uttarakhand</option>
                                        <option value="West Bengal">West Bengal</option>
                                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                        <option value="Chandigarh">Chandigarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli
                                            and
                                            Daman and Diu</option>
                                        <option value="Lakshadweep">Lakshadweep</option>
                                        <option value="Delhi">Delhi</option>
                                        <option value="Puducherry">Puducherry</option>
                                        <option value="Ladakh">Ladakh</option>
                                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                    </select>


                                    <input type="text" id="landmark" name="landmark" placeholder="Landmark (Optional)"
                                        class="border p-2 rounded" value="<?php if ($noAdd == 1 && $address['landmark'] != '') {
                                            echo $address['landmark'];
                                        } ?>">
                                    <input type="text" id="alternatePhone" name="alternate_phone"
                                        placeholder="Alternate Phone (Optional)" class="border p-2 rounded">
                                </div>

                                <div class="mt-4">
                                    <label><input type="radio" name="home_work" value="Home" required> Home (All day
                                        delivery)</label>
                                    <label class="ml-4"><input type="radio" name="home_work" value="Work" required> Work
                                        (Delivery
                                        between 10 AM - 5 PM)</label>
                                </div>

                                <div class="mt-6 flex justify-between">

                                    <button type="button" id="cancelBtn" class="text-blue-500">CANCEL</button>
                                    <button type="submit" name="add_submit"
                                        class="bg-orange-500 text-white px-6 py-2 rounded">SAVE AND
                                        DELIVER HERE</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    <script>
                        document.getElementById("addAddressBtn").addEventListener("click", function () {
                            document.getElementById("addressForm").classList.toggle("hidden");
                        });

                        document.getElementById("cancelBtn").addEventListener("click", function () {
                            document.getElementById("addressForm").classList.add("hidden");
                        });

                        document.getElementById("useLocationBtn").addEventListener("click", function () {
                            if (navigator.geolocation) {
                                navigator.geolocation.getCurrentPosition(function (position) {
                                    let lat = position.coords.latitude;
                                    let lon = position.coords.longitude;
                                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            document.getElementById("pincode").value = data.address.postcode || "";
                                            document.getElementById("locality").value = data.address.suburb || "";
                                            document.getElementById("city").value = data.address.city || data.address.town || "";
                                            document.getElementById("state").value = data.address.state || "";

                                            // पूरा एड्रेस सही तरीके से जोड़ें
                                            let addressParts = [];
                                            if (data.address.house_number) addressParts.push(data.address.house_number);
                                            if (data.address.road) addressParts.push(data.address.road);
                                            if (data.address.neighbourhood) addressParts.push(data.address.neighbourhood);
                                            if (data.address.suburb) addressParts.push(data.address.suburb);

                                            document.getElementById("address").value = addressParts.join(", ") || "";
                                        });
                                });
                            } else {
                                alert("Geolocation is not supported by this browser.");
                            }
                        });
                    </script>

                    </textarea>
                    <!-- <label for="address" class="floating-label">Address</label> -->
                </div>


                <div class="relative mt-6">
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
                <button type="submit_book"
                    class="bg-[var(--primary)] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#2e7a68] transition-colors w-full sm:w-auto"
                    name="submit">
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