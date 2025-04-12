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
                <h2>INSERT BOOK DETAILS</h2>

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="container mt-5">
                        <div class="row">

                            <!-- Category -->
                            <?php
                            $selected_cat = $_GET['cat_id'] ?? ''; // selected category from URL
                            ?>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="book_category" class="form-label">Category</label>
                                    <select class="form-select" id="book_category" name="book_category" required>
                                        <option value="">Choose Category</option>
                                        <?php
                                        $call_cat = mysqli_query($connect, "SELECT * FROM category");
                                        while ($cat_row = mysqli_fetch_array($call_cat)) {
                                            $link = "?cat_id=" . urlencode($cat_row['id']);
                                            $selected = ($selected_cat == $cat_row['id']) ? 'selected' : '';
                                            echo '<option value="' . $cat_row['cat_title'] . '" ' . $selected . '>' . htmlspecialchars($cat_row['cat_title']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <script>
                                document.getElementById("book_category").addEventListener("change", function () {
                                    let selectedURL = this.value;
                                    if (selectedURL) {
                                        window.location.href = selectedURL;
                                    }
                                });
                            </script>




                            <!-- Language -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Sub-Category</label>
                                    <select class="form-select" id="ebookAvailable" name="book_sub_category" required>
                                        <option value="">Chose Sub-Category</option>
                                        <?php
                                        if (isset($_GET['cat_id'])) {
                                            $cat_id = $_GET['cat_id'];
                                            $call_sub_cat = mysqli_query($connect, "SELECT * FROM sub_category WHERE cat_id='$cat_id'");
                                            while ($sub_cat_row = mysqli_fetch_array($call_sub_cat)) { ?>



                                                <option value="<?= $sub_cat_row['sub_cat'] ?>">
                                                    <?= $sub_cat_row['sub_cat'] ?>
                                                </option>

                                            <?php } ?>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>
                        </div>
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
                                    <!-- <input type="text" class="form-control" id="binding" name="book_binding" required> -->
                                    <select name="book_binding" class="form-control" id="binding">
                                        <option value="Paperback">Paperback</option>
                                        <option value="Hardcopy">Hardcopy</option>
                                    </select>
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

                            <!-- ISBN -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">


                            <!-- Publish Year -->


                        </div>

                        <div class="row">
                            <!-- Quality -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="book_quantity" class="form-label">Book quantity</label>
                                    <input type="text" class="form-control" name="book_quantity" required>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="publishYear" class="form-label">Publish Year</label>
                                        <select class="form-control" id="publishYear" name="publish_year" required>
                                            <option value="">Select Year</option>
                                            <?php
                                            $currentYear = date("Y");
                                            for ($year = $currentYear; $year >= 1900; $year--) {
                                                echo "<option value=\"$year\">$year</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
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

                        <!-- <div class="row"> -->
                            <!-- E-book Availability -->
                            <!-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ebookAvailable" class="form-label">E-book Available</label>
                                    <select class="form-select" id="ebookAvailable" name="e_book_avl" required>
                                        <option value="">Select Option</option>
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div> -->

                            <!-- E-Book Price (Initially Hidden) -->
                            <!-- <div class="col-md-6" id="ebookPriceField" style="display: none;">
                                <div class="mb-3">
                                    <label for="e_book_price" class="form-label">E-Book Price</label>
                                    <input type="text" class="form-control" id="e_book_price" name="e_book_price">
                                </div>
                            </div> -->
                        <!-- </div> -->

                        <!-- Script -->
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const ebookSelect = document.getElementById("ebookAvailable");
                                const priceDiv = document.getElementById("ebookPriceField");
                                const priceInput = document.getElementById("e_book_price");

                                ebookSelect.addEventListener("change", function () {
                                    if (this.value === "Yes") {
                                        priceDiv.style.display = "block";
                                        priceInput.setAttribute("required", "required");
                                    } else {
                                        priceDiv.style.display = "none";
                                        priceInput.removeAttribute("required");
                                        priceInput.value = "";
                                    }
                                });
                            });
                        </script>


                        <!-- Script to show/hide price field -->
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                const ebookSelect = document.getElementById("ebookAvailable");
                                const priceColumn = document.getElementById("priceColumn");
                                const priceInput = document.getElementById("eBookPrice");

                                function togglePriceField() {
                                    if (ebookSelect.value === "Yes") {
                                        priceColumn.style.display = "block";
                                        priceInput.setAttribute("required", "required");
                                    } else {
                                        priceColumn.style.display = "none";
                                        priceInput.removeAttribute("required");
                                        priceInput.value = "";
                                    }
                                }

                                ebookSelect.addEventListener("change", togglePriceField);

                                // Optional: trigger on page load if form is pre-filled
                                togglePriceField();
                            });
                        </script>

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
                    $errors = [];

                    $book_name = trim($_POST['book_name']);
                    if (!preg_match('/^[a-zA-Z0-9\s\-_,.()]+$/', $book_name)) {
                        $errors[] = "Book name is invalid.";
                    }

                    $book_author = trim($_POST['book_author']);
                    if (!preg_match('/^[a-zA-Z\s\.]+$/', $book_author)) {
                        $errors[] = "Author name should only contain letters and spaces.";
                    }

                    $book_binding = $_POST['book_binding'];

                    $mrp = trim($_POST['mrp']);
                    if (!preg_match('/^\d+(\.\d{1,2})?$/', $mrp)) {
                        $errors[] = "MRP must be a valid number.";
                    }

                    $sell_price = trim($_POST['sell_price']);
                    if (!preg_match('/^\d+(\.\d{1,2})?$/', $sell_price)) {
                        $errors[] = "Sell price must be a valid number.";
                    }

                    $book_pages = trim($_POST['book_pages']);
                    if (!preg_match('/^\d+$/', $book_pages)) {
                        $errors[] = "Book pages must be a whole number.";
                    }

                    $book_category = $_POST['book_category'];
                    $book_sub_category = $_POST['book_sub_category'];
                    $language = $_POST['language'];
                    $isbn = trim($_POST['isbn']);
                    if (!preg_match('/^\d{10}(\d{3})?$/', $isbn)) {
                        $errors[] = "ISBN must be 10 or 13 digits.";
                    }

                    $publish_year = $_POST['publish_year'];
                    // $quality = $_POST['quality'];
                    $book_quantity = trim($_POST['book_quantity']);
                    if (!preg_match('/^\d+$/', $book_quantity)) {
                        $errors[] = "Book quantity must be a valid number.";
                    }

                    $book_description = trim($_POST['book_description']);
                    if (!preg_match('/^.{10,}$/', $book_description)) {
                        $errors[] = "Description must be at least 10 characters.";
                    }

                    // $e_book_avl = $_POST['e_book_avl'];
                    // $e_book_price = $_POST['e_book_price'];
                    // $book_rating = $_POST['book_rating'];
                
                    // Show errors if any
                    if (!empty($errors)) {
                        foreach ($errors as $error) {
                            echo "<p style='color:red;'>$error</p>";
                        }
                        exit;
                    }

                    // image 1 working
                    $image1 = $_FILES['img1']['name'];
                    $tmp_image1 = $_FILES['img1']['tmp_name'];
                    move_uploaded_file($tmp_image1, "../../assets/images/$image1");

                    // image 2 working
                    $image2 = $_FILES['img2']['name'];
                    $tmp_image2 = $_FILES['img2']['tmp_name'];
                    move_uploaded_file($tmp_image2, "../../assets/images/$image2");

                    // image 3 working
                    $image3 = $_FILES['img3']['name'];
                    $tmp_image3 = $_FILES['img3']['tmp_name'];
                    move_uploaded_file($tmp_image3, "../../assets/images/$image3");

                    // image 4 working
                    $image4 = $_FILES['img4']['name'];
                    $tmp_image4 = $_FILES['img4']['tmp_name'];
                    move_uploaded_file($tmp_image4, "../../assets/images/$image4");

                    // check isbn already exist or not
                    $checkIsbn = $connect->query("select * from books where isbn='$isbn'");
                    if ($checkIsbn->num_rows > 0) {
                        message("this isbn is already exist");
                        exit();
                    }

                    $insert_books = mysqli_query($connect, "INSERT INTO books (book_name,book_author,book_binding,mrp,sell_price,book_pages,book_category,book_sub_category,language,isbn,publish_year,book_quantity,book_description,img1,img2,img3,img4,version) VALUE ('$book_name','$book_author','$book_binding','$mrp','$sell_price','$book_pages','$book_category','$book_sub_category','$language','$isbn','$publish_year','$book_quantity','$book_description','$image1','$image2','$image3','$image4', 'new')");

                    if ($insert_books) {
                        echo "<script>Swal.fire('Book Inserted Successfully !'); </script>";

                    }

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