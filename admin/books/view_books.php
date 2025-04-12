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


</head>

<body>

  <?php include_once "../includes/admin_navbar.php"; ?>



  <div class="full-screen">
    <?php include_once "../includes/admin_sidebar.php"; ?>

    <div class="main-content col-8">
      <div class="content flex-grow-1 p-4">
        <h2>ONLY VIEW INSERTED CATEGORies...</h2>

        <!-- Table Section inside Horizontal Slider -->
        <div class="container mt-5">
          <h3>Category Data</h3>


          <!-- Horizontal Scrollable Table -->
          <div class="table-container">
            <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Book category</th>
                  <th scope="col">Book Name</th>
                  <th scope="col">Mrp </th>
                  <th scope="col">sell Price</th>
                  <th scope="col">language</th>
                  <th scope="col">Quality</th>
                  <th scope="col">Rating</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $call_book = mysqli_query($connect, "SELECT * FROM books");
                while ($book_detail = mysqli_fetch_array($call_book)) { ?>

                  <tr>
                    <th scope="row"><?= $book_detail['id'] ?></th>
                    <td><?= $book_detail['book_category'] ?></td>
                    <td><?= $book_detail['book_name'] ?></td>
                    <td><?= $book_detail['mrp'] ?></td>
                    <td><?= $book_detail['sell_price'] ?></td>
                    <td><?= $book_detail['language'] ?></td>
                    <td><?= $book_detail['quality'] ?></td>
                    <td><?= $book_detail['book_rating'] ?></td>

                    <td><a href="?delete_book=<?= $book_detail['id']; ?>" class="btn btn-danger btn-sm"><i
                          class="bi bi-trash3"></i></a>
                      <!-- delete work start -->
                      <?php
                      if (isset($_GET['delete_book'])) {
                        $id = $_GET['delete_book'];
                        $delete_books_query = mysqli_query($connect, "DELETE FROM books where id='$id'");
                        if ($delete_books_query) {
                          echo "<script>
                              Swal.fire({
                                  title: 'Category DELETE Successfully!',
                                  text: 'Click OK to go back to the category list.',
                                  icon: 'success',
                                  confirmButtonText: 'OK'
                              }).then((result) => {
                                  if (result.isConfirmed) {
                                      // Redirect to your desired page (change 'your_page.php' to the actual page you want)
                                      window.location.href = 'view_books.php';
                                  }
                              });
                            </script>";
                        }
                      }

                      ?>
                      <!-- delete work end -->

                      <a href="edit_books.php?edit_book=<?= $book_detail['id']; ?>" class="btn btn-warning btn-sm"><i
                          class="bi bi-pencil-square"></i></a>
                      <a href="full_view_books.php?full_view_books=<?= $book_detail['id']; ?>" class="btn btn-success btn-sm">Full_view</a>
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