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
  <style>
        .card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .icon {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .breadcrumb a {
            text-decoration: none;
            color: #6c757d;
        }
    </style>


</head>

<body>

  <?php include_once "../includes/admin_navbar.php"; ?>


  <div class="full-screen">
    <?php include_once "../includes/admin_sidebar.php"; ?>

    <div class="main-content">
      <div class="content flex-grow-1 p-4">
        <h2>Welcome to Read Rainbow</h2>
        <div class="container mt-4">
        
        <h4 class="mb-3">Projects</h4>
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="icon">📁</div>
                    <h3>29</h3>
                    <p>Total Projects</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="icon">📋</div>
                    <h3>715</h3>
                    <p>Total Tasks</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="icon">👥</div>
                    <h3>31</h3>
                    <p>Members</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="icon">📈</div>
                    <h3>93% <span class="text-success">&#9650;</span></h3>
                    <p>Productivity</p>
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