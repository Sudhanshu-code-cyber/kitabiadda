<div id="order" class="content-section hidden px-2 md:px-0">
    <h2 class="text-xl md:text-2xl font-semibold mb-4">My Orders</h2>
    <div class="flex flex-col gap-4">
        <?php $total_orders = mysqli_query($connect, "SELECT * FROM orders WHERE email='$userEmail' ORDER BY id DESC");
        if ($total_orders->num_rows > 0):
            while ($orders = mysqli_fetch_array($total_orders)): ?>
                <div class="w-full shadow-lg rounded-lg bg-white p-4 sm:p-5 mb-4">
                    <div class="flex flex-col sm:flex-row justify-between gap-2 mb-3">
                        <h3 class="text-base sm:text-lg font-bold text-blue-800">#Order ID: <?= $orders['id'] ?></h3>
                        <p class="text-xs sm:text-sm text-gray-800">
                            <?php $formatted_date = date("d F Y", strtotime($orders['order_time']));
                            echo $formatted_date; ?>
                        </p>
                    </div>
                    <?php
                    $orders_id = $orders['id'];
                    $call_order_item = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id WHERE orders_id='$orders_id'");
                    while ($order_item = mysqli_fetch_array($call_order_item)) { ?>
                        <div class="flex flex-col gap-4 mt-3">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border border-gray-200 p-3 rounded-lg shadow-sm bg-gray-50 gap-3 sm:gap-0">
                                <div class="flex items-center flex-1 min-w-0">
                                    <img src="assets/images/<?= $order_item['img1'] ?>" alt="item_image" class="h-16 w-16 sm:h-18 sm:w-18 rounded shadow-sm object-cover">
                                    <div class="ml-3 min-w-0">
                                        <h2 class="font-medium truncate text-sm sm:text-base"><?= $order_item['book_name'] ?></h2>
                                        <p class="text-sm text-gray-600">₹<?= $order_item['sell_price']; ?></p>
                                    </div>
                                </div>
                                <?php if ($orders['status'] == 1): ?>
                                    <div class="flex flex-col gap-1 items-start sm:items-center w-full sm:w-auto text-xs sm:text-sm">
                                        <p class="font-semibold text-green-600">🟢 Delivered on <?= date("d F Y", strtotime($orders['order_time'])) ?></p>
                                        <p class="text-gray-600">Your item has been delivered</p>
                                        <p class="text-blue-500 hover:text-blue-700 cursor-pointer">⭐ Rate & Review Product</p>
                                    </div>
                                <?php elseif ($orders["status"] == 2): ?>
                                    <span class="text-white font-semibold bg-orange-500 rounded px-2 py-1 text-sm sm:text-base">Order Shipped</span>
                                <?php elseif ($orders["status"] == 3): ?>
                                    <span class="text-white font-semibold bg-yellow-600 rounded px-2 py-1 text-sm sm:text-base">In Transit</span>
                                <?php elseif ($orders["status"] == 4): ?>
                                    <span class="text-white font-semibold bg-green-600 rounded px-2 py-1 text-sm sm:text-base">Out For Delivery</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php endwhile;
        else: ?>
            <div class="flex flex-col gap-2 justify-center items-center mt-[10%] px-4 text-center">
                <h2 class="text-xl sm:text-2xl text-slate-400 font-bold">Order Not Available</h2>
                <p class="font-semibold text-slate-700 text-sm sm:text-base">You haven't placed any orders yet</p>
                <a href="index.php" class="bg-[#3D8D7A] rounded px-3 py-2 text-white font-semibold text-sm sm:text-base hover:bg-[#2a7d6a] transition-colors">
                    Make Your First Order Now
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>