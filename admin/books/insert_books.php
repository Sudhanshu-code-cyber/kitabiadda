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
                <h2>INSERT BOOK DETAILS</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="container mt-5">
                        <div class="row">
                            <!-- Book Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="bookName" class="form-label">Book Name</label>
                                    <input type="text" class="form-control" id="bookName" name="book_name" required>
                                </div>
                            </div>

                            <!-- Author -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="author" class="form-label">Author</label>
                                    <input type="text" class="form-control" id="author" name="book_author" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Binding -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="binding" class="form-label">Binding</label>
                                    <input type="text" class="form-control" id="binding" name="book_binding" required>
                                </div>
                            </div>

                            <!-- MRP -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mrp" class="form-label">MRP</label>
                                    <input type="text" class="form-control" id="mrp" name="mrp" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Selling Price -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sellingPrice" class="form-label">Selling Price</label>
                                    <input type="text" class="form-control" id="sellingPrice" name="sell_price"
                                        required>
                                </div>
                            </div>

                            <!-- Pages -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pages" class="form-label">Pages</label>
                                    <input type="text" class="form-control" id="pages" name="book_pages" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Category -->


                            <!-- Language -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="language" class="form-label">Language</label>
                                    <select class="form-select" id="ebookAvailable" name="language" required>
                                        <option value="">Choose Language</option>
                                        <option value="English">English</option>
                                        <option value="Hindi">Hindi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Category -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="ebookAvailable" name="book_category" required>
                                        <option value="">Chose Category</option>
                                        <?php
                                        $call_cat = mysqli_query($connect, "SELECT * FROM category");
                                        while ($cat_row = mysqli_fetch_array($call_cat)) { ?>
                                            <option value="<?= $cat_row['cat_title'] ?>"><?= $cat_row['cat_title'] ?>
                                            </option>

                                        <?php } ?>

                                    </select>
                                </div>
                            </div>

                            <!-- Language -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Sub-Category</label>
                                    <select class="form-select" id="ebookAvailable" name="book_sub_category" required>
                                        <option value="">Chose Sub-Category</option>
                                        <?php

                                        $call_sub_cat = mysqli_query($connect, "SELECT * FROM category");
                                        while ($sub_cat_row = mysqli_fetch_array($call_sub_cat)) { ?>
                                            <option value="<?= $sub_cat_row['subcat_title'] ?>">
                                                <?= $sub_cat_row['subcat_title'] ?>
                                            </option>

                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- ISBN -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" required>
                                </div>
                            </div>

                            <!-- Publish Year -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="publishYear" class="form-label">Publish Year</label>
                                    <input type="text" class="form-control" id="publishYear" name="publish_year"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Quality -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quality" class="form-label">Quality</label>
                                    <select class="form-select" id="ebookAvailable" name="quality" required>
                                        <option value="">Quality</option>
                                        <option value="Fair">Fair</option>
                                        <option value="Good">Good</option>
                                        <option value="Superb">Superb</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="book_description" rows="4"
                                        required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- E-book Availability -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ebookAvailable" class="form-label">E-book Available</label>
                                    <select class="form-select" id="ebookAvailable" name="e_book_avl" required>
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Rating -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating</label>
                                    <input type="text" class="form-control" id="rating" name="book_rating" min="1"
                                        max="5" step="0.1" required>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload Section -->
                        <div class="row">
                            <div class="col-md-3">
                                <label for="image1" class="form-label">Image 1</label>
                                <input type="file" class="form-control" id="image1" name="img1" accept="image/*"
                                    onchange="previewImage(1)" required>
                                <img id="preview1" src="" alt="Image 1 Preview" class="img-fluid mt-2"
                                    style="display:none;">
                            </div>
                            <div class="col-md-3">
                                <label for="image2" class="form-label">Image 2</label>
                                <input type="file" class="form-control" id="image2" name="img2" accept="image/*"
                                    onchange="previewImage(2)" required>
                                <img id="preview2" src="" alt="Image 2 Preview" class="img-fluid mt-2"
                                    style="display:none;">
                            </div>
                            <div class="col-md-3">
                                <label for="image3" class="form-label">Image 3</label>
                                <input type="file" class="form-control" id="image3" name="img3" accept="image/*"
                                    onchange="previewImage(3)" required>
                                <img id="preview3" src="" alt="Image 3 Preview" class="img-fluid mt-2"
                                    style="display:none;">
                            </div>
                            <div class="col-md-3">
                                <label for="image4" class="form-label">Image 4</label>
                                <input type="file" class="form-control" id="image4" name="img4" accept="image/*"
                                    onchange="previewImage(4)" required>
                                <img id="preview4" src="" alt="Image 4 Preview" class="img-fluid mt-2"
                                    style="display:none;">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary" name="insert_book">Insert Book</button>
                            </div>
                        </div>

                    </div>
                </form>
                <?php
                if (isset($_POST['insert_book'])) {
                    $book_name = $_POST['book_name'];
                    $book_author = $_POST['book_author'];
                    $book_binding = $_POST['book_binding'];
                    $mrp = $_POST['mrp'];
                    $sell_price = $_POST['sell_price'];
                    $book_pages = $_POST['book_pages'];
                    $book_category = $_POST['book_category'];
                    $book_sub_category = $_POST['book_sub_category'];
                    $language = $_POST['language'];
                    $isbn = $_POST['isbn'];
                    $publish_year = $_POST['publish_year'];
                    $quality = $_POST['quality'];
                    $book_description = $_POST['book_description'];
                    $e_book_avl = $_POST['e_book_avl'];
                    $book_rating = $_POST['book_rating'];

                    // image 1 working
                    $image1 = $_FILES['img1']['name'];
                    $tmp_image1 = $_FILES['img1']['tmp_name'];
                    move_uploaded_file($tmp_image1, "../../images/$image1");

                    // image 2 working
                    $image2 = $_FILES['img2']['name'];
                    $tmp_image2 = $_FILES['img2']['tmp_name'];
                    move_uploaded_file($tmp_image2, "../../images/$image2");

                    // image 3 working
                    $image3 = $_FILES['img3']['name'];
                    $tmp_image3 = $_FILES['img3']['tmp_name'];
                    move_uploaded_file($tmp_image3, "../../images/$image3");

                    // image 4 working
                    $image4 = $_FILES['img4']['name'];
                    $tmp_image4 = $_FILES['img4']['tmp_name'];
                    move_uploaded_file($tmp_image4, "../../images/$image4");

                    $insert_books = mysqli_query($connect, "INSERT INTO books (book_name,book_author,book_binding,mrp,sell_price,book_pages,book_category,book_sub_category,language,isbn,publish_year,quality,book_description,e_book_avl,book_rating,img1,img2,img3,img4) VALUE ('$book_name','$book_author','$book_binding','$mrp','$sell_price','$book_pages','$book_category','$book_sub_category','$language','$isbn','$publish_year','$quality','$book_description','$e_book_avl','$book_rating','$image1','$image2','$image3','$image4')");

                }


                ?>
            </div>
        </div>

        <script>
            // Function to preview image before uploading
            function previewImage(imageNumber) {
                var file = document.getElementById('image' + imageNumber).files[0];
                var reader = new FileReader();
                reader.onloadend = function () {
                    document.getElementById('preview' + imageNumber).src = reader.result;
                    document.getElementById('preview' + imageNumber).style.display = 'block';
                };
                if (file) {
                    reader.readAsDataURL(file);
                }
            }
        </script>

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