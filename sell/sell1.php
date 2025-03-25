<?php
include "../config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-6 bg-gray-100">

    <div class="max-w-lg mx-auto bg-white shadow-md rounded-md">
        <h2 class="text-lg font-bold p-4">CHOOSE A CATEGORY</h2>
        <ul class="divide-y divide-gray-200">
            <!-- Category Item -->
            <?php
                        $callingCat = mysqli_query($connect, "SELECT * FROM category");
                        while ($cat = mysqli_fetch_assoc($callingCat)) {
                           
                        

                        ?>
            <li class="cursor-pointer">
                <div onclick="toggleSubmenu('mobiles-submenu')" class="flex justify-between items-center p-4 hover:bg-gray-200">
                    <span class="flex items-center">
                        <?= $cat['cat_title'];?>
                    </span>
                    <span>▶</span>
                </div>
                <!-- Submenu -->
                <ul id="mobiles-submenu" class="hidden bg-gray-100">
                    <li class="p-3 pl-8 hover:bg-gray-200"><?= $cat['book_sub_category'];?></li>
                    
                </ul>
            </li>
            <?php } ?>
            <!-- Another Category -->
          
        </ul>
    </div>

    <script>
        function toggleSubmenu(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>

</body>
</html>
