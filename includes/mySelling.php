<div id="my_selling" class="content-section hidden">
    <h2 class="text-2xl font-semibold mb-4">My Selled Products</h2>
    <?php
    $calling_myItem = $connect->query("select * from books where seller_id='$userId'");
    if ($calling_myItem->num_rows > 0):
        while ($myItem = $calling_myItem->fetch_assoc()):
            ?>
            <div class="flex flex-col gap-4 mt-3">
                <div class="flex items-center justify-between border border-gray-200 p-3 rounded-lg shadow-sm bg-gray-50">
                    <img src="assets/images/<?= $myItem['img1']; ?>" alt="item_image" class="h-18 rounded shadow-sm">
                    <h2 class="ml-3 font-medium truncate"><?= $myItem['book_name']; ?></h2>
                    <h2 class="ml-3 font-medium text-green-600">₹ <?= $myItem['sell_price']; ?></h2>
                    <div class="flex flex-col gap-1 items-center">
                        <p class="text-sm font-semibold">Book Sold on --DATE--</p>
                        <p class="text-xs">Your product has been sold</p>
                    </div>
                </div>
            </div>


        <?php endwhile;
    else:
        ?>
        <div class="flex flex-col gap-2 justify-center items-center mt-[10%]">
            <h2 class="text-2xl text-slate-400 font-bold">You haven't listed anything yet</h2>
            <p class="font-semibold text-slate-700">Let go of what you don't use anymore</p>
            <a href="sell/sell.php" class="bg-[#3D8D7A] rounded px-3 py-2 text-white font-semibold">Start
                Selling</a>
        </div>
    <?php endif; ?>
</div>