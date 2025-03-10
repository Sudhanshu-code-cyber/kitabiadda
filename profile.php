<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
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
        <div class="w-1/4 bg-[#B3D8A8] px-6 pt-14 flex flex-col items-center">
            <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" alt="Profile Picture"
                class="w-24 h-24 rounded-full border border-gray-700">
            <h1 class="mt-4 text-xl font-semibold"><?= $user['name']; ?></h1>
            <p class="text-gray-800 text-sm"><?= $user['email']; ?></p>

            <div class="mt-6 w-full">
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('edit_details')">Edit Details</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('products')">My Products</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-2 font-semibold cursor-pointer"
                    onclick="showSection('order')">My Orders</button>
                <button class="w-full text-left px-4 py-2 bg-[#FBFFE4] rounded-lg mb-6 font-semibold cursor-pointer"
                    onclick="showSection('settings')">Settings</button>
                <a href="logout.php"
                    class="text-left px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition">Logout</a>
            </div>
        </div>

        <div class="flex-1 p-6">
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
                <div class="flex flex-col gap-2 justify-center items-center mt-[10%]">
                    <h2 class="text-2xl text-slate-400 font-bold">You haven't listed anything yet</h2>
                    <p class="font-semibold text-slate-700">Let go of what you don't use anymore</p>
                    <a href="sell/sell.php" class="bg-[#3D8D7A] rounded px-3 py-2 text-white font-semibold">Start
                        Selling</a>
                </div>
            </div>
            <div id="order" class="content-section hidden">
                <h2 class="text-2xl font-semibold mb-4">My Orders</h2>
                <div class="flex flex-col gap-2 justify-center items-center mt-[10%]">
                    <h2 class="text-2xl text-slate-400 font-bold">Order Not Available</h2>
                    <a href="index.php" class="bg-[#3D8D7A] rounded text-sm px-2 py-1 text-white font-semibold">Make
                        Your 1st Order Now</a>
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