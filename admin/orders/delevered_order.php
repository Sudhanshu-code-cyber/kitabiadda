<?php include_once '../../config/connect.php';
include_once '../includes/redirectIfNotAdmin.php'; ?>

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
        .user-dp {
            width: 40px;
            /* इमेज को छोटा करने के लिए */
            height: 40px;
            /* गोल आकार के लिए */
            object-fit: cover;
            /* सही aspect ratio बनाए रखने के लिए */
            border: 2px solid #ddd;
            /* हल्का बॉर्डर */
        }
    </style>




</head>

<body class="bg-light">

    <?php include_once "../includes/admin_navbar.php"; ?>



    <div class="full-screen">
        <?php include_once "../includes/admin_sidebar.php"; ?>

        <div class="main-content col-8">
            <div class="content flex-grow-1 ">
                <h2>OUR ORDERs...</h2>
                <hr>
                <div class="container ">
                    <!-- Search & Filters -->
                    <div class="card p-3 mb-4 shadow-sm align-items-between">
                        <div class="row g-2 ">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <div class="col-md-4">
                            
                            </div>
                            <div class="col-md-2 text-end">
                                <button class="btn btn-outline-secondary">Export</button>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Table with Horizontal Scroll -->
                    <div class="card p-3 shadow-sm">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table align-middle table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customers</th>
                                        <th>Total Amount</th>
                                        <th>Address</th>
                                        <th>Date Order</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $total_orders = mysqli_query($connect, "SELECT * FROM orders where status=1  ORDER BY id DESC");
                                    while ($orders = mysqli_fetch_array($total_orders)) { ?>
                                        <?php
                                        $email = $orders['email'];
                                        $call_address = mysqli_query($connect, "SELECT * FROM user_address WHERE email='$email'");
                                        $address = mysqli_fetch_assoc($call_address);
                                        ?>
                                        <?php
                                        $call_order_id = mysqli_query($connect, "SELECT * from orders where email='$email'  ");
                                        $order_id = mysqli_fetch_assoc($call_order_id);
                                        ?>
                                        <?php
                                        $call_user_dp = mysqli_query($connect, "SELECT * from users where email='$email'  ");
                                        $user_dp = mysqli_fetch_assoc($call_user_dp);
                                        $dp = $user_dp['dp'];
                                        ?>

                                        <tr>
                                            <td>#<?= $orders['id'] ?></td>
                                            <td>
                                                <?php
                                                // अगर $user_dp['dp'] खाली है या सेट नहीं है तो डिफ़ॉल्ट इमेज लगाएं
                                                $profileImage = !empty($user_dp['dp']) ? "../../assets/user_dp/" . $user_dp['dp'] : "../../assets/defaultUser.webp";
                                                ?>
                                                <img src="<?= $profileImage ?>" class="rounded-circle me-2 user-dp">
                                                <strong><?= $orders['email'] ?></strong>
                                            </td>


                                            <td>₹ <?= $orders['total_amount'] ?></td>
                                            <td><strong><?= $address['city'] ?></strong><br><?= $address['landmark'] ?></td>
                                            <td><?php $formatted_date = date("d F Y", strtotime($orders['order_time']));
                                            echo $formatted_date . "<br>"; ?></td>
                                            <td><?php if ($orders['status'] == 0) { ?>
                                                    <span class="badge bg-primary">order placed</span>
                                                <?php } elseif ($orders['status'] == 1) { ?>
                                                    <span class="badge bg-success">Success</span>
                                                <?php } elseif ($orders['status'] == 2) { ?>
                                                    <span class="badge bg-secondary">Order shipped</span>
                                                <?php } elseif ($orders['status'] == 3) { ?>
                                                    <span class="badge bg-danger">In Transit</span>
                                                <?php } elseif ($orders['status'] == 4) { ?>
                                                    <span class="badge bg-success">out delevery</span>
                                                <?php } elseif ($orders['status'] == 5) { ?>
                                                    <span class="badge bg-success">canclelled</span>
                                                <?php } else { ?>

                                                <?php } ?>

                                            </td>
                                            <td>
                                                <a href="" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></a>
                                                <a href="view_this_order.php?order_id=<?= $orders['id'] ?>"
                                                    class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
                                                <i class=""></i>
                                            </td>
                                        </tr>


                                    <?php } ?>


                                </tbody>
                            </table>
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