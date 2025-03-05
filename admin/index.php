<?php include_once '../config/connect.php'; ?>

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

        <!-- count working    -->
        <?php
        $count_category = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM category")) ;
        $count_books = mysqli_num_rows(mysqli_query($connect,"SELECT * FROM books")) ;


        ?>


        <div class="row mt-4">
          <!-- Cards -->

          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
              <div class="card-body text-center p-4">
                <h1 class="fw-bold text-primary"><?= $count_category ?><span
                    class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                </h1>
                <h5 class="text-secondary mb-3">Manage Item Category</h5>
                <div class="d-flex justify-content-center gap-2">
                  <a href="http://localhost/readrainbow/admin/category/view_category.php" class="btn btn-outline-primary btn-sm px-3 shadow-sm">View</a>
                  <a href="http://localhost/readrainbow/admin/category/insert_category.php" class="btn btn-success btn-sm px-3 shadow-sm">Insert</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
              <div class="card-body text-center p-4">
                <h1 class="fw-bold text-primary"><?= $count_books ?><span
                    class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                </h1>
                <h5 class="text-secondary mb-3">Manage Item Name</h5>
                <div class="d-flex justify-content-center gap-2">
                  <a href="http://localhost/readrainbow/admin/books/view_books.php" class="btn btn-outline-primary btn-sm px-3 shadow-sm">View</a>
                  <a href="http://localhost/readrainbow/admin/books/insert_books.php" class="btn btn-success btn-sm px-3 shadow-sm">Insert</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
              <div class="card-body text-center p-4">
                <h1 class="fw-bold text-primary">*<span
                    class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                </h1>
                <h5 class="text-secondary mb-3">Manage Orders</h5>
                <div class="d-flex justify-content-center gap-2">
                  <a href="#" class="btn btn-outline-primary btn-sm px-3 shadow-sm">View</a>
                  <a href="#" class="btn btn-success btn-sm px-3 shadow-sm">Insert</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-lg border-0 rounded-3 overflow-hidden">
              <div class="card-body text-center p-4">
                <h1 class="fw-bold text-primary">*<span
                    class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                </h1>
                <h5 class="text-secondary mb-3">Manage Users</h5>
                <div class="d-flex justify-content-center gap-2">
                  <a href="#" class="btn btn-outline-primary btn-sm px-3 shadow-sm">View</a>
                  <a href="#" class="btn btn-success btn-sm px-3 shadow-sm">Insert</a>
                </div>
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