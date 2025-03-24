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

<body>

    <?php include_once "../includes/admin_navbar.php"; ?>



    <div class="full-screen">
        <?php include_once "../includes/admin_sidebar.php"; ?>

        <div class="main-content col-8">
            <div class="content flex-grow-1 p-4">
                <h2>ONLY VIEW INSERTED SUB_CATEGORies...</h2>

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
                                <?php
                                $call_cat = mysqli_query($connect, "SELECT * FROM category");
                                while ($cat_detail = mysqli_fetch_array($call_cat)) { ?>

                                    <tr>
                                        <th scope="row"><?= $cat_detail['id'] ?></th>
                                        <td><?= $cat_detail['cat_title'] ?></td>
                                        <td>
                                            <!-- <form method="GET" action=""> -->
                                                <select name="subcategory" class="form-select"
                                                    onchange="window.location.href=this.value">
                                                    <option value="">Select Subcategory</option>
                                                    <?php
                                                    $cat_id = $cat_detail['id'];
                                                    $call_subcat = mysqli_query($connect, "SELECT * FROM sub_category where cat_id='$cat_id'");
                                                    while ($subcat = mysqli_fetch_array($call_subcat)) { ?>
                                                        <option value="edit_subcategory.php?edit_subcat=<?= $subcat['id'] ?>"><?= $subcat['sub_cat'] ?></option>
                                                    <?php } ?>

                                                </select>
                                            <!-- </form> -->

                                            <!-- <select name="" id="" class="form-select"> -->



                                            </select>


                                        </td>
                                        <td><?= $cat_detail['cat_description'] ?>.</td>

                                        <td>
                                            <!-- delete work end -->

                                            
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