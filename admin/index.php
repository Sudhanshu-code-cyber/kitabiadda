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
        <!-- <p>Manage all foods and orders efficiently</p> -->

        <div class="row mt-4">
          <!-- Cards -->
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm">
              <div class="card-body text-center">

                <h1>80</h1>
                <h5>Manage Item Category</h5>
                <a href="" class="btn btn-primary btn-sm">View</a>
                <a href="" class="btn btn-success btn-sm">Insert</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h1>10</h1>
                <h5>Manage item Name</h5>
                <a href="" class="btn btn-primary btn-sm">View</a>
                <a href="" class="btn btn-success btn-sm">Insert</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h1>50</h1>
                <h5>Manage Orders</h5>
                <a href="" class="btn btn-primary btn-sm">View</a>
                <a href="" class="btn btn-success btn-sm">Insert</a>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm">
              <div class="card-body text-center">
                <h1>30</h1>
                <h5>Total Users</h5>
                <a href="" class="btn btn-primary btn-sm">View</a>
                <a href="" class="btn btn-success btn-sm">Insert</a>
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