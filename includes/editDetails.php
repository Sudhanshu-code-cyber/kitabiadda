<div id="edit_details" class="content-section flex flex-col gap-5">
    <h2 class="text-2xl font-semibold">Edit Details</h2>
    <div class="flex justify-center items-center">
        <form action="actions/upload_dp.php" method="post" enctype="multipart/form-data">
            <label for="dp_image" class="cursor-pointer">
                <input type="file" onchange="this.form.submit()" name="dp_image" id="dp_image" hidden>
                <img src="<?= ($user['dp']) ? "assets/user_dp/" . $user['dp'] : "assets/defaultUser.webp"; ?>" alt=""
                    class="h-32 w-32  border bg-white rounded-full">
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
                    <input type="text" name="email" readonly value="<?= $user['email']; ?>" class="border rounded p-2">
                </div>
                <div class="flex flex-col gap-1">
                    <label class="font-semibold">Contact</label>
                    <input type="text" name="contact" value="<?= $user['contact']; ?>" class="border rounded p-2">
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