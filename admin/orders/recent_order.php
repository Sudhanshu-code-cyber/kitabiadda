<?php include_once '../../config/connect.php'; ?>

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

<body class="bg-light">

    <?php include_once "../includes/admin_navbar.php"; ?>



    <div class="full-screen">
        <?php include_once "../includes/admin_sidebar.php"; ?>

        <div class="main-content col-8">
            <div class="content flex-grow-1 p-4">
                <h2>OUR ORDERs...</h2>
                <hr>
                <div class="container ">
                    <!-- Search & Filters -->
                    <div class="card p-3 mb-4 shadow-sm">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Search...">
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option>Status</option>
                                    <option>In Progress</option>
                                    <option>Complete</option>
                                    <option>Pending</option>
                                    <option>Delivered</option>
                                </select>
                            </div>
                            <div class="col-md-3 text-end">
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
                                        <th>Project</th>
                                        <th>Address</th>
                                        <th>Date Order</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#CM9708</td>
                                        <td><img src="https://i.pravatar.cc/30" class="rounded-circle me-2">
                                            <strong>Jerry Geiger</strong>
                                        </td>
                                        <td>Landing Page</td>
                                        <td><strong>New York</strong><br>Meadow Lane Oakland</td>
                                        <td>01 January 2022</td>
                                        <td><span class="badge bg-primary">In Progress</span></td>
                                        <td>
                                        <a href="" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></a>
                                        <a href="" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                        <i class=""></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#CM9707</td>
                                        <td><img src="https://i.pravatar.cc/30" class="rounded-circle me-2">
                                            <strong>Adam Thomas</strong>
                                        </td>
                                        <td>Client Project</td>
                                        <td><strong>Canada</strong><br>Bagwell Avenue Ocala</td>
                                        <td>02 January 2022</td>
                                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                                        <td>
                                            <i class="fas fa-edit text-primary me-2"></i>
                                            <i class="fas fa-trash text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#CM9706</td>
                                        <td><img src="https://i.pravatar.cc/30" class="rounded-circle me-2">
                                            <strong>Sara Lewis</strong>
                                        </td>
                                        <td>Admin Dashboard</td>
                                        <td><strong>Denmark</strong><br>Washburn Baton Rouge</td>
                                        <td>03 January 2022</td>
                                        <td><span class="badge bg-success">Complete</span></td>
                                        <td>
                                            <i class="fas fa-edit text-primary me-2"></i>
                                            <i class="fas fa-trash text-danger"></i>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>#CM9705</td>
                                        <td><img src="https://i.pravatar.cc/30" class="rounded-circle me-2">
                                            <strong>Myrtle Johnson</strong>
                                        </td>
                                        <td>Landing Page</td>
                                        <td><strong>Brazil</strong><br>Nest Lane Olivette</td>
                                        <td>04 January 2022</td>
                                        <td><span class="badge bg-info text-white">Delivered</span></td>
                                        <td>
                                            <i class="fas fa-edit text-primary me-2"></i>
                                            <i class="fas fa-trash text-danger"></i>
                                        </td>
                                    </tr>
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