<?php include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$email = $_SESSION['user'];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

</head>

<body class="bg-gray-100">
    <nav class="mt-12">
        <?php include_once "includes/header.php"; ?>
    </nav>

    <div class="container mx-auto p-6 md:p-10">
        <!-- <h1 class="text-[40px] text-green-900 font-bold">Your Cart (456)</h1> -->
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Product List -->
            <div class="md:w-2/3">
                <div class="w-full bg-white p-4 shadow-sm rounded-sm flex items-center justify-between">
                    <!-- Left Section -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 text-xs font-semibold rounded">1</span>
                        <span class="text-gray-700 font-semibold text-sm">LOGIN</span>
                        <svg class="w-4 h-4 text-blue-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 16.17l-3.88-3.88a1 1 0 011.41-1.41L9 13.34l7.47-7.47a1 1 0 111.41 1.41l-8.18 8.18a1 1 0 01-1.41 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="font-bold text-gray-900 text-sm">Ankur Jha</span>
                            <span class="text-gray-600 text-xs">+917763972896</span>
                        </div>

                    </div>
                    <!-- Right Section -->
                    <button
                        class="border border-gray-300 text-blue-600 px-3 py-1 rounded-md text-sm hover:bg-gray-100 transition">
                        CHANGE
                    </button>
                </div>


                <!-- addresssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss -->
                <div class="w-full bg-white shadow-sm rounded-sm mt-3">
                    <!-- Header -->
                    <div class="bg-blue-600 text-white font-semibold p-3 rounded-sm flex items-center space-x-2">
                        <span class="bg-blue-800 px-2 py-1 text-xs rounded">2</span>
                        <span>DELIVERY ADDRESS</span>
                    </div>

                    <!-- Address List -->
                    <div class="divide-y divide-gray-200">
                        <!-- Address Item 1 -->
                         <?php
                            $callAdd = mysqli_query($connect,"SELECT * FROM user_address WHERE email='$email'");
                            while($address = mysqli_fetch_array($callAdd)) { ?>

                        
                        <label class="flex items-start p-4 space-x-3 cursor-pointer bg-blue-50">
                            <input type="radio" name="address"
                                class="mt-1 w-4 h-4 text-blue-600 bg-black-600 focus:ring-blue-500 border-gray-300">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold"><?= $address['name'] ?></span>
                                    <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded"><?= $address['home_work'] ?></span>
                                    <span class="font-bold text-sm"><?= $address['mobile'] ?></span>
                                </div>
                                <p class="text-sm text-gray-600">
                                <?= $address['address'] ?>, <?= $address['landmark'] ?>,<?= $address['locality'] ?> ,  <?= $address['city'] ?>
                                    District, <?= $address['state'] ?> -
                                    <span class="font-bold"><?= $address['pincode'] ?></span>
                                </p>
                            </div>
                        </label>
                        <?php    } ?>

                        <!-- Address Item 2 (Selected) -->

                    </div>
                </div>


                <?php
                // PHP + Tailwind CSS Code for Address Form with Auto-Fill Location
                ?>

                <div class="w-full bg-gray-100  shadow-sm rounded-sm">
                    <button id="addAddressBtn" class="text-blue-500 flex items-center p-6">
                        <span class="text-xl font-bold">+</span>
                        <span class="ml-2">Add a new address</span>
                    </button>

                    <div id="addressForm" class="hidden bg-white p-6 mt-4 rounded-lg shadow-md">
                        <button id="useLocationBtn" class="bg-blue-500 text-white px-4 py-2 rounded-sm">Use my current
                            location</button>

                        <form action="" method="POST" class="mt-4">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" id="name" name="name" placeholder="Name" class="border p-2 rounded">
                                <input type="text" id="mobile" name="mobile" placeholder="10-digit mobile number"
                                    class="border p-2 rounded">
                                <input type="text" id="pincode" name="pincode" placeholder="Pincode"
                                    class="border p-2 rounded">
                                <input type="text" id="locality" name="locality" placeholder="Locality"
                                    class="border p-2 rounded">
                                <textarea id="address" name="address" placeholder="Address (Area and Street)"
                                    class="border p-2 rounded col-span-2"></textarea>
                                <input type="text" id="city" name="city" placeholder="City/District/Town"
                                    class="border p-2 rounded">
                                <!-- <label for="state">State</label> -->
                                <select id="state" name="state" class="border p-2 rounded">
                                    <option value="">Select State</option>
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
                                    <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and
                                        Daman and Diu</option>
                                    <option value="Lakshadweep">Lakshadweep</option>
                                    <option value="Delhi">Delhi</option>
                                    <option value="Puducherry">Puducherry</option>
                                    <option value="Ladakh">Ladakh</option>
                                    <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                </select>


                                <input type="text" id="landmark" name="landmark" placeholder="Landmark (Optional)"
                                    class="border p-2 rounded">
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
                <?php
                if (isset($_POST['add_submit'])) {
                    $name = $_POST['name'];
                    $mobile = $_POST['mobile'];
                    $pincode = $_POST['pincode'];
                    $locality = $_POST['locality'];
                    $address = $_POST['address'];
                    $city = $_POST['city'];
                    $state = $_POST['state'];
                    $alternate_phone = $_POST['alternate_phone'];
                    $landmark = isset($_POST['landmark']) ? $_POST['landmark'] : ''; // Optional field
                    $home_work = isset($_POST['home_work']) ? $_POST['home_work'] : ''; // Optional field
                
                    // Database connection (Make sure $connect is already defined)
                
                    $insert_add = mysqli_query(
                        $connect,
                        "INSERT INTO user_address (email,name, mobile, pincode, locality, address, city, state, landmark, home_work,alternate_phone) 
                            VALUES ('$email','$name', '$mobile', '$pincode', '$locality', '$address', '$city', '$state', '$landmark', '$home_work','$alternate_phone')"
                    );

                    if ($insert_add) {
                        echo "✅ Address added successfully!";
                    } else {
                        echo "❌ Error: " . mysqli_error($connect);
                    }
                }

                ?>

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

                <div class="bg-white shadow-sm rounded-lg w-full border mt-4">
                    <!-- Header -->
                    <div class="bg-blue-600 text-white font-semibold p-3 rounded-sm flex items-center space-x-2">
                        <span class="bg-blue-800 px-2 py-1 text-xs rounded">3</span>
                        <span>ORDER SUMMERY</span>
                    </div>

                    <!-- Order Item -->
                    <div class="flex items-center p-6 border-b">
                        <!-- Product Image -->
                        <img src="https://picsum.photos/80" alt="Product Image"
                            class="w-20 h-20 object-cover rounded-md">

                        <!-- Order Details -->
                        <div class="ml-4 flex-grow">
                            <h2 class="font-semibold text-lg">Motorola Edge 50 Pro 5G with 125W Charger</h2>
                            <!-- <p class="text-gray-600 text-sm">12 GB RAM</p> -->
                            <p class="text-gray-700 text-sm">
                                Seller: <span class="font-medium">GRAHGOODS RETAIL</span>

                            </p>

                            <div class="flex items-center mt-1">
                                <span class="text-gray-500 line-through text-sm">₹41,999</span>
                                <span class="text-black font-bold text-lg ml-2">₹29,999</span>
                                <span class="text-green-600 text-sm ml-2">28% Off</span>
                            </div>

                            <!-- <p class="text-gray-600 text-xs">+ ₹59 Secured Packaging Fee</p> -->

                            <!-- Quantity & Remove -->

                        </div>

                        <!-- Delivery Details -->
                        <div class="text-right">
                            <div class="flex items-center mt-2">
                                <button class="border px-3 py-1 text-xl">−</button>
                                <span class="px-4">1</span>
                                <button class="border px-3 py-1 text-xl">+</button>
                                <!-- <button class="ml-6 text-red-500 font-semibold">REMOVE</button> -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between items-center bg-white p-4 border shadow-sm rounded-sm mt-3">
                    <!-- Email Confirmation Message -->
                    <p class="text-gray-700 text-sm">
                        Order confirmation email will be sent to
                        <span class="font-bold">akj41731@gmail.com</span>
                    </p>

                    <!-- Continue Button -->
                    <button
                        class="bg-orange-500 text-white font-semibold px-6 py-2 rounded-sm shadow hover:bg-orange-600">
                        CONTINUE
                    </button>
                </div>




            </div>

            <!-- Price Details -->


            <div class="w-full md:w-1/3 bg-white p-6 shadow-lg rounded-lg h-fit">
                <h2 class="text-xl font-bold mb-4">Price Details</h2>
                <div class="space-y-3 text-gray-700">
                    <p class="flex justify-between"><span>Price</span> <span>₹</span></p>
                    <p class="flex justify-between "><span>Discount</span> <span class="text-green-700">-
                            ₹34567</span></p>
                    <p class="flex justify-between"><span>Delivery</span> <span class="text-green-700">Free</span></p>
                    <p class="flex justify-between"><span>Secured Packaging Fee
                        </span> <span class="text-green-700">Free</span></p>
                    <hr>
                    <p class="flex justify-between text-lg font-semibold"><span>Total</span>
                        <span>₹3567</span>
                    </p>
                    <p class="flex text-green-700 justify-between"><span>You will save ₹ 4567 on this order
                        </span> </p>
                </div>
                <!-- <button
                    class="w-full bg-orange-500 text-white py-3 mt-4 rounded-lg shadow-md hover:bg-orange-600 transition">PLACE
                    ORDER</button> -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>
<?php
include_once "includes/footer2.php";
?>