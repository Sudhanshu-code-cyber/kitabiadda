<?php
include_once "config/connect.php";

$user = null;
if (isset($_SESSION['user'])) {
    $user = getUser();
}
$userId = $user ? $user['user_id'] : null;
if (!isset($_GET['book_id'])) {
    redirect("index.php");
}
$book_id = $_GET["book_id"];
$query = $connect->query("select * from books where id='$book_id'");
if ($query->num_rows == 0) {
    redirect("index.php");
}
$book = $query->fetch_array();

// wishlist work
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_wishlist2'])) {
    if ($userId) {
        $bookId = $_POST['wishlist_id2'];
        $check = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        if ($check->num_rows > 0) {
            $connect->query("DELETE FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
        } else {
            $connect->query("INSERT INTO wishlist (user_id, book_id) VALUES ('$userId', '$bookId')");
        }
        redirect("wishlist.php");
        exit();
    } else {
        redirect("login.php");
        exit();
    }
}
$bookId = $book['id'];
$checkWishlist = $connect->query("SELECT * FROM wishlist WHERE user_id = '$userId' AND book_id = '$bookId'");
$isWishlisted = ($checkWishlist->num_rows > 0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadRainbow | Details</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<body class="bg-[#FBFFE4]">
    <?php include_once "includes/header.php"; ?>
    <?php include_once "includes/subheader.php"; ?>
    <div class="flex p-10 bg-white mt-30">
        <div class="flex gap-20 items-center w-5/12 border-gray-300 border-r-2 space-x-4 p-6">
            <div class="flex flex-col space-y-2">
                <img src="assets/images/<?= $book['img1']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img1']; ?>')">
                <img src="assets/images/<?= $book['img2']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img2']; ?>')">
                <img src="assets/images/<?= $book['img3']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img3']; ?>')">
                <img src="assets/images/<?= $book['img4']; ?>" alt="Thumbnail 1"
                    class="w-16 object-cover h-20 cursor-pointer border border-gray-300 rounded-md hover:shadow-md"
                    onclick="changeImage('<?php echo 'assets/images/' . $book['img4']; ?>')">
            </div>

            <div class="w-64 rounded-lg overflow-hidden shadow-lg">
                <img id="mainBookImage" src="assets/images/<?= $book['img1']; ?>" alt="Book Image"
                    class="w-full h-full object-cover">
            </div>
        </div>
        <div class="w-7/12 flex flex-col gap-2 p-6">
            <div class="flex ">
                <h1 class="text-2xl font-semibold"><?= $book['book_name']; ?></h1>
                <div class="gap-4 flex ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-10 h-10 px-2 py-1 text-gray-700 bg-gray-300 rounded-full">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                    <div class="relative inline-block">
                        <!-- Share Button -->
                        <button id="shareBtn"
                            class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-5 h-5">
                                <path fill-rule="evenodd"
                                    d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                                    clip-rule="evenodd" />
                            </svg>
                            Share
                        </button>

                        <!-- Dropdown Share Options -->
                        <div id="shareDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 border border-gray-200">
                            <div class="py-1">
                                <!-- WhatsApp -->
                                <a href="#" onclick="shareOnWhatsApp()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3670/3670051.png"
                                        class="w-5 h-5 mr-2" alt="WhatsApp">
                                    WhatsApp
                                </a>

                                <!-- Facebook -->
                                <a href="#" onclick="shareOnFacebook()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="https://cdn-icons-png.flaticon.com/512/124/124010.png"
                                        class="w-5 h-5 mr-2" alt="Facebook">
                                    Facebook
                                </a>

                                <!-- Twitter -->
                                <a href="#" onclick="shareOnTwitter()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png"
                                        class="w-5 h-5 mr-2" alt="Twitter">
                                    Twitter
                                </a>

                                <!-- Email -->
                                <a href="#" onclick="shareOnEmail()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                    Email
                                </a>

                                <!-- Copy Link -->
                                <a href="#" onclick="copyToClipboard()"
                                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                    </svg>
                                    Copy Link
                                </a>
                            </div>
                        </div>
                    </div>

                    <script>
                        // Toggle dropdown
                        document.getElementById('shareBtn').addEventListener('click', function (e) {
                            e.stopPropagation();
                            document.getElementById('shareDropdown').classList.toggle('hidden');
                        });

                        // Close dropdown when clicking outside
                        document.addEventListener('click', function () {
                            document.getElementById('shareDropdown').classList.add('hidden');
                        });

                        // Share functions
                        function getShareUrl() {
                            return window.location.href;
                        }

                        function getShareText() {
                            return "Check out this book: <?= $book['book_name'] ?>";
                        }

                        // WhatsApp
                        function shareOnWhatsApp() {
                            const url = `https://wa.me/?text=${encodeURIComponent(getShareText() + ' - ' + getShareUrl())}`;
                            window.open(url, '_blank');
                        }

                        // Facebook
                        function shareOnFacebook() {
                            const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(getShareUrl())}`;
                            window.open(url, '_blank', 'width=600,height=400');
                        }

                        // Twitter
                        function shareOnTwitter() {
                            const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(getShareText())}&url=${encodeURIComponent(getShareUrl())}`;
                            window.open(url, '_blank', 'width=600,height=400');
                        }

                        // Email
                        function shareOnEmail() {
                            const subject = "Check out this book: <?= $book['book_name'] ?>";
                            const body = `I thought you might like this book:\n\n${getShareText()}\n\n${getShareUrl()}`;
                            window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
                        }

                        // Copy Link
                        function copyToClipboard() {
                            navigator.clipboard.writeText(getShareUrl())
                                // .then(() => alert('Link copied to clipboard!'))
                                .catch(() => {
                                    // Fallback for older browsers
                                    const input = document.createElement('input');
                                    input.value = getShareUrl();
                                    document.body.appendChild(input);
                                    input.select();
                                    document.execCommand('copy');
                                    document.body.removeChild(input);
                                    alert('Link copied!');
                                });
                        }
                    </script>
                </div>
            </div>

            <p class="text-orange-400 text-sm font-semibold"><?= $book['book_category']; ?></p>
            <h3 class="text-lg font-semibold">Author: <span class="text-[#3D8D7A]"><?= $book['book_author']; ?></span>
            </h3>
            <div class="flex gap-5 mb-5">
                <?php if ($book['version'] != 'old'): ?>
                    <label class="cursor-pointer">
                        <input type="radio" name="book_type" id="e_book" value="e_book" class="peer sr-only">
                        <div
                            class="border-2 border-orange-300 hover:shadow-xl rounded-lg px-3 h-22 w-42 pt-1 flex flex-col peer-checked:border-orange-700">
                            <p class="text-lg p-0 font-semibold">E-BOOK</p>

                            <p class="text-gray-700 font-semibold">Price: <span
                                    class="text-xl text-red-500">₹<?= $book['e_book_price']; ?></span></p>
                            <?=
                                $book['e_book_price'] != null ? "<span class='text-green-500 text-sm'>Available Now</span>" : "<span class='text-red-500 text-sm'>Not Available</span>";
                            ?>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="book_type" id="physical" value="physical" class="peer sr-only " checked>
                        <div
                            class="border-2 border-orange-300 hover:shadow-xl rounded-lg px-3 h-22 w-42 pt-1 flex flex-col peer-checked:border-orange-700">
                            <p class="text-lg font-semibold"><?= $book['book_binding']; ?></p>
                            <?php
                            $bookId = $book['id'];
                            $mrp = floatval($book['mrp']);
                            $sell_price = floatval($book['sell_price']);
                            $discount = ($mrp > 0) ? round((($mrp - $sell_price) / $mrp) * 100) : 0;
                            ?>
                            <p><?= $discount; ?>% off</p>
                            <p class="text-gray-700 font-semibold">Price: ₹<del class="text-sm"><?= $book['mrp']; ?></del>
                                <span class="text-xl text-red-500">₹<?= $book['sell_price']; ?></span>
                            </p>
                        </div>
                    </label>
                <?php else: ?>
                    <div>
                        <p>MRP: <?= $book['mrp']; ?></p>
                        <p>Price: <?= $book['sell_price']; ?></p>
                        <p>Binding: <?= $book['book_binding']; ?></p>
                    </div>
                <?php endif; ?>
            </div>
            <hr class="text-gray-300">
            <div class="flex flex-col gap-5">
                <h1 class="text-xl text-gray-600 font-semibold">Key Highlights</h1>
                <div class="grid grid-cols-5 gap-2">
                    <div class="flex items-center border-r gap-1 border-gray-300 px-3 flex-col ">
                        <p class="text-sm text-gray-500">language</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.893 13.393-1.135-1.135a2.252 2.252 0 0 1-.421-.585l-1.08-2.16a.414.414 0 0 0-.663-.107.827.827 0 0 1-.812.21l-1.273-.363a.89.89 0 0 0-.738 1.595l.587.39c.59.395.674 1.23.172 1.732l-.2.2c-.212.212-.33.498-.33.796v.41c0 .409-.11.809-.32 1.158l-1.315 2.191a2.11 2.11 0 0 1-1.81 1.025 1.055 1.055 0 0 1-1.055-1.055v-1.172c0-.92-.56-1.747-1.414-2.089l-.655-.261a2.25 2.25 0 0 1-1.383-2.46l.007-.042a2.25 2.25 0 0 1 .29-.787l.09-.15a2.25 2.25 0 0 1 2.37-1.048l1.178.236a1.125 1.125 0 0 0 1.302-.795l.208-.73a1.125 1.125 0 0 0-.578-1.315l-.665-.332-.091.091a2.25 2.25 0 0 1-1.591.659h-.18c-.249 0-.487.1-.662.274a.931.931 0 0 1-1.458-1.137l1.411-2.353a2.25 2.25 0 0 0 .286-.76m11.928 9.869A9 9 0 0 0 8.965 3.525m11.928 9.868A9 9 0 1 1 8.965 3.525" />
                        </svg>
                        <p><?= $book['language']; ?></p>

                    </div>
                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Total Pages</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                        </svg>

                        <p><?= $book['book_pages'] ?></p>
                    </div>
                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">ISBN</p>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="size-5">
                            <path
                                d="M24 32C10.7 32 0 42.7 0 56L0 456c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24L64 56c0-13.3-10.7-24-24-24L24 32zm88 0c-8.8 0-16 7.2-16 16l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16zm72 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zm96 0c-13.3 0-24 10.7-24 24l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0zM448 56l0 400c0 13.3 10.7 24 24 24l16 0c13.3 0 24-10.7 24-24l0-400c0-13.3-10.7-24-24-24l-16 0c-13.3 0-24 10.7-24 24zm-64-8l0 416c0 8.8 7.2 16 16 16s16-7.2 16-16l0-416c0-8.8-7.2-16-16-16s-16 7.2-16 16z" />
                        </svg>

                        <p><?= $book['isbn'] ?></p>
                    </div>

                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Publish Date</p>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>


                        <p><?= $book['publish_year'] ?></p>
                    </div>

                    <div class="flex items-center border-r gap-1 border-gray-300  px-3 flex-col ">
                        <p class="text-sm text-gray-500">Binding</p>
                        <img src="assets/images/paperback.png" class="size-7" alt="">


                        <p><?= $book['book_binding'] ?></p>
                    </div>
                </div>
                <?php
                if ($book['version'] == "new"):
                    ?>
                    <div class="flex ">
                        <p class="mt-4 text-lg font-bold  "><span id="selectedOption"></span></p>
                    </div><?php else: ?>
                    <?php if ($book['version'] != 'new'): ?>
                        <a href="chatboard.php?book_id=<?= $book['id']; ?>" target="_blank"
                            class="py-2 px-4 bg-blue-500 font-semibold text-center text-white rounded">
                            Chat With Seller
                        </a>

                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <script>
                function changeImage(src) {
                    document.getElementById("mainBookImage").src = src;
                }
            </script>
            <script>
                function updateSelectedOption(value) {
                    const selectedOption = document.getElementById("selectedOption");
                    if (value === "e_book") {
                        selectedOption.innerHTML = `
                           <div class='grid grid-cols-2 gap-5'>
                               <a class='text-orange-500 font-semibold border-orange-500 border rounded px-5 py-2' href='cart.php?add_book=<?=
                                   $book['id'] ?>'>Get E-BOOK to Cart</a>
                             <a class='text-white bg-orange-500 font-semibold rounded px-5 py-2' href='item_checkout.php?buy_book=<?=
                                 $book['id'] ?>' class='flex'>Get E-BOOK Now</a>
                         </div>
                        `;
                    } else if (value === "physical") {
                        selectedOption.innerHTML = `
                        <div class='grid grid-cols-2 gap-5'>
                               <a class='text-orange-500 font-semibold border-orange-500 border rounded px-5 py-2' href='cart.php?add_book=<?=
                                   $book['id'] ?>'>Add Hardcopi to Cart</a>
                             <a class='text-white bg-orange-500 font-semibold rounded px-5 py-2' href='item_checkout.php?buy_book=<?=
                                 $book['id'] ?>' class=' flex'>Buy Hardcopi Now</a>
                         </div>
                        `;
                    }
                }

                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById("physical").checked = true;
                    updateSelectedOption("physical");
                });
                document.querySelectorAll('input[name="book_type"]').forEach((radio) => {
                    radio.addEventListener("change", function () {
                        updateSelectedOption(this.value);
                    });
                });
            </script>
        </div>
    </div>
    <div class="bg-white flex flex-col gap-1 mt-10 px-[5%] py-5 w-full flex">
        <div>
            <h1 class="font-semibold border-b border-gray-300 w-full py-3 text-xl">Description :-</h1>
            <p class="text-gray-700 border-b border-gray-300 py-2"><?= $book['book_description']; ?></p>
        </div>
        <div>
            <h1 class="font-semibold border-b border-gray-300 w-full py-3 text-xl">Author :-</h1>
            <p class="text-gray-700 border-b border-gray-300 py-2"><?= $book['book_author']; ?></p>
        </div>
    </div>
    <?php include_once "includes/recomended_book.php" ?>
    <?php include_once "includes/footer2.php" ?>


    <script>
        const scrollContainer = document.getElementById("bookScroll");
        document.getElementById("scrollLeft").onclick = () => scrollContainer.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
        document.getElementById("scrollRight").onclick = () => scrollContainer.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>