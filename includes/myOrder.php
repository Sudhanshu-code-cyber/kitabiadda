<div id="order" class="content-section  hidden">
    <h2 class="text-2xl font-semibold mb-4">My Orders</h2>
    <div class="flex flex-col gap-2 justify-center items-center ">

        <?php $total_orders = mysqli_query($connect, "SELECT * FROM orders  WHERE email='$userEmail' ORDER BY id DESC ");
        if ($total_orders->num_rows > 0):
            while ($orders = mysqli_fetch_array($total_orders)): ?>
                <div class="w-full shadow-lg rounded-lg bg-white p-5 mb-4">
                    <div class="flex justify-between">
                        <h3 class="text-lg font-bold text-blue-800">#Order ID: <?= $orders['id'] ?></h3>
                        <p class="text-sm text-gray-800"><?php $formatted_date = date("d F Y", strtotime($orders['order_time']));
                        echo $formatted_date . "<br>"; ?></p>
                    </div>
                    <?php
                    $orders_id = $orders['id'];
                    $call_order_item = mysqli_query($connect, "SELECT * FROM cart JOIN books ON cart.item_id = books.id WHERE orders_id='$orders_id'");
                    while ($order_item = mysqli_fetch_array($call_order_item)) { ?>

                        <div class="flex flex-col gap-4 mt-3">
                            <div
                                class="flex items-center justify-between border border-gray-200 p-3 rounded-lg shadow-sm bg-gray-50">
                                <img src="assets/images/<?= $order_item['img1'] ?>" alt="item_image" class="h-18 rounded shadow-sm">
                                <h2 class="ml-3 font-medium truncate"><?= $order_item['book_name'] ?></h2>
                                <h2 class="ml-3 font-medium ">₹ <?= $order_item['sell_price']; ?></h2>
                                <?php
                                if ($orders['status'] == 1):
                                    ?>
                                    <div class="flex flex-col gap-1 items-center">
                                        <p class="text-sm font-semibold">🟢 Delivered on <?php $formatted_date = date("d F Y", strtotime($orders['order_time']));
                                        echo $formatted_date . "<br>"; ?></p>
                                        <p class="text-xs">Your item has been delivered</p>
                                        <p class="text-sm text-blue-500">⭐ Rate & Review Product</p>
                                    </div>
                                <?php elseif ($orders["status"] == 2): ?>
                                    <h1 class="text-white font-semibold bg-orange-500 rounded px-2 py-1">Order Shipped</h1>
                                <?php elseif ($orders["status"] == 3): ?>
                                    <h1 class="text-white font-semibold bg-yellow-600 rounded px-2 py-1">In Transite State
                                    </h1>
                                <?php elseif ($orders["status"] == 4): ?>
                                    <h1 class="text-white font-semibold bg-green-600 rounded px-2 py-1">Out For Delivery
                                    </h1>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <?php
            endwhile;
        else:
            ?>
            <h2 class="text-2xl text-slate-400 font-bold">Order Not Available</h2>
            <a href="index.php" class="bg-[#3D8D7A] rounded text-sm px-2 py-1 text-white font-semibold">
                Make Your 1st Order Now
            </a>
        <?php endif; ?>
    </div>
</div>