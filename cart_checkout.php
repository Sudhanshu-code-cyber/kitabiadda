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
                <!-- <form action="" method="post"> -->
                <div class="w-full bg-white p-4 shadow-sm rounded-sm flex items-center justify-between">
                    <!-- Left Section -->
                    <div class="flex items-center space-x-3">
                        <span class="bg-[#3D8D7A] text-white px-2 py-1 text-xs font-semibold rounded">1</span>
                        <span class="text-gray-700 font-semibold text-sm">LOGIN</span>
                        <svg class="w-4 h-4 text-blue-700" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9 16.17l-3.88-3.88a1 1 0 011.41-1.41L9 13.34l7.47-7.47a1 1 0 111.41 1.41l-8.18 8.18a1 1 0 01-1.41 0z"
                                clip-rule="evenodd" />
                        </svg>
                        <div class="flex flex-col">
                            <?php
                            $call_user = mysqli_query($connect, "SELECT * FROM users where email='$email'");
                            $userDetail = mysqli_fetch_assoc($call_user);
                            ?>
                            <span class="font-bold text-gray-900 text-sm"><?= $userDetail['name'] ?></span>
                            <span class="text-gray-600 text-xs"><?= $userDetail['contact'] ?></span>
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
                    <div class="bg-[#205781] text-white font-semibold p-3 rounded-sm flex items-center space-x-2">
                        <span class="bg-[#3D8D7A] px-2 py-1 text-xs rounded">2</span>
                        <span>DELIVERY ADDRESS</span>
                    </div>

                    <!-- Address List -->
                    <div class="divide-y divide-gray-200">
                        <!-- Address Item 1 -->
                        <?php
                        $callAdd = mysqli_query($connect, "SELECT * FROM user_address WHERE email='$email'");
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
                                <h1>not address found , please add address <a href="add_address.php"
                                        class="inline-block px-4  bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">+
                                        Add Address</a></h1>


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
                        <span class="ml-2">Edit address</span>
                    </button>

                    <div id="addressForm" class="hidden bg-white p-6 mt-4 rounded-lg shadow-md">
                        <button id="useLocationBtn" class="bg-blue-500 text-white px-4 py-2 rounded-sm">Use my
                            current
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
                    $update_add = mysqli_query($connect, "UPDATE user_address SET email='$email',name='$name', mobile='$mobile', pincode='$pincode', locality='$locality', address='$address', city='$city', state='$state', landmark='$landmark', home_work='$home_work',alternate_phone='$alternate_phone' where email='$email' ");

                    if ($update_add) {
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
                    <div class="bg-[#205781] text-white font-semibold p-3 rounded-sm flex items-center space-x-2">
                        <span class="bg-[#3D8D7A] px-2 py-1 text-xs rounded">3</span>
                        <span>ORDER SUMMERY</span>
                    </div>

                    <!-- Order Item -->
                    <?php
                    $email = $_SESSION['user'];
                    $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id where cart.email='$email'");
                    while ($cartItem = mysqli_fetch_assoc($callCartItem)) { ?>
                        <div class="flex items-center p-6 border-b">
                            <!-- Product Image -->
                            <img src="images/<?= $cartItem['img1'] ?>" alt="Product Image"
                                class="w-20 h-20 object-cover rounded-md">

                            <div class="ml-4 flex-grow">
                                <h2 class="font-semibold text-lg"><?= $cartItem['book_name'] ?></h2>
                                <p class="text-gray-700 text-sm">
                                    Author: <span class="font-medium"><?= $cartItem['book_author'] ?></span>

                                </p>

                                <div class="flex items-center mt-1">
                                    <span class="text-gray-500 line-through text-sm">₹<?= $cartItem['mrp'] ?></span>
                                    <span class="text-black font-bold text-lg ml-2">₹<?= $cartItem['sell_price'] ?></span>
                                    <span
                                        class="text-green-600 text-sm ml-2"><?= round(((($cartItem['mrp'] - $cartItem['sell_price']) / $cartItem['mrp']) * 100)) ?>%
                                        Off</span>
                                </div>


                            </div>

                            <div class="text-right">
                                <div class="flex items-center mt-2">
                                    <a href="?minus_book=<?= $cartItem['id'] ?>" class="border px-3 py-1 text-xl">−</a>
                                    <span class="px-4"> <?= $cartItem['qty'] ?> </span>
                                    <a href="?add_book=<?= $cartItem['id'] ?>" class="border px-3 py-1 text-xl">+</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>



                <!-- paymenttttttttttttttttttttttttttt   pageeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee -->
                <div class="bg-white shadow-sm rounded-sm w-full border mt-4">
                    <div class="bg-[#205781] text-white font-semibold p-3 rounded-sm flex items-center space-x-2">
                        <span class="bg-[#3D8D7A] px-2 py-1 text-xs rounded">4</span>
                        <span>PAYMENT PROCESS</span>
                    </div>
                    <form action="" method="post">
                        <!-- Payment Methods -->
                        <div class="p-6">
                            <!-- UPI Section -->
                            <div id="clickDiv"
                                class="border rounded-sm p-4 mb-3 hover:bg-blue-50 cursor-pointer transition-all">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment" value="upi"
                                        class="w-5 h-5 border-2 border-blue-600 rounded-full flex items-center justify-center peer-checked:bg-blue-600">
                                    <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/1/15/Google_Pay_Logo_%282020%29.svg"
                                    alt="GPay" class="h-6"> -->
                                    <span class="font-semibold">UPI</span>
                                </label>
                                <div class="ml-7 mt-2 text-sm text-gray-600">
                                    <p class="font-semibold">Choose an option</p>
                                    <label class="block mt-1"><input type="radio" name="upi_option"> PhonePe</label>
                                    <label class="block mt-1"><input type="radio" name="upi_option"> Your UPI ID</label>
                                    <p class="text-xs text-gray-500 mt-1">Pay by any UPI app</p>
                                </div>
                            </div>

                            <!-- Wallets -->
                            <div id="clickDiv"
                                class="border rounded-sm p-4 mb-3 hover:bg-blue-50 cursor-pointer transition-all">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment" value="wallet"
                                        class="w-5 h-5 border-2 border-blue-600 rounded-full flex items-center justify-center peer-checked:bg-blue-600">
                                    <!-- <img src="https://images.app.goo.gl/aKhhFRPcsNXL6uTF9"
                                    alt="Paytm" class="h-6"> -->
                                    <span class="font-semibold">Wallets</span>
                                </label>
                            </div>

                            <!-- Cards -->
                            <div id="clickDiv"
                                class="border rounded-sm p-4 mb-3 hover:bg-blue-50 cursor-pointer transition-all">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment" value="card"
                                        class="w-5 h-5 border-2 border-blue-600 rounded-full flex items-center justify-center peer-checked:bg-blue-600">
                                    <span class="font-semibold">Credit / Debit / ATM Card</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">Add and secure cards as per RBI guidelines</p>
                            </div>

                            <!-- Cash on Delivery -->
                            <div id="clickDiv"
                                class="border rounded-sm p-4 mb-3 hover:bg-blue-50 cursor-pointer transition-all">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="payment" value="cod"
                                        class="w-5 h-5 border-2 border-blue-600 rounded-full flex items-center justify-center peer-checked:bg-blue-600">
                                    <span class="font-semibold">Cash on Delivery</span>
                                </label>
                                <!-- <span class="text-gray-400 text-xs">Not applicable</span> -->
                            </div>

                            <!-- Add Gift Card -->
                            <div id="clickDiv"
                                class="border rounded-sm p-4 mb-3 hover:bg-blue-50 cursor-pointer transition-all">
                                <button class="flex items-center space-x-2 text-blue-600 font-semibold">
                                    <span class="text-xl">+</span>
                                    <span>Add Gift Card</span>
                                </button>
                            </div>
                        </div>

                </div>
                <!-- paymenttttttttttttttttttttttttttt   pageeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee -->

                <div class="flex justify-between items-center bg-white p-4 border shadow-sm rounded-sm mt-3">
                    <!-- Email Confirmation Message -->
                    <p class="text-gray-700 text-sm">
                        Order confirmation email will be sent to
                        <span class="font-bold"><?= $email ?></span>
                    </p>

                    <!-- Continue Button -->

                    <button name="order_submit"
                        class="bg-orange-500 text-white font-semibold px-6 py-2 rounded-sm shadow hover:bg-orange-600">
                        CONTINUE
                    </button>
                    </form>
                </div>

            </div>
            <?php
            $totleMrp = 0;
            $totleSellPrice = 0;
            $callCartItem = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id where cart.email='$email'");
            while ($price = mysqli_fetch_array($callCartItem)) {
                $totleMrp += $price['qty'] * $price['mrp'];
                $totleSellPrice += $price['qty'] * $price['sell_price'];
            }
            ?>
            <div class="w-full md:w-1/3 bg-white p-6 shadow-lg rounded-lg h-fit sticky top-16">
                <h2 class="text-xl font-bold mb-4">Price Details</h2>
                <div class="space-y-3 text-gray-700">
                    <p class="flex justify-between"><span>Price</span> <span>₹<?= $totleMrp ?></span></p>
                    <p class="flex justify-between"><span>Discount</span> <span class="text-green-700">-
                            ₹<?= $totleMrp - $totleSellPrice ?></span></p>
                    <p class="flex justify-between"><span>Delivery</span> <span class="text-green-700">Free</span></p>
                    <p class="flex justify-between"><span>Secured Packaging Fee</span> <span
                            class="text-green-700">Free</span></p>
                    <hr>
                    <p class="flex justify-between text-lg font-semibold"><span>Total</span>
                        <span>₹<?= $totleSellPrice ?></span>
                    </p>
                    <p class="flex text-green-700 justify-between"><span>You will save
                            ₹<?= $totleMrp - $totleSellPrice ?> on this order</span></p>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>
<?php
include_once "includes/footer2.php";
?>
<?php
if (isset($_GET['add_book'])) {
    $item_id = $_GET['add_book'];
    $email = $_SESSION['user'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart where item_id='$item_id' AND email='$email'");
    $noItemInCart = mysqli_num_rows($itemInCart);
    if ($noItemInCart) {
        $updateQty = mysqli_query($connect, "UPDATE cart SET qty = qty + 1 where item_id='$item_id' AND email='$email'");
    } else {
        $insert_cart = mysqli_query($connect, "INSERT INTO cart (email,item_id) VALUE ('$email','$item_id')");
    }

    echo "<script>window.location.href='cart_checkout.php';</script>";

}


if (isset($_GET['minus_book'])) {
    $item_id = $_GET['minus_book'];
    $email = $_SESSION['user'];
    $itemInCart = mysqli_query($connect, "SELECT * FROM cart where item_id='$item_id' AND email='$email'");
    $itemData = mysqli_fetch_assoc($itemInCart);
    if ($itemData) {
        if ($itemData['qty'] > 1) {
            $updateQty = mysqli_query($connect, "UPDATE cart SET qty = qty - 1 WHERE item_id='$item_id' AND email='$email'");
        } else {
            $deleteItem = mysqli_query($connect, "DELETE FROM cart WHERE item_id='$item_id' AND email='$email'");
        }
    } else {
        echo "Item not found in cart!";
    }

    echo "<script>window.location.href='cart_checkout.php';</script>";

}

?>


<!-- submit all orders item , address, and more  -->

<?php
if (isset($_POST['order_submit']) && $_POST['payment'] == 'cod') {
    $payment_type = $_POST['payment'];

    // $address_id = $_SESSION['address_id']; // Uncomment करें अगर जरूरत हो
    $insertOrder = mysqli_query($connect, "INSERT INTO orders (email, total_amount, order_from, payment_type) 
     VALUES ('$email', '$totleSellPrice', 'cart', '$payment_type')");

    if ($insertOrder) {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "✅ Order Confirmed!",
                text: "Thank you for your order.\\nTotal Amount: ₹' . $totleSellPrice . '",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "index.php"; // Redirect to home page
            });
        </script>
        ';
    } else {
        echo "❌ Error: " . mysqli_error($connect);
    }
}

?>
<?php
if (isset($_POST['order_submit']) && $_POST['payment'] == 'cod') {
    $email = $_SESSION['user'];

    $insertOrder = mysqli_query($connect, "DELETE FROM cart WHERE email='$email'");

    
}

?>