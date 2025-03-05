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

        <div class="main-content">
            <div class="content flex-grow-1 p-4">
                <h2>INSERT ONLY CATEGORY DETAILs...</h2>

                <!-- call edit item jo uska id hai  -->
                <?php
                if (isset($_GET['edit_cat']) ) {
                    $cat_id = $_GET['edit_cat'];
                    $call_edit_cat = mysqli_query($connect, "SELECT * FROM category where id=$cat_id");
                    $edit_cat = mysqli_fetch_array($call_edit_cat);

                    if (isset($_POST['cat_edit'])) {
                        $edit_cat_title = $_POST['edit_cat_title'];
                        $edit_subcat_title = $_POST['edit_subcat_title'];
                        $edit_cat_description = $_POST['edit_cat_description'];

                        $edit_cat_query = mysqli_query($connect, "UPDATE category SET cat_title='$edit_cat_title',subcat_title='$edit_subcat_title',cat_description='$edit_cat_description' WHERE id='$cat_id'");
                        if($edit_cat_query){
                            echo "<script>window.location.href='view_category.php';</script>";

                        } else {
                            echo "failed";
                        }
                    }

                }

                ?>


                <form action="" method="post">
                    <div class="container mt-5">
                        <div class="row">
                            <!-- Category Section -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        <h4>Category</h4>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control" placeholder="Enter Category"
                                            name="edit_cat_title" value="<?= $edit_cat['cat_title']; ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Sub-category Section -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        <h4>Sub-category</h4>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control" placeholder="Enter Sub-category"
                                            name="edit_subcat_title" value="<?= $edit_cat['subcat_title']; ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Description Section -->
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h4>Description</h4>
                                    </div>
                                    <div class="card-body">
                                        <textarea class="form-control" rows="4" placeholder="Enter description here..."
                                            name="edit_cat_description"><?= $edit_cat['cat_description']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-3">
                            <div class="col text-center">
                                <button class="btn btn-primary" name="cat_edit">Submit </button>
                            </div>
                        </div>
                    </div>

                    </form>


            </div>
        </div>
    </div>


    </div>












    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
        // Sidebar toggler for mobile
        document.getElementById('sidebar-toggler').addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('show');
        });
    </script>

</body>

</html>