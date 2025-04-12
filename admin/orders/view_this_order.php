<?php include_once '../../config/connect.php';
include_once '../includes/redirectIfNotAdmin.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Order - Read Rainbow (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- <script src="https://kit.fontawesome.com/a076d05399.js"></script> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .order-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .product-img {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }

        .product-details {
            flex: 1;
        }

        @media (max-width: 768px) {
            .product-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }

        .full-screen {
            display: flex;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body class="bg-light">
    <?php include_once "../includes/admin_navbar.php"; ?>

    <div class="full-screen">
        <?php include_once "../includes/admin_sidebar.php"; ?>

        <div class="main-content">
            <h2 class="text-center">Order Details</h2>
            <hr>
            <?php
            if (isset($_GET['order_id'])) {
                $order_id = $_GET['order_id'];
                $call_order_detail = mysqli_query($connect, "SELECT * FROM orders where id='$order_id' ");
                $order_detail = mysqli_fetch_assoc($call_order_detail);
                $email = $order_detail['email'];

                $call_address = mysqli_query($connect, "SELECT * FROM user_address where email='$email'");
                $user_address = mysqli_fetch_assoc($call_address);
            }
            ?>

            <div class="order-card p-4">
                <h4>Order ID: #<?= $order_id ?></h4>
                <p><strong>User:</strong> <?= $user_address['name'] ?> (<?= $email ?>)</p>
                <p><strong>Mobile:</strong> +91 <?= $user_address['mobile'] ?></p>
                <p><strong>Address:</strong> <?= $user_address['address'] ?>, <?= $user_address['city'] ?>,
                    <?= $user_address['state'] ?>, <?= $user_address['landmark'] ?>, <?= $user_address['pincode'] ?>123,
                    Main Street, New Delhi, India
                </p>
                <p><strong>Total Amount : </strong> <strong>₹<?= $order_detail['total_amount'] ?></strong></p>
                <p><strong>Order Status:</strong> <?php if ($order_detail['status'] == 0) { ?>
                        <span class="badge bg-primary">order placed</span>
                    <?php } elseif ($order_detail['status'] == 1) { ?>
                        <span class="badge bg-success">Success</span>
                    <?php } elseif ($order_detail['status'] == 2) { ?>
                        <span class="badge bg-secondary">Order shipped</span>
                    <?php } elseif ($order_detail['status'] == 3) { ?>
                        <span class="badge bg-danger">In Transit</span>
                    <?php } elseif ($order_detail['status'] == 4) { ?>
                        <span class="badge bg-success">out delevery</span>
                    <?php } elseif ($order_detail['status'] == 5) { ?>
                        <span class="badge bg-success">canclelled</span>
                    <?php } else { ?>

                    <?php } ?>
                </p>
                <hr>
                <h5>Product Details:</h5>
                <?php
                $call_book_detail = mysqli_query($connect, "SELECT * FROM cart where orders_id='$order_id'");
                while ($book_id = mysqli_fetch_array($call_book_detail)) { ?>
                    <?php
                    $item_id = $book_id['item_id'];
                    $call_books_detail = mysqli_query($connect, "SELECT * FROM books where id='$item_id'");
                    $book_detail = mysqli_fetch_assoc($call_books_detail);

                    ?>
                    <div class="d-flex align-items-center product-info gap-3">
                        <a href="../../view.php?book_id=<?= $book_detail['id'] ?>"><img
                                src="../../assets/images/<?= $book_detail['img1'] ?>" alt="Product" class="product-img"></a>
                        <div class="product-details">
                            <h6 class="fw-bold"><?= $book_detail['book_name'] ?></h6>
                            <p class="text-muted mb-1">Author: <?= $book_detail['book_author'] ?></p>
                            <p class="mb-1">Price: <strong>₹<?= $book_detail['sell_price'] ?></strong></p>
                            <p class="mb-1">Quantity: <strong><?= $book_id['qty'] ?></strong></p>
                            <p class="mb-1">Category: <?= $book_detail['book_category'] ?></p>
                            <p class="mb-1">Language: <?= $book_detail['language'] ?></p>
                            <p class="mb-1">ISBN: <?= $book_detail['isbn'] ?></p>
                        </div>
                    </div>
                    <hr>


                <?php } ?>
                <?php if ($order_detail['status'] == 0) { ?>
                    <form action="" method="post">
                        <button class="btn btn-primary rounded-1" name="shipped">Proceed TO : SHIPPED</button>
                    </form>
                    <?php
                    if (isset($_POST['shipped'])) {
                        $update_status = mysqli_query($connect, "UPDATE orders SET status=2 where id='$order_id'");
                        if ($update_status) {
                            echo "<script>location.reload();</script>";
                        }
                    }
                    ?>
                <?php } elseif ($order_detail['status'] == 1) { ?>
                    <form action="" method="post">
                        <button class="btn btn-primary rounded-1">Success</button>
                    </form>
                    
                <?php } elseif ($order_detail['status'] == 2) { ?>
                    <form action="" method="post">
                        <button class="btn btn-primary rounded-1" name="transit">Proceed To : In TRANSIT</butt>
                    </form>
                    <?php
                    if (isset($_POST['transit'])) {
                        $update_status = mysqli_query($connect, "UPDATE orders SET status=3 where id='$order_id'");
                        if ($update_status) {
                            echo "<script>location.reload();</script>";
                        }
                    }
                    ?>
                <?php } elseif ($order_detail['status'] == 3) { ?>
                    <form action="" method="post">
                        <button class="btn btn-primary rounded-1" name="out_delevery">Proceed To : OUT FOR DELEVERY</button>
                    </form>
                    <?php
                    if (isset($_POST['out_delevery'])) {
                        $update_status = mysqli_query($connect, "UPDATE orders SET status=4 where id='$order_id'");
                        if ($update_status) {
                            echo "<script>location.reload();</script>";
                        }
                    }
                    ?>
                <?php } elseif ($order_detail['status'] == 4) { ?>
                    <form action="" method="post">
                        <button class="btn btn-primary rounded-1" name="order_success">Proceed To : DELEVERY SUCCESSFULLY DISPLACE</button>
                    </form>
                    <?php
                    if (isset($_POST['order_success'])) {
                        $update_status = mysqli_query($connect, "UPDATE orders SET status=1 where id='$order_id'");
                        if ($update_status) {
                            echo "<script>location.reload();</script>";
                        }
                    }
                    ?>
                <?php } elseif ($order_detail['status'] == 5) { ?>
                    <form action="" method="post">
                        <button class="btn btn-danger rounded-1">canclelled</button>
                    </form>
                    
                <?php } else { ?>

                <?php } ?>

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