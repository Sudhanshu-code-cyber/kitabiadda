<?php 
    include_once '../../config/connect.php';
    include_once '../includes/redirectIfNotAdmin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Rainbow (Admin)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">




</head>

<body>

    <?php include_once "../includes/admin_navbar.php"; ?>


    <div class="full-screen">
        <?php include_once "../includes/admin_sidebar.php"; ?>

        <div class="main-content">
            <div class="content flex-grow-1 p-4">
                <h2>Welcome to <?= PROJECT_NAME?></h2>
                <div class="container mt-5">
                    <!-- yaha banao complain wala div  -->
                    <!-- Complaint Section -->
                    <h4 class="mb-4"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>User Complaints
                    </h4>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                        <!-- Complaint 1 -->
                        <div class="col">
                            <div class="card shadow-sm h-100">
                                <?php
                                    $callingComplain = $connect->query("select * from contact_us");
                                    while($comp = $callingComplain->fetch_assoc()):
                                ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $comp['name'];?></h5>
                                    <p class="card-text">📦 <strong>Complaint:</strong><?= $comp['msg'];?></p>
                                    <p class="card-text"><i class="bi bi-calendar-event"></i> <small
                                            class="text-muted"><?= $comp['msg_time_date'];?></small></p>
                                    <span class="badge bg-warning text-dark mb-3">Pending</span>
                                    <div class="d-flex justify-content-between">
                                        <button class="btn btn-sm btn-info"><i class="bi bi-eye"></i> View</button>
                                        <button class="btn btn-sm btn-success"><i class="bi bi-check-circle"></i>
                                            Resolve</button>
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i>
                                            Delete</button>
                                    </div>
                                </div>
                                <?php endwhile;?>
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