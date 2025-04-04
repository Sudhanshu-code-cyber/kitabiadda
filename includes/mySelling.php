<div id="my_selling" class="content-section hidden">
    <h2 class="text-xl md:text-2xl font-semibold mb-4 px-2 md:px-0">My Sold Products</h2>
    <?php
    $calling_myItem = $connect->query("select * from books where seller_id='$userId'");
    if ($calling_myItem->num_rows > 0):
        while ($myItem = $calling_myItem->fetch_assoc()):
            ?>
            <a href="sellBookDetails.php?sell_id=<?= $myItem['id'];?>">
                <div class="flex flex-col gap-4 mt-3 px-2 md:px-0">
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between border border-gray-200 p-3 rounded-lg shadow-sm bg-gray-50 gap-3 sm:gap-0">
                        <div class="flex items-center flex-1 min-w-0">
                            <img src="assets/images/<?= $myItem['img1']; ?>" alt="item_image"
                                class="h-16 w-16 sm:h-18 sm:w-18 rounded shadow-sm object-cover">
                            <h2 class="ml-3 font-medium truncate text-sm sm:text-base"><?= $myItem['book_name']; ?></h2>
                        </div>
                        <h2 class="sm:ml-3 font-medium text-green-600 text-sm sm:text-base">₹<?= $myItem['sell_price']; ?></h2>
                        <div class="flex flex-col gap-1 items-start sm:items-center w-full sm:w-auto text-xs sm:text-sm">
                            <p class="font-semibold">Book Sold on <?= date("d-m-y", strtotime($myItem['post_date'])) ?></p>
                            <p class="text-gray-600">Your product has been sold</p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endwhile;
    else:
        ?>
        <div class="flex flex-col gap-2 justify-center items-center mt-[10%] px-4 text-center">
            <h2 class="text-xl sm:text-2xl text-slate-400 font-bold">You haven't listed anything yet</h2>
            <p class="font-semibold text-slate-700 text-sm sm:text-base">Let go of what you don't use anymore</p>
            <a href="sell/sell.php"
                class="bg-[#3D8D7A] rounded px-3 py-2 text-white font-semibold text-sm sm:text-base hover:bg-[#2a7d6a] transition-colors">Start
                Selling</a>
        </div>
    <?php endif; ?>
</div>