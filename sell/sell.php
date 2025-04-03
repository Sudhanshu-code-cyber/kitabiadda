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
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../login.php';
                } else if (result.isDenied) {
                    window.location.href = '$previousPage';
                }
            });

            setTimeout(() => {
                window.location.href = '$previousPage';
            }, 5000);
        });
    </script>";

    exit();
}
?>
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
        
        /* Mobile-first responsive styles */
        @media (max-width: 767px) {
            .category-sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .content-panel {
                width: 100%;
                padding: 1rem;
            }
            
            .nav-title {
                font-size: 1rem;
            }
            
            .category-item {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }
        
        /* Tablet styles */
        @media (min-width: 768px) and (max-width: 1023px) {
            .category-sidebar {
                width: 35%;
            }
            
            .content-panel {
                width: 65%;
            }
        }
        
        /* Desktop styles */
        @media (min-width: 1024px) {
            .category-sidebar {
                width: 30%;
            }
            
            .content-panel {
                width: 70%;
            }
        }
    </style>
</head>

<body class="bg-[var(--background)] font-sans">
    <!-- Responsive Navbar -->
    <nav class="bg-[var(--primary)] text-white p-4 fixed w-full top-0 z-50 shadow-md">
        <div class="container mx-auto flex justify-between items-center px-4">
            <a href="javascript:history.back()" class="text-white text-xl md:text-2xl">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-lg md:text-xl font-bold text-center flex-1 px-2 nav-title">SELL YOUR BOOK</h1>
            <a href="../index.php" class="text-white text-xl md:text-2xl">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container mx-auto p-4 md:p-6 mt-16 md:mt-20">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
            <!-- Category Sidebar - Responsive -->
            <div class="category-sidebar bg-[var(--secondary)] p-3 md:p-4">
                <h2 class="text-base md:text-lg font-semibold mb-3 text-gray-800">Categories</h2>
                <hr class="border-gray-300">
                <ul class="divide-y divide-gray-300">
                    <?php
                    $call_cat = mysqli_query($connect, "SELECT * FROM category");
                    while ($cat = mysqli_fetch_array($call_cat)) { ?>
                        <a href="?cat=<?= $cat['id'] ?>">
                            <li class="category-item p-3 md:p-4 hover:bg-[var(--accent)] cursor-pointer transition duration-200 text-gray-800 font-medium text-sm md:text-base">
                                <?= $cat['cat_title'] ?>
                            </li>
                        </a>
                        <hr class="border-gray-300">
                    <?php } ?>
                </ul>
            </div>
            
            <!-- Content Panel - Responsive -->
            <div class="content-panel p-4 md:p-6">
                <h2 class="text-base md:text-lg font-bold text-[var(--primary)] mb-3 md:mb-4">Select a Subcategory</h2>
                
                <!-- Subcategory Panel -->
                <?php if (isset($_GET['cat'])) { ?>
                    <ul class="divide-y divide-gray-200 border border-gray-200 rounded-lg overflow-hidden">
                        <?php
                        $cat_id = $_GET['cat'];
                        $call_subcat = mysqli_query($connect, "SELECT * FROM sub_category WHERE cat_id='$cat_id'");
                        while ($subcat = mysqli_fetch_array($call_subcat)) { ?>
                            <a href="sell_book_detail.php?subcat=<?= $subcat['id'] ?>">
                                <li class="p-3 md:p-4 hover:bg-[var(--accent)] cursor-pointer transition duration-200 font-medium text-gray-700 text-sm md:text-base">
                                    <?= $subcat['sub_cat'] ?>
                                </li>
                            </a>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-book-open text-4xl mb-4 text-[var(--primary)]"></i>
                        <p class="text-sm md:text-base">Please select a category from the left sidebar</p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

   
</body>
</html>