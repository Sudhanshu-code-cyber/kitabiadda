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

<?php include_once "../includes/admin_navbar.php"; ?>



  <div class="full-screen">
    <?php include_once "../includes/admin_sidebar.php"; ?>

    <div class="main-content col-8">
    <div class="content flex-grow-1 p-4">
      <h2>ONLY VIEW INSERTED CATEGORies...</h2>
      <!-- <p>Manage all foods and orders efficiently</p> -->

      <!-- Table Section inside Horizontal Slider -->
      <div class="container mt-5">
        <h3>Category Data</h3>

        <!-- Horizontal Scrollable Table -->
        <div class="table-container">
          <table class="table table-bordered table-striped">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Category</th>
                <th scope="col">Sub-category</th>
                <th scope="col">Description</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Fruits</td>
                <td>Apples</td>
                <td>Sweet and crunchy apple.</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Vegetables</td>
                <td>Carrots</td>
                <td>Fresh and healthy carrots.</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Dairy</td>
                <td>Milk</td>
                <td>Fresh and creamy milk.</td>
              </tr>
              <!-- Add more rows here as needed -->
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