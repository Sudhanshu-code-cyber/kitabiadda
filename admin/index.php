<?php 
    include_once '../config/connect.php';
    include_once 'includes/redirectIfNotAdmin.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Rainbow (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .icon-box {
            background-color: #eef2ff;
            padding: 8px;
            border-radius: 8px;
        }

        .up {
            color: #28a745;
            font-weight: bold;
        }

        .down {
            color: #dc3545;
            font-weight: bold;
        }
    </style>


</head>

<body>

    <?php include_once "includes/admin_navbar.php"; ?>


    <div class="full-screen">
        <?php include_once "includes/admin_sidebar.php"; ?>

        <div class="main-content">
            <div class="content flex-grow-1 p-4">
                <h2>Welcome to Read Rainbow</h2>
                <div class="container py-5">
                    <div class="row g-4">
                        <!-- Customers -->
                        <div class="col-lg-3 col-md-6">
                            <a href="users/user_custmer.php" class="text-decoration-none text-dark">
                                <div class="card p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Customers</span>
                                        <div class="icon-box">
                                            👥
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mt-2">
                                        <?= $total_cart_item = mysqli_num_rows(mysqli_query($connect, "select * from users ")) ?>
                                    </h3>
                                    <span class="up">⬆ 5.27%</span> <small class="text-muted">Since last month</small>
                                </div>
                            </a>
                        </div>

                        <!-- Orders -->
                        <div class="col-lg-3 col-md-6">
                            <a href="orders/recent_order.php" class="text-decoration-none text-dark">
                                <div class="card p-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Orders</span>
                                        <div class="icon-box">
                                            🛒
                                        </div>
                                    </div>
                                    <h3 class="fw-bold mt-2">
                                        <?= $total_cart_item = mysqli_num_rows(mysqli_query($connect, "select * from orders")) ?>
                                    </h3>
                                    <span class="down">⬇ 1.08%</span> <small class="text-muted">Since last month</small>
                                </div>
                            </a>
                        </div>

                        <!-- Revenue -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Revenue</span>
                                    <div class="icon-box">
                                        💲
                                    </div>
                                </div>
                                <?php

                                $query = "SELECT SUM(cart.qty * books.sell_price) AS total_revenue FROM cart JOIN books ON cart.item_id = books.id WHERE cart.direct_buy = 2";

                                $result = mysqli_query($connect, $query);
                                $row = mysqli_fetch_assoc($result);

                                $total_revenue = $row['total_revenue']; // कुल बिक्री मूल्य
                                $query = "SELECT SUM(qty * price) AS total_revenue FROM cart WHERE direct_buy = 2";


                                ?>
                                <h3 class="fw-bold mt-2">₹<?php echo number_format($total_revenue, 2); ?></h3>
                                <span class="down">⬇ 7.00%</span> <small class="text-muted">Since last month</small>
                            </div>
                        </div>

                        <!-- Growth -->
                        <div class="col-lg-3 col-md-6">
                            <div class="card p-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span>Growth</span>
                                    <div class="icon-box">
                                        📈
                                    </div>
                                </div>
                                <h3 class="fw-bold mt-2">+30.56%</h3>
                                <span class="up">⬆ 4.87%</span> <small class="text-muted">Since last month</small>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        // Sidebar toggler for mobile
        document.getElementById('sidebar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>

</body>

</html>