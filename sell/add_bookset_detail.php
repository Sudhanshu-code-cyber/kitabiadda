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
                allowOutsideClick: false, // बाहर क्लिक करने से बंद न हो
                allowEscapeKey: false, // ESC दबाने से बंद न हो
                customClass: {
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    confirmButton: 'my-swal-confirm-btn',
                    denyButton: 'my-swal-deny-btn'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../login.php'; // Login Page पर जाएं
                } else if (result.isDenied) {
                    window.location.href = '$previousPage'; // पिछली पेज पर जाएं
                }
            });

            // ⏳ 5 सेकंड बाद Auto Redirect पिछले पेज पर
            setTimeout(() => {
                window.location.href = '$previousPage';
            }, 5000);
        });
    </script>";

    exit();
}

if (isset($_SESSION['user'])) {
    $user = getUser();
}
$user_email = $user['email'];

if ($_GET['subcat']) {
    $id_subcat = $_GET['subcat'];
    $call_cat = mysqli_query($connect, "SELECT * FROM sub_category  WHERE id='$id_subcat'");
    $cat_name = mysqli_fetch_array($call_cat);

}
$cat_id = $cat_name['cat_id'];
$call_cat = mysqli_query($connect, "SELECT * FROM category where id='$cat_id'");
$cat = mysqli_fetch_assoc($call_cat);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= PROJECT_NAME ?> Sell Your BookSet</title>
    <link href="../src/output.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <style>
        :root {
            --primary: #3D8D7A;
            --secondary: #B3D8A8;
            --accent: #FBFFE4;
            --light: #A3D1C6;
        }

        .book-card {
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .add-book-btn {
            transition: all 0.2s ease;
        }

        .add-book-btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="bg-[var(--accent)] min-h-screen">
    <nav class="bg-[var(--primary)] text-white p-4 fixed w-full top-0 z-50 shadow-md">
        <div class="max-w-5xl mx-auto flex justify-between items-center">
            <a href="javascript:history.back()" class="text-white text-2xl">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-xl font-bold text-center flex-1">SELL YOUR BOOKSETS</h1>
            <a href="../index.php" class="text-white text-2xl">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 pt-24 mt-20 pb-10">
        <!-- Category Info -->
        <div class="text-center flex mb-8">
            <div class="flex justify-center gap-4">
                <span class="bg-[var(--secondary)] px-3 py-1 rounded-full text-sm">
                    <?= htmlspecialchars($cat['cat_title']) ?>
                </span>
                <span class="bg-[var(--light)] px-3 py-1 rounded-full text-sm">
                    <?= htmlspecialchars($cat_name['sub_cat']) ?>
                </span>
            </div>
            <button type="button" id="addBookBtn"
                class="add-book-btn bg-[var(--primary)] text-white px-6 py-2 rounded-lg hover:bg-[#2e7a68] transition-colors flex items-center gap-2 mx-auto">
                <i class="fas fa-plus"></i> Add Another Book
            </button>
        </div>

        <!-- Books Container -->
        <div id="booksContainer" class="flex flex-wrap bg-[var(--secondary)] p-5 gap-5 justify-center md:justify-start">
            <form id="booksetForm" method="POST" action="../action/bookset_action.php" enctype="multipart/form-data">
                <div class="books-container">
                    <div id="bookTemplate"
                        class="book-card bg-white p-5 border border-gray-200 rounded-lg w-full max-w-xs hidden">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-semibold text-lg">Book <span class="book-number">1</span></h3>
                            <button type="button" class="text-red-500 remove-book" title="Remove this book">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Book Name</label>
                                <input type="text" name="books[0][name]" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                                <input type="text" name="books[0][author]" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">MRP</label>
                                <input type="number" name="books[0][mrp]" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                                <input type="file" name="books[0][image]" class="w-full border rounded p-1"
                                    accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="book-card bg-white p-5 border border-gray-200 rounded-lg w-full max-w-xs">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-semibold text-lg">Book 1</h3>
                            <button type="button" class="text-red-500 remove-book" title="Remove this book">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Book Name</label>
                                <input type="text" name="books[0][name]" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                                <input type="text" name="books[0][author]" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">MRP</label>
                                <input type="number" name="books[0][mrp]" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                                <input type="file" name="books[0][image]" class="w-full border rounded p-1"
                                    accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Submit Button -->
                <div class="mt-10 text-center">
                    <button type="submit" name="submit"
                        class="bg-[var(--primary)] text-white px-8 py-3 rounded-lg font-bold hover:bg-[#2e7a68] transition-colors">
                        Submit Bookset
                    </button>
                </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const booksContainer = document.querySelector('.books-container');
                const addBookBtn = document.getElementById('addBookBtn');
                let nextBookId = 2; // Start from 2 since first book is 1

                // Add new book function
                addBookBtn.addEventListener('click', function () {
                    const newBookId = nextBookId++;

                    const newBook = document.createElement('div');
                    newBook.className = 'book-card bg-white p-5 border border-gray-200 rounded-lg w-full max-w-xs';
                    newBook.dataset.bookId = newBookId;

                    // THIS IS WHERE YOUR CODE GOES:
                    newBook.innerHTML = `
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-lg">Book ${newBookId}</h3>
                <button type="button" class="text-red-500 remove-book" title="Remove this book">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Book Name</label>
                    <input type="text" name="books[${newBookId}][name]" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" name="books[${newBookId}][author]" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">MRP</label>
                    <input type="number" name="books[${newBookId}][mrp]" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cover Image</label>
                    <input type="file" name="books[${newBookId}][image]" class="w-full border rounded p-1" accept="image/*">
                </div>
            </div>
        `;

                    // Insert before the add button container
                    booksContainer.insertBefore(newBook, addBookBtn.parentElement);

                    // Smooth scroll to new book
                    newBook.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                });

                // Remove book functionality
                booksContainer.addEventListener('click', function (e) {
                    if (e.target.closest('.remove-book')) {
                        const bookCard = e.target.closest('.book-card');
                        if (booksContainer.querySelectorAll('.book-card').length > 1) {
                            bookCard.remove();
                        } else {
                            alert("You must have at least one book in the set.");
                        }
                    }
                });
            });
        </script>
</body>

</html>