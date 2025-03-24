<?php
include_once "config/connect.php";
$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null; // Get logged-in user ID
$userEmail = $user['email'];
$booksQuery = $connect->query("select * from wishlist join books on books.id=wishlist.book_id where user_id='$userId'");

$count = $connect->query("select * from wishlist where user_id='$userId'");
$coutwishlist = mysqli_num_rows($count);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>

    <div class="flex h-screen pt-14">
        <div class="w-1/4 fixed h-screen bg-[#B3D8A8] px-6 pt-14 flex flex-col items-center">
            <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                alt="Profile Picture" class="w-24 h-24 rounded-full border border-gray-700">
            <h1 class="mt-4 text-xl font-semibold"><?= $user['name']; ?></h1>
            <p class="text-gray-800 text-sm"><?= $user['email']; ?></p>

            <div class="mt-6 w-full">
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('edit_details')">Edit Details</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('products')">My Products</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('order')">My Orders</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('wishlist')">Wishlist</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('address')">My Address</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-6 font-semibold cursor-pointer"
                    onclick="showSection('settings')">Settings</button>
                <a href="logout.php"
                    class="text-left px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">Logout</a>
            </div>
        </div>
        <div class="w-3/4 left-2 ml-[25%] flex-1 p-6">
            <div id="edit_details" class="content-section flex flex-col gap-5">
                <h2 class="text-2xl font-semibold">Edit Details</h2>
                <div class="flex justify-center items-center">
                    <form action="actions/upload_dp.php" method="post" enctype="multipart/form-data">
                        <label for="dp_image" class="cursor-pointer">
                            <input type="file" onchange="this.form.submit()" name="dp_image" id="dp_image" hidden>
                            <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>"
                                alt="" class="h-32 w-32  border bg-white rounded-full">
                        </label>
                        <input type="submit" hidden>
                    </form>
                </div>
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="flex flex-col gap-5 justify-center items-center">
                        <div class="grid grid-cols-2 gap-5">
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">Full Name</label>
                                <input type="text" name="name" value="<?= $user['name']; ?>" class="border rounded p-2">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">Email</label>
                                <input type="text" name="email" readonly value="<?= $user['email']; ?>"
                                    class="border rounded p-2">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">Contact</label>
                                <input type="text" name="contact" value="<?= $user['contact']; ?>"
                                    class="border rounded p-2">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">Gender</label>
                                <select name="gender" class="rounded">
                                    <option value="<?= $user['gender']; ?>" selected><?= ucfirst($user['gender']); ?>
                                    </option>
                                    <option value="female">Female</option>
                                    <option value="male">Male</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <h1 class="text-2xl font-semibold text-red-500 underline">Change Password</h1>
                        <div class="grid grid-cols-2 gap-5">
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">Old Password</label>
                                <input type="password" name="old_password" class="border rounded p-2">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="font-semibold">New Password</label>
                                <input type="password" name="new_password" class="border rounded p-2">
                            </div>
                        </div>

                        <button name="save_change"
                            class="py-2 px-4 cursor-pointer bg-blue-600 font-semibold text-center rounded text-white">
                            Save Changes
                        </button>
                    </div>
                </form>

                <?php
                if (isset($_POST['save_change'])) {
                    if (isset($_SESSION['user'])) {
                        $id = $user['user_id'];
                        $name = $_POST['name'];
                        $gender = $_POST['gender'];
                        $contact = $_POST['contact'];
                        $old_password = $_POST['old_password'];
                        $new_password = $_POST['new_password'];
                        // Fetch current password from DB
                        $result = $connect->query("SELECT password FROM users WHERE user_id='$id'");
                        $row = $result->fetch_assoc();

                        if (!empty($new_password)) {
                            if (md5($old_password) == $row['password']) { // Old password matches
                                $newpassword_hash = md5($new_password);
                                $query = "UPDATE users SET name='$name', gender='$gender', contact='$contact', password='$newpassword_hash' WHERE user_id='$id'";

                                if ($connect->query($query) === TRUE) {
                                    echo "<p class='text-green-600'>Profile updated successfully!</p>";
                                } else {
                                    echo "<p class='text-red-600'>Error updating profile: " . $connect->error . "</p>";
                                }
                            } else {
                                message('Please Eneter Your Old Correct Password');
                            }
                        } else {
                            $query = "UPDATE users SET name='$name', gender='$gender', contact='$contact' WHERE user_id='$id'";
                            if ($connect->query($query) === TRUE) {
                                redirect("profile.php");
                            } else {
                                echo "<p class='text-red-600'>Error updating profile: " . $connect->error . "</p>";
                            }
                        }
                    } else {
                        message('User not logged in');
                    }
                }
                ?>
            </div>
            <div id="products" class="content-section hidden">
                <h2 class="text-2xl font-semibold mb-4">My Products</h2>
                <?php
                $calling_myItem = $connect->query("select * from books where seller_id='$userId'");
                if ($calling_myItem->num_rows > 0):
                    while ($myItem = $calling_myItem->fetch_assoc()):
                        ?>
                        <h1><?= $myItem['book_name']; ?></h1>
                    <?php endwhile;
                else:
                    ?>
                    <div class="flex flex-col gap-2 justify-center items-center mt-[10%]">
                        <h2 class="text-2xl text-slate-400 font-bold">You haven't listed anything yet</h2>
                        <p class="font-semibold text-slate-700">Let go of what you don't use anymore</p>
                        <a href="sell/sell.php" class="bg-[#3D8D7A] rounded px-3 py-2 text-white font-semibold">Start
                            Selling</a>
                    </div>
                <?php endif; ?>
            </div>
            <div id="order" class="content-section  hidden">
                <h2 class="text-2xl font-semibold mb-4">My Orders</h2>
                <div class="flex flex-col gap-2 justify-center items-center ">

                    <?php $total_orders = mysqli_query($connect, "SELECT * FROM orders  WHERE email='$userEmail' ORDER BY id DESC ");
                    if ($total_orders->num_rows > 0):
                        while ($orders = mysqli_fetch_array($total_orders)): ?>
                            <div class="w-full shadow-lg rounded-lg bg-white p-5 mb-4">
                                <div class="flex justify-between">
                                    <h3 class="text-lg font-bold text-blue-800">#Order ID: <?= $orders['id'] ?></h3>
                                    <p class="text-sm text-gray-800"><?php $formatted_date = date("d F Y", strtotime($orders['order_time']));
                                    echo $formatted_date . "<br>"; ?></p>
                                </div>
                                <?php
                                $orders_id = $orders['id'];
                                $call_order_item = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id WHERE orders_id='$orders_id'");
                                while ($order_item = mysqli_fetch_array($call_order_item)) { ?>

                                    <div class="flex flex-col gap-4 mt-3">
                                        <div
                                            class="flex items-center justify-between border border-gray-200 p-3 rounded-lg shadow-sm bg-gray-50">
                                            <img src="assets/images/<?= $order_item['img1'] ?>" alt="item_image"
                                                class="h-18 rounded shadow-sm">
                                            <h2 class="ml-3 font-medium truncate"><?= $order_item['book_name'] ?></h2>
                                            <h2 class="ml-3 font-medium ">₹ <?= $order_item['sell_price']; ?></h2>
                                            <div class="flex flex-col gap-1 items-center">
                                                <p class="text-sm font-semibold">🟢 Delivered on <?php $formatted_date = date("d F Y", strtotime($orders['order_time']));
                                                echo $formatted_date . "<br>"; ?></p>
                                                <p class="text-xs">Your item has been delivered</p>
                                                <p class="text-sm text-blue-500">⭐ Rate & Review Product</p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <?php
                        endwhile;
                    else:
                        ?>
                        <h2 class="text-2xl text-slate-400 font-bold">Order Not Available</h2>
                        <a href="index.php" class="bg-[#3D8D7A] rounded text-sm px-2 py-1 text-white font-semibold">
                            Make Your 1st Order Now
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div id="wishlist" class="content-section hidden">
                <h2 class="text-2xl font-semibold mb-4">My Wishlist</h2>
                <div class=" grid grid-cols-3 gap-2  ">
                    <?php
                    while ($book = $booksQuery->fetch_assoc()):
                        // Check if the book is already in the wishlist
                        $bookId = $book['id'];
                        $checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
                        $isWishlisted = ($checkWishlist->num_rows > 0);

                        $bookId = $book['id'];
                        $mrp = floatval($book['mrp']);
                        $sell_price = floatval($book['sell_price']);
                        $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                        ?>
                        <div class="bg-white p-4 rounded-lg shadow-lg border border-gray-200 w-64 min-w-[16rem] relative">
                            <!-- Discount Badge (60% Off) -->
                            <div
                                class="absolute left-2 top-2 bg-red-500 text-white px-3 py-1 text-xs font-bold rounded-md shadow-md">
                                <?= $discount; ?>% OFF
                            </div>

                            <!-- Wishlist Heart Icon (Prevents Click from Going to Next Page) -->
                            <form method="POST"
                                action="<?= isset($_SESSION['user']) ? 'actions/wishlistAction.php' : 'login.php'; ?>"
                                class="absolute top-3 right-3" onclick="event.stopPropagation();">
                                <input type="hidden" name="wishlist_id" value="<?= $bookId; ?>">
                                <button type="submit" name="toggle_wishlist">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="<?= $isWishlisted ? 'red' : 'none'; ?>" stroke="red" stroke-width="1.5"
                                        class="size-6 hover:scale-110 transition">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
                            </form>

                            <!-- Book Click Redirect -->
                            <a href="view.php?book_id=<?= $book['id']; ?>" class="block">
                                <div class="flex justify-center hover:scale-105 transition">
                                    <img src="assets/images/<?= $book['img1']; ?>" alt="Book Cover"
                                        class="w-40 h-56 object-cover shadow-md rounded-md">
                                </div>

                                <!-- Book Info -->
                                <div class="mt-4 text-center">
                                    <h2 class="text-lg font-semibold truncate text-[#3D8D7A]"><?= $book['book_name']; ?>
                                    </h2>
                                    <p class="text-gray-500 text-sm font-semibold"><?= $book['book_author']; ?></p>

                                    <!-- Price -->
                                    <div class="flex justify-center items-center space-x-2 mt-1">
                                        <p class="text-gray-500 line-through text-sm">₹<?= $book['mrp']; ?>/-</p>
                                        <p class="text-black font-bold text-lg">₹<?= $book['sell_price']; ?>/-</p>
                                    </div>
                                </div>
                            </a>
                            <!-- Footer (Add to Cart + Rating) -->
                            <a href="cart.php?add_book=<?= $book['id']; ?>">
                                <div class="mt-4 border-t pt-3 flex justify-between items-center">
                                    <button class="text-[#27445D] text-sm font-semibold hover:underline">Add to
                                        cart</button>

                                    <!-- Dynamic Rating -->
                                    <div class="flex">
                                        <?php
                                        $rating = rand(2, 5); // Random Rating for demo
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= floor($rating)) {
                                                echo '<span class="text-orange-500 text-lg">★</span>';
                                            } else {
                                                echo '<span class="text-gray-400 text-lg">★</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </a>
                        </div>

                    <?php endwhile; ?>

                </div>
            </div>
            <div id="address" class="content-section hidden">
                <h2 class="text-2xl font-semibold mb-4">My Address</h2>
                <div class="flex flex-col gap-2 justify-center mt-[10%]">
                    <?php
                    $callAdd = $connect->query("select * from user_address where email='$userEmail'");
                    $address = $callAdd->fetch_assoc();
                    if ($callAdd):
                        ?>
                        <div class="bg-white shadow-lg border-gray-200 p-5">
                            <div class="flex justify-between">
                                <div class="flex gap-5">
                                    <h1 class="text-lg font-semibold"><?= $address['name']; ?></h1>
                                    <h1 class="border border-green-500 font-semibold text-green-500 rounded-xl px-1">
                                        <?= $address['home_work']; ?>
                                    </h1>
                                </div>
                                <div class="flex gap-2">
                                    <a data-modal-target="developerModel" data-modal-toggle="developerModel"
                                        class="p-1 bg-yellow-500 cursor-pointer text-white rounded font-semibold"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>
                                    <div id="developerModel" tabindex="-1" aria-hidden="true"
                                        class="fixed top-0 left-0 right-0 z-50 hidden w-full h-screen p-4 overflow-x-hidden overflow-y-auto flex items-center justify-center">

                                        <div
                                            class="relative rounded-lg shadow-md max-w-xl w-[80vw] p-8 flex items-center justify-center">
                                            <div class="absolute inset-0 bg-white rounded-lg"></div>

                                            <button type="button" class="absolute top-3 right-3 text-white z-10"
                                                data-modal-hide="developerModel">
                                                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor"
                                                    viewBox="0 0 14 14">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                                                </svg>
                                            </button>
                                            <div class="relative bg-white z-10 w-full">
                                                <?php
                                                    $call_address = $connect->query("select * from user_address where email='$userEmail'");
                                                    $address = $call_address->fetch_assoc();
                                                ?>
                                                <form action="" method="POST" class="mt-4">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <input type="text" id="name" name="name"
                                                            class="border p-2 rounded" value="<?= $address['name'];?>">
                                                        <input type="text" id="mobile" name="mobile"
                                                            class="border p-2 rounded"
                                                            value="<?= $address['mobile'];?>">
                                                        <input type="text" id="pincode" name="pincode" 
                                                            class="border p-2 rounded" value="<?= $address['pincode'];?>">
                                                        <input type="text" id="locality" name="locality"
                                                            class="border p-2 rounded" value="<?= $address['locality']; ?>">
                                                        <input id="address" name="address"
                                                            class="border p-2 rounded col-span-2 text-left" value="<?= $address['address'];?>">
                                                        <input type="text" id="city" name="city" class="border p-2 rounded"
                                                            value="<?= $address['city'];?>">
                                                        <!-- <label for="state">State</label> -->
                                                        <select id="state" name="state" class="border p-2 rounded">
                                                        <option value="<?= $address['state'];?>"><?= $address['state'];?></option>
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
                                                            <option value="Andaman and Nicobar Islands">Andaman and
                                                                Nicobar Islands</option>
                                                            <option value="Chandigarh">Chandigarh</option>
                                                            <option value="Dadra and Nagar Haveli and Daman and Diu">
                                                                Dadra and Nagar Haveli
                                                                and
                                                                Daman and Diu</option>
                                                            <option value="Lakshadweep">Lakshadweep</option>
                                                            <option value="Delhi">Delhi</option>
                                                            <option value="Puducherry">Puducherry</option>
                                                            <option value="Ladakh">Ladakh</option>
                                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                                        </select>


                                                        <input type="text" id="landmark" name="landmark" class="border p-2 rounded"
                                                            value="<?= $address['landmark'];?>">
                                                        <input type="text" id="alternatePhone" name="alternate_phone"
                                                            class="border p-2 rounded" value="<?= $address['alternate_phone'];?>">
                                                    </div>

                                                    <div class="mt-4">
                                                        <label><input type="radio" name="home_work" value="Home" required>
                                                            Home (All day
                                                            delivery)</label>
                                                        <label class="ml-4"><input type="radio" name="home_work"
                                                                value="Work" required> Work
                                                            (Delivery
                                                            between 10 AM - 5 PM)</label>
                                                    </div>

                                                    <div class="mt-6 flex justify-between">

                                                        <button type="button" id="cancelBtn"
                                                            class="text-blue-500">CANCEL</button>
                                                        <button type="submit" name="add_submit"
                                                            class="bg-orange-500 text-white px-6 py-2 rounded">SAVE ADDRESS</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#" class="border rounded font-semibold bg-red-500 text-white p-1"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <p class="text-sm font-semibold mt-2 text-gray-600">
                                <?= $address['address']; ?>,<?= $address['city']; ?>,<?= $address['state']; ?>,<?= $address['landmark']; ?>,<?= $address['pincode']; ?>
                            </p>
                            <p class="text-sm font-semibold text-gray-600"><?= $address['mobile']; ?> ,
                                <?= $address['alternate_phone']; ?>
                            </p>
                        </div>
                    <?php else: ?>
                        <h1 class="text-lg font-semibold">Address not available</h1>
                    <?php endif; ?>
                </div>
            </div>

            <div id="settings" class="content-section hidden">
                <h2 class="text-2xl font-semibold mb-4">Settings</h2>
                <p>Update your account settings here.</p>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            document.querySelectorAll('.content-section').forEach(div => div.classList.add('hidden'));
            document.getElementById(section).classList.remove('hidden');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>