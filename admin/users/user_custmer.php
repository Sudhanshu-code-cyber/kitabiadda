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
                <!-- <select class="form-select">
                                    <option>Status</option>
                                    <option>In Progress</option>
                                    <option>Complete</option>
                                    <option>Pending</option>
                                    <option>Delivered</option>
                                </select> -->
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
                    <th>user ID</th>
                    <th>User</th>
                    <th>Name</th>
                    <!-- <th>Address</th> -->
                    <th>gender</th>
                    <th>contact</th>
                    <th>Join Date</th>
                    <!-- <th></th> -->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php $total_users = mysqli_query($connect, "SELECT * FROM users ORDER BY user_id DESC ");
                  while ($users = mysqli_fetch_array($total_users)) { ?>


                    <tr>
                      <td>#<?= $users['user_id'] ?></td>
                      <td>
                        <?php
                        // अगर $user_dp['dp'] खाली है या सेट नहीं है तो डिफ़ॉल्ट इमेज लगाएं
                        $profileImage = !empty($users['dp']) ? "../../assets/user_dp/" . $users['dp'] : "../../assets/defaultUser.webp";
                        ?>
                        <img src="<?= $profileImage ?>" class="rounded-circle me-2 user-dp"
                          onclick="showDpPopup('<?= $profileImage ?>')"
                          style="width: 40px; height: 40px; cursor: pointer;">
                        <strong><?= $users['email'] ?></strong>
                      </td>


                      <td><?= $users['name'] ?></td>
                      <td><strong><?= $users['gender'] ?></td>
                      <td><?= $users['contact'] ?></td>
                      <td>N/A</td>

                      <td>
                        <a href="" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></a>
                        <a href="" class="btn btn-sm btn-primary">Block</a>

                      </td>
                    </tr>


                  <?php } ?>


                </tbody>
              </table>
              <!-- 📌 Bootstrap Modal for DP Popup -->
              <div class="modal fade" id="dpModal" tabindex="-1" aria-labelledby="dpModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="dpModalLabel">User Profile Picture</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                      <img id="popupDp" src="" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                    </div>
                  </div>
                </div>
              </div>
              <!-- 🔥 JavaScript for Modal DP Preview -->
              <script>
                function showDpPopup(imageSrc) {
                  document.getElementById('popupDp').src = imageSrc;
                  var dpModal = new bootstrap.Modal(document.getElementById('dpModal'));
                  dpModal.show();
                }
              </script>
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