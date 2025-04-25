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

        <div class="main-content">
            <div class="content flex-grow-1 p-4">
                <h2>VIEW FULL BOOK DETAILs...</h2>

                <?php
                if (isset($_GET['full_view_books'])) {
                    $id = $_GET['full_view_books'];
                    // Fetch the current category details
                    $call_books_id = mysqli_query($connect, "SELECT * FROM books WHERE id='$id'");
                    $books_row = mysqli_fetch_array($call_books_id);

                    
                }
                ?>
                <div class="container mt-5">
                    <div class="row">
                        <!-- Book Name -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="bookName" class="form-label">Book Name</label>
                                <input type="text" class="form-control" id="bookName" name="book_name" value="<?= $books_row['book_name'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Author -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author" name="book_author" value="<?= $books_row['book_author'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Binding -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="binding" class="form-label">Binding</label>
                                <input type="text" class="form-control" id="binding" name="book_binding" value="<?= $books_row['book_binding'] ?>" readonly>
                            </div>
                        </div>

                        <!-- MRP -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="mrp" class="form-label">MRP</label>
                                <input type="text" class="form-control" id="mrp" name="mrp" value="<?= $books_row['mrp'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Selling Price -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sellingPrice" class="form-label">Selling Price</label>
                                <input type="text" class="form-control" id="sellingPrice" name="sell_price" value="<?= $books_row['sell_price'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Pages -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pages" class="form-label">Pages</label>
                                <input type="text" class="form-control" id="pages" name="book_pages" value="<?= $books_row['book_pages'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Category -->


                        <!-- Language -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" class="form-control" id="rating" name="language" min="1" max="5"
                                    step="0.1" value="<?= $books_row['language'] ?>" readonly>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <!-- Category -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="rating" name="book_category" min="1" max="5"
                                    step="0.1" value="<?= $books_row['book_category'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Language -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="category" class="form-label">Sub-Category</label>
                                <input type="text" class="form-control" id="rating" name="book_sub_category" min="1" max="5"
                                    step="0.1" value="<?= $books_row['book_sub_category'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- ISBN -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" value="<?= $books_row['isbn'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Publish Year -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="publishYear" class="form-label">Publish Year</label>
                                <input type="text" class="form-control" id="publishYear" name="publish_year" value="<?= $books_row['publish_year'] ?>" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Quality -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quality" class="form-label">Quality</label>
                                <input type="text" class="form-control" id="rating" name="quality" min="1" max="5"
                                    step="0.1" value="<?= $books_row['quality'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="book_description" rows="4"
                                value="" readonly><?= $books_row['book_description'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- E-book Availability -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ebookAvailable" class="form-label">E-book Available</label>
                                <input type="text" class="form-control" id="rating" name="e_book_avl" min="1" max="5"
                                    step="0.1" value="<?= $books_row['e_book_avl'] ?>" readonly>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="rating" class="form-label">E-book Price</label>
                                <input type="text" class="form-control" id="rating" name="e_book_price" min="1" max="5"
                                    step="0.1" value="<?= $books_row['e_book_price'] ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <!-- Image Upload Section -->
                    <div class="row">
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Thumbnail Image</label>
                            
                            <img id="preview1" src="../../assets/images/<?= $books_row['img1'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Image 1</label>
                            
                            <img id="preview1" src="../../assets/images/<?= $books_row['img2'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Image 2</label>
                            
                            <img id="preview1" src="../../assets/images/<?= $books_row['img3'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        <div class="col-md-3">
                            <label for="image1" class="form-label">Image 3</label>
                            
                            <img id="preview1" src="../../assets/images/<?= $books_row['img4'] ?>" alt="Image 1 Preview" class="img-fluid mt-2"
                                >
                        </div>
                        
                    </div>
                    <hr>

                    <div class="row mt-3">
                        <!-- <div class="col text-center"> -->
                            <a href="edit_books.php?edit_book=<?= $books_row['id'] ?>" class="btn btn-primary" name="insert_book"><i class="bi bi-pencil-square me-2"></i>Edit Book Detail</a>
                        <!-- </div> -->
                    </div>

                </div>
                
                

            
            </div>
        </div>

        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


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