<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Your Ad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        :root {
            --primary: #3D8D7A;
            --secondary: #B3D8A8;
            --background: #FBFFE4;
            --accent: #A3D1C6;
        }
    </style>
</head>

<body class="bg-[var(--background)] font-sans">
    <!-- Navbar -->
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

    <div class="max-w-5xl mx-auto p-6 mt-20">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
            <!-- Category Sidebar -->
            <div class="md:w-1/3 border-r bg-[var(--secondary)] p-4">
                <h2 class="text-lg font-semibold mb-3 text-gray-800">Categories</h2>
                <hr>
                <ul class="divide-y">
                    <?php
                    include "../config/connect.php";
                    $call_cat = mysqli_query($connect, "SELECT * FROM category");
                    while ($cat = mysqli_fetch_array($call_cat)) { ?>
                        <a href="?cat=<?= $cat['id'] ?>">
                            <li class="p-4 hover:bg-[var(--accent)] cursor-pointer transition duration-200 text-gray-800 font-medium">
                                <?= $cat['cat_title'] ?>
                            </li>
                        </a>
                        <hr>
                    <?php } ?>
                </ul>
            </div>
            <div class="md:w-2/3 p-6">
            <h2 class="text-lg font-bold text-[var(--primary)] mb-4">Select a Subcategory</h2>
            <!-- Subcategory Panel -->
            <?php if (isset($_GET['cat'])) { ?>
                
                    <ul class="divide-y border rounded-lg overflow-hidden">
                        <?php
                        $cat_id = $_GET['cat'];
                        $call_subcat = mysqli_query($connect, "SELECT * FROM sub_category WHERE cat_id='$cat_id'");
                        while ($subcat = mysqli_fetch_array($call_subcat)) { ?>
                            <a href="sell_book_detail.php?subcat=<?= $subcat['id'] ?>">
                                <li class="p-4 hover:bg-[var(--accent)] cursor-pointer transition duration-200 font-medium text-gray-700">
                                    <?= $subcat['sub_cat'] ?>
                                </li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
