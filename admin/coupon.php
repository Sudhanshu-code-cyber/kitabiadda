<?php 
    include_once '../config/connect.php';
    include_once 'includes/redirectIfNotAdmin.php';
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




</head>

<body>

    <?php include_once "includes/admin_navbar.php"; ?>


    <div class="full-screen">
        <?php include_once "includes/admin_sidebar.php"; ?>

        <div class="main-content">
            <div class="content flex-grow-1 p-4">
                <h2>Welcome to Read Rainbow</h2>
                <div class="container mt-5">
                    <!-- Coupon Form -->
                    <div class="card shadow-sm p-4">
                        <h3 class="text-center text-primary">Add New Coupon</h3>
                        <form method="post">
                            <div class="mb-3">
                                <label for="couponName"  class="form-label">Coupon Name:</label>
                                <input type="text" id="couponName" name="name" class="form-control" placeholder="Enter Coupon Name"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="offerPercent" class="form-label">Offer Percentage:</label>
                                <input type="number" id="offerPercent" class="form-control"
                                    placeholder="Enter Discount %" name="offer" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-success w-100">➕ Add Coupon</button>
                        </form>
                        <?php
                            if(isset($_POST['submit'])){
                                $name = $_POST['name'];
                                $offer = $_POST['offer'];
                                $insert = mysqli_query($connect,"INSERT INTO offer (coupon_name,percentage) VALUE ('$name','$offer')");
                            }
                        ?>
                    </div>

                    <!-- Coupon Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Coupon Name</th>
                                    <th>Discount (%)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dummy Data -->
                                 <?php $call_offer = mysqli_query($connect,"SELECT * FROM offer");
                                 while($offer = mysqli_fetch_array($call_offer)){ ?>
                                 <tr>
                                    <td><?= $offer['id'] ?></td>
                                    <td><?= $offer['coupon_name'] ?></td>
                                    <td><?= $offer['percentage'] ?>%</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm">Delete</button>
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