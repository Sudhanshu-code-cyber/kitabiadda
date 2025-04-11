<div id="address" class="content-section hidden">
    <h2 class="text-2xl font-semibold mb-4">My Address</h2>
    <div class="flex flex-col gap-2 justify-center mt-[10%]">
        <?php
        $callAdd = $connect->query("select * from user_address where email='$userEmail'");
        $address = $callAdd->fetch_assoc();

        if ($callAdd->num_rows > 0):
            ?>
            <div class="bg-white shadow-lg border-gray-200 p-5">
                <div class="flex justify-between">

                    <?php if (!empty($address)): ?>
                        <div class='flex gap-5'>
                            <h1 class='text-lg font-semibold'><?= $address['name']; ?></h1>
                            <h1 class='border border-green-500 font-semibold text-green-500 rounded-xl px-1'>
                                <?= $address['home_work']; ?>
                            </h1>
                        </div>
                    <?php else: ?>
                        <p class='text-red-500'>No address found</p>
                    <?php endif; ?>



                    <div class="flex gap-2">
                        <a data-modal-target="editAddress" data-modal-toggle="editAddress"
                            class="p-1 bg-yellow-500 cursor-pointer text-white rounded font-semibold"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </a>
                        <div id="editAddress" tabindex="-1" aria-hidden="true"
                            class="fixed top-0 left-0 right-0 z-50 hidden w-full h-screen p-4 overflow-x-hidden overflow-y-auto flex items-center justify-center">

                            <div
                                class="relative rounded-lg shadow-md max-w-xl w-[80vw] p-8 flex items-center justify-center">
                                <div class="absolute inset-0 bg-[#FBFFE4] rounded-lg"></div>

                                <button type="button" class="absolute top-3 right-3 text-white z-10"
                                    data-modal-hide="editAddress">
                                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                                    </svg>
                                </button>
                                <div class="relative bg-[#FBFFE4] z-10 w-full">
                                    <?php
                                    $call_address = $connect->query("select * from user_address where email='$userEmail'");
                                    $address = $call_address->fetch_assoc();
                                    ?>
                                    <form action="" method="POST" class="mt-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <input type="text" id="name" name="name" placeholder="Full Name"
                                                class="border p-2 rounded" value="<?= $address['name'] ?? ''; ?>">
                                            <input type="text" id="mobile" name="mobile" placeholder="Mobile"
                                                class="border p-2 rounded" value="<?= $address['mobile'] ?? ''; ?>">
                                            <input type="text" id="pincode" name="pincode" placeholder="Pincode"
                                                class="border p-2 rounded" value="<?= $address['pincode'] ?? ''; ?>">
                                            <input type="text" id="locality" name="locality" placeholder="Locality"
                                                class="border p-2 rounded" value="<?= $address['locality'] ?? ''; ?>">
                                            <input id="address" name="address" placeholder="Address"
                                                class="border p-2 rounded col-span-2 bg-white text-left"
                                                value="<?= $address['address'] ?? ''; ?>">
                                            <input type="text" id="city" name="city" placeholder="City"
                                                class="border p-2  rounded" value="<?= $address['city'] ?? ''; ?>">
                                            <!-- <label for="state">State</label> -->
                                            <select id="state" name="state" class="border p-2 rounded">
                                                <option value="<?= $address['state'] ?? ''; ?>">
                                                    <?= $address['state'] ?? ''; ?>
                                                </option>
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


                                            <input type="text" id="landmark" name="landmark" placeholder="Landmark"
                                                class="border p-2 rounded" value="<?= $address['landmark'] ?? ''; ?>">

                                            <input type="text" id="alternatePhone" name="alternate_phone"
                                                placeholder="Alternate_phone" class="border p-2 rounded"
                                                value="<?= $address['alternate_phone'] ?? ''; ?>">
                                        </div>

                                        <div class="mt-4">
                                            <label><input type="radio" name="home_work" value="Home" required>
                                                Home (All day
                                                delivery)</label>
                                            <label class="ml-4"><input type="radio" name="home_work" value="Work" required>
                                                Work
                                                (Delivery
                                                between 10 AM - 5 PM)</label>
                                        </div>

                                        <div class="mt-6 flex justify-between">
                                            <button type="submit" name="add_address"
                                                class="bg-[#3D8D7A] w-full text-white px-6 py-2 rounded">SAVE
                                                ADDRESS</button>
                                        </div>
                                    </form>
                                    <?php
                                    if (isset($_POST['add_address'])) {

                                        $name = $_POST['name'];

                                        $mobile = $_POST['mobile'];
                                        $pincode = $_POST['pincode'];
                                        $locality = $_POST['locality'];
                                        $address = $_POST['address'];
                                        $city = $_POST['city'];
                                        $state = $_POST['state'];
                                        $landmark = $_POST['landmark'];
                                        $alternate_phone = $_POST['alternate_phone'];
                                        $home_work = $_POST['home_work'];

                                        $addAddress = $connect->query("UPDATE user_address set name='$name', mobile='$mobile', pincode='$pincode', locality='$locality', address='$address', city='$city', state='$state', landmark='$landmark', alternate_phone='$alternate_phone', home_work='$home_work'");
                                        if ($addAddress) {
                                            echo '
                                                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                                            <script>
                                                               Swal.fire({
                                                                title: "Updated Address",
                                                                icon: "success",
                                                                draggable: true
                                                                }).then(() => {
                                                                    window.location.href = "profile.php"; // Redirect to home page
                                                                })
                                                            </script>
                                                            ';

                                        } else {
                                            message("Not Updated Address");
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <a href="?delete_add=<?= $address['id']; ?>"
                            class="border rounded font-semibold bg-red-500 text-white p-1"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </a>
                    </div>
                </div>
                <?php
                if (!empty($address)):
                    ?>
                    <p class="text-sm font-semibold mt-2 text-gray-600">
                        <?= $address['address']; ?>,<?= $address['city']; ?>,<?= $address['state']; ?>,<?= $address['landmark']; ?>,<?= $address['pincode']; ?>
                    </p>
                    <p class="text-sm font-semibold text-gray-600"><?= $address['mobile']; ?> ,
                        <?= $address['alternate_phone']; ?>
                    </p>
                <?php else: ?>
                    <p class='text-red-500'>No address found</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
                <div class="flex flex-col items-center text-center">
                    <!-- Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-[#3D8D7A] mb-3" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>

                    <!-- Title -->
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Address not available</h2>
                    <p class="text-gray-600 mb-4">Please add your address to continue</p>

                    <!-- Button -->
                    <button data-modal-target="addAddress" data-modal-toggle="addAddress"
                        class="px-6 py-2 bg-[#3D8D7A] hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-[#3D8D7A] focus:ring-opacity-50">
                        Add Address
                    </button>
                </div>
            </div>
            <div id="addAddress" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full h-screen p-4 overflow-x-hidden overflow-y-auto flex items-center justify-center">

                <div class="relative rounded-lg shadow-md max-w-xl w-[80vw] p-8 flex items-center justify-center">
                    <div class="absolute inset-0 bg-[#FBFFE4] rounded-lg"></div>

                    <button type="button" class="absolute top-3 right-3 text-white z-10" data-modal-hide="addAddress">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 14 14">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                        </svg>
                    </button>
                    <div class="relative bg-[#FBFFE4] z-10 w-full">
                        <form action="" method="POST" class="mt-4">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" id="name" name="fname" placeholder="Full Name"
                                    class="border p-2 rounded">
                                <input type="text" id="mobile" name="contact" placeholder="Mobile"
                                    class="border p-2 rounded">
                                <input type="text" id="pincode" name="pin" placeholder="Pincode" class="border p-2 rounded">
                                <input type="text" id="locality" name="local" placeholder="Locality"
                                    class="border p-2 rounded">
                                <input id="address" name="add" placeholder="Address"
                                    class="border p-2 rounded col-span-2 bg-white text-left">
                                <input type="text" id="city" name="citys" placeholder="City" class="border p-2  rounded">
                                <select id="state" name="stt" class="border p-2 rounded">
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


                                <input type="text" id="land" name="land" placeholder="Landmark" class="border p-2 rounded">

                                <input type="text" id="altphone" name="alt_phone" placeholder="Alternate_phone"
                                    class="border p-2 rounded">
                            </div>

                            <div class="mt-4">
                                <label><input type="radio" name="homework" value="Home" required>
                                    Home (All day
                                    delivery)</label>
                                <label class="ml-4"><input type="radio" name="homework" value="Work" required>
                                    Work
                                    (Delivery
                                    between 10 AM - 5 PM)</label>
                            </div>

                            <div class="mt-6 flex justify-between">
                                <button type="submit" name="add_add"
                                    class="bg-[#3D8D7A] w-full text-white px-6 py-2 rounded">SAVE
                                    ADDRESS</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['add_add'])) {
                            $name = $_POST['fname'];
                            $mobile = $_POST['contact'];
                            $pincode = $_POST['pin'];
                            $locality = $_POST['local'];
                            $address = $_POST['add'];
                            $city = $_POST['citys'];
                            $state = $_POST['stt'];
                            $landmark = $_POST['land'];
                            $alternate_phone = $_POST['alt_phone'];
                            $home_work = $_POST['homework'];

                            $addAdd = $connect->query("INSERT INTO user_address (name, mobile, pincode, locality, address, city, state, landmark, alternate_phone, home_work, email, user_id) 
                            VALUES ('$name', '$mobile', '$pincode', '$locality', '$address', '$city', '$state', '$landmark', '$alternate_phone', '$home_work', '$userEmail','$userId')");

                            if ($addAdd) {
                                echo '
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                                    <script>
                                        Swal.fire({
                                        title: "Address Insetred",
                                        icon: "success",
                                        draggable: true
                                        }).then(() => {
                                        window.location.href = "profile.php"; // Redirect to home page
                                        })
                                    </script>
                                    ';

                            } else {
                                message("Not Updated Address");
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php
if (isset($_GET['delete_add'])) {
    $add_id = $_GET['delete_add'];

    $query = $connect->query("DELETE from user_address where id='$add_id' and email='$userEmail'");
    if ($query) {
        message("deleted Successfully");
        redirect("profile.php");
    } else {
        message("not deleted");
    }

}

?>