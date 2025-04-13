<?php include_once "../config/connect.php";

redirectIfNotAuth();

$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;
$userEmail = $user['email'];
$booksQuery = $connect->query("select * from wishlist join books on books.id=wishlist.book_id where user_id='$userId'");
$count = $connect->query("select * from wishlist where user_id='$userId'");
$coutwishlist = mysqli_num_rows($count);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Book Set</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body class="bg-[#FBFFE4] min-h-screen">

    <!-- Navbar -->
    <nav class="bg-[#3D8D7A] text-white p-4 fixed w-full top-0 z-50 shadow-md">
        <div class="max-w-6xl mx-auto flex justify-between items-center px-2 md:px-4">
            <a href="javascript:history.back()" class="text-white text-xl md:text-2xl">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-lg md:text-xl font-semibold text-center flex-1 px-2">SELL YOUR BOOK-SETS</h1>
            <a href="../index.php" class="text-white text-xl md:text-2xl">
                <i class="fas fa-home"></i>
            </a>
        </div>
    </nav>

    <!-- Main Form -->
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md px-4 py-6 mt-24 mb-10 md:p-8">
        <h2 class="text-2xl md:text-3xl font-bold text-[#3D8D7A] mb-6 text-center">Create a Book Set</h2>

        <form method="POST" action="" enctype="multipart/form-data" class="space-y-4">

            <!-- Set Title -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Set Title</label>
                <input type="text" name="set_title" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="e.g. NEET Preparation Set">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="Set Description..." required></textarea>
            </div>

            <!-- Price -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Set Price (INR)</label>
                <input type="number" name="price" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="e.g. 999">
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Upload an Image</h2>

                <input type="file" id="imageInput" name="set_img" accept="image/*" class="block w-full text-sm text-gray-700 
             file:mr-4 file:py-2 file:px-4
             file:rounded-md file:border-0
             file:text-sm file:font-semibold
             file:bg-blue-50 file:text-blue-700
             hover:file:bg-blue-100 mb-4">

                <img id="preview" src="#" alt="Image Preview"
                    class="hidden rounded-lg max-h-60 w-full object-cover border border-gray-300">
            </div>
            <script>
                const imageInput = document.getElementById('imageInput');
                const preview = document.getElementById('preview');

                imageInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();

                        reader.addEventListener('load', function () {
                            preview.src = reader.result;
                            preview.classList.remove('hidden');
                        });

                        reader.readAsDataURL(file);
                    }
                });
            </script>


            <!-- Submit Button -->
            <div class="text-center pt-4">
                <button type="submit" name="submit"
                    class="bg-[#3D8D7A] text-white px-6 py-2 rounded-lg hover:bg-[#355850]  transition-all duration-200">Create
                    Set</button>
            </div>
        </form>
        <?php
        if (isset($_POST['submit'])) {

            $set_title = trim($_POST['set_title']);
            $description = trim($_POST['description']);
            $price = trim($_POST['price']);

            $image = $_FILES['set_img']['name'];
            $tmp_image = $_FILES['set_img']['tmp_name'];

            $errors = [];

            // ✅ Title validation
            if (strlen($set_title) < 5) {
                $errors[] = "Title must be at least 5 characters.";
            }

            // ✅ Description validation
            if (strlen($description) < 5) {
                $errors[] = "Description must be at least 5 characters.";
            }

            // ✅ Price numeric check using preg_match
            if (!preg_match('/^[0-9]+$/', $price)) {
                $errors[] = "Price must contain only numbers.";
            } elseif ($price > 15000) {
                $errors[] = "Price must not exceed ₹15,000.";
            }

            // ✅ Image file validation
            if (empty($image)) {
                $errors[] = "Please upload an image.";
            }

            // ✅ If any error, show
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            } else {
                // ✅ Move file if all is good
                $upload_path = "../assets/images/" . basename($image);
                if (move_uploaded_file($tmp_image, $upload_path)) {
                    echo "<p style='color:green;'>Image uploaded successfully!</p>";
                    // 👇 Here you can write DB insert query
                } else {
                    echo "<p style='color:red;'>Failed to upload image.</p>";
                }
            }
        }
        ?>
    </div>



</body>

</html>