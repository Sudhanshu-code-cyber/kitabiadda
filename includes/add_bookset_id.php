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
        <h2 class="text-2xl md:text-3xl font-bold text-[#3D8D7A] mb-6 text-center">Add Book Set</h2>

        <form method="POST" action="" class="space-y-4">

            <!-- Set Title -->
            <!-- <div>
                <label class="block text-gray-700 font-medium mb-1">Set Title</label>
                <input type="text" name="set_title" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="e.g. NEET Preparation Set">
            </div> -->
            <div>
                <label for="options" class="block text-gray-700 font-medium mb-1">Choose Book Set <a
                        href="add_bookset.php"
                        class="inline-block bg-[#3D8D7A] text-white px-2 py-1 rounded-sm text-center hover:bg-[#355850] text-sm">+ bookset
                    </a></label>
                <select id="options" name="bookset_id"
                    class="w-full  px-3 py-2 border rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="" disabled selected>Select an option</option>
                    <?php
                    $call_bookset = mysqli_query($connect, "SELECT * FROM bookset where  seller_id='$userId'");
                    while ($user_bookset = mysqli_fetch_array($call_bookset)) { ?>
                        <option value='<?= $user_bookset['id'] ?>'>
                            <?= $user_bookset['set_title'] ?> | ₹<?= $user_bookset['price'] ?>
                        </option>
                    <?php } ?>
                    <!-- <option value="option1">Option 1</option>
                    <option value="option2">Option 2</option> -->
                </select>
            </div>

            <!-- Description -->
            <!-- <div>
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="Set Description..."></textarea>
            </div> -->

            <!-- Price -->
            <!-- <div>
                <label class="block text-gray-700 font-medium mb-1">Set Price (INR)</label>
                <input type="number" name="price" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400"
                    placeholder="e.g. 999">
            </div> -->

            <!-- Select Books -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Select Books (max 7)</label>
                <div id="book-select-container" class="space-y-4">
                    <div class="flex flex-col">
                        <!-- <label class="mb-1 text-sm font-medium text-gray-700">Select Book</label> -->
                        <select name="book_id[]" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-800">
                            <?php
                            $call_books = mysqli_query($connect, "SELECT * FROM books where version='old' AND seller_id='$userId'");
                            while ($user_books = mysqli_fetch_array($call_books)) { ?>
                                <option value='<?= $user_books['id'] ?>'>
                                    <?= $user_books['book_name'] ?> | <?= $user_books['book_author'] ?> |
                                    ₹<?= $user_books['sell_price'] ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Add Book Button -->
                <button type="button" onclick="addSelect()"
                    class="mt-3 px-2 py-1 bg-[#3D8D7A] text-white rounded-sm text-sm hover:bg-[#355850] transition">
                    + Add Another Book
                </button>

            </div>

            <!-- Submit Button -->
            <div class="text-center pt-4">
                <button type="submit" name="submit"
                    class="bg-[#3D8D7A] text-white px-6 py-2 rounded-lg hover:bg-[#355f55] transition-all duration-200">Create
                    Set</button>
            </div>
        </form>
    </div>

    <script>
        function addSelect() {
            const container = document.getElementById('book-select-container');
            const currentCount = container.children.length;
            if (currentCount >= 7) {
                alert("Maximum 7 books allowed");
                return;
            }
            const select = container.children[0].cloneNode(true);
            container.appendChild(select);
        }

    </script>

</body>

</html>

<?php
if (isset($_POST['submit'])) {

    $bookset_id = $_POST['bookset_id'];

    $book_ids = $_POST['book_id']; // this is now an array

    foreach ($book_ids as $book_id) {
        $insert_bookset = mysqli_query($connect, "
            INSERT INTO bookset_id (bookset_id,seller_id, books_id)
            VALUES ('$bookset_id', '$userId', '$book_id')
        ");
    }

    if ($insert_bookset) {
        echo "Book set created successfully!";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>