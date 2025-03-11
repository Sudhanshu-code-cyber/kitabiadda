<?php
include_once "config/connect.php";
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user['user_id'];
$booksQuery = $connect->query("select * from wishlist join books on books.id=wishlist.book_id where user_id='$userId'");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
    <?php include_once "includes/header.php" ?>
    <?php include_once "includes/subheader.php" ?>
    <div class="mt-30 p-10 bg-gray-300">

    <?php
    while ($item = $booksQuery->fetch_array()):
        ?>
            <div class="border mt-5 p-5 flex gap-10 bg-blue-200">
                <img src="images/<?= $item['img1']; ?>" class="w-22 h-22" alt="">
                <div>
                    <h1><?= $item['book_name']; ?></h1>
                    <p><?= $item['book_author']; ?></p>
                </div>
            </div>
    <?php endwhile; ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
</body>

</html>