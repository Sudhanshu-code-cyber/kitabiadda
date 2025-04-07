<div id="edit_details" class="content-section flex flex-col gap-5">
    <h2 class="text-2xl font-semibold">Edit Details</h2>
    <div class="w-full max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
        <!-- Profile Picture Upload -->
        <div class="flex justify-center mb-8">
            <form action="actions/upload_dp.php" method="post" enctype="multipart/form-data" class="text-center">
                <label for="dp_image" class="cursor-pointer group">
                    <input type="file" onchange="this.form.submit()" name="dp_image" id="dp_image" hidden>
                    <img src="<?php
                    if($user['dp'] == ""){
                        echo "assets/defaultUser.webp";
                    } elseif (substr($user['dp'], 0, 5) === 'https'){
                        echo $user['dp'] ;
                    } else {
                        echo "assets/user_dp/" . $user['dp'] ;
                    }
                    ?>"
                        alt="Profile Picture"
                        class="h-32 w-32 border-4 border-blue-100 rounded-full object-cover group-hover:border-blue-200 transition-all">
                    <div class="mt-2 text-sm text-blue-600 opacity-0 group-hover:opacity-100 transition-opacity">Click
                        to change</div>
                </label>
            </form>
        </div>

        <!-- Profile Form -->
        <form action="" method="post" class="space-y-6">
            <div class="space-y-4 md:space-y-0 md:grid md:grid-cols-2 gap-5">
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" value="<?= $user['name']; ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="text" name="email" readonly value="<?= $user['email']; ?>"
                        class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                </div>
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700">Contact</label>
                    <input type="text" name="contact" value="<?= $user['contact']; ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="space-y-1">
                    <label class="block font-medium text-gray-700">Gender</label>
                    <select name="gender"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="<?= $user['gender']; ?>" selected><?= ucfirst($user['gender']); ?></option>
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <?php if ($user['google_id'] == ''): ?>
                <div class="pt-4 border-t border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Change Password</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block font-medium text-gray-700">Old Password</label>
                            <input type="password" name="old_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="block font-medium text-gray-700">New Password</label>
                            <input type="password" name="new_password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="pt-2">
                <button name="save_change" type="submit"
                    class="w-full px-6 py-2 bg-[#3D8D7A] text-white font-semibold rounded-md shadow transition-colors duration-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

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