<?php
include "../config/connect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .img>upload {
            width: 120px;
            height: 50px;
        }
    </style>
</head>

<body style="background-color:#FBFFE4;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid ">
            <a class="navbar-brand mx-5 h6" href="../index.php">ReadRainbow</a>
            <a href="../index.php" class="btn btn-primary">Goback</a>
        </div>
    </nav>

    <div id="bookDetails" class="container py-5">
        <h2 class="mb-4 text-info">Book Details</h2>
        <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">

            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label h6">Subject</label>
                    <input type="text" name="Subject" class="form-control" placeholder="Enter book name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Book Name</label>
                    <input type="text" name="book_name" class="form-control" placeholder="Enter author name" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Binding</label>
                    <input type="text" name="binding" class="form-control" placeholder="e.g., Paperback, Hardcover">
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">MRP</label>
                    <input type="number" name="mrp" class="form-control" placeholder="Enter MRP" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Selling Price</label>
                    <input type="number" name="selling_price" class="form-control" placeholder="Enter selling price"
                        required>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Pages</label>
                    <input type="number" name="pages" class="form-control" placeholder="Total pages">
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Category</label>

                    <select name="category" class="form-select" name="category">
                        <option value="">Select book category</option>
                        <?php
                        $callingCat = mysqli_query($connect, "select * from category");
                        while ($cat = mysqli_fetch_array($callingCat)) {
                            echo "<option value='" . $cat['id'] . "'>" . $cat['cat_title'] . "</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Sub Category</label>
                    <select name="sub_category" class="form-select">
                        <option value="">Select Sub category</option>
                        <option value="">Biology</option>
                        <option value="">Chemistry</option>
                        <option value="">Botany</option>
                        <option value="">Zeology</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label h6">Language</label>
                    <input type="text" name="language" class="form-control" placeholder="Book language" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">ISBN</label>
                    <input type="text" name="isbn" class="form-control" placeholder="ISBN number">
                </div>
                <div class="col-md-4">
                    <label class="form-label h6">Publish Year</label>
                    <input type="number" name="publish_year" class="form-control" placeholder="Enter publish year"
                        required>
                </div>

                <div class="col-6">
                    <label class="form-label h6">Quality</label>
                    <select name="quality" class="form-select" name="quality">
                        <option value="New">New</option>
                        <option value="Like New">Like New</option>
                        <option value="Good">Good</option>
                        <option value="Acceptable">Acceptable</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label h6">Contact Number</label>
                    <input type="number" name="contact" class="form-control" placeholder="Enter Your Mo.Number"
                        required>
                </div>
                <div class="col-6">
                    <label class="form-label h6">Seller Name</label>
                    <input type="text" name="firstname" class="form-control" placeholder="Enter Your full Name"
                        required>
                </div>
                <div class="col-6">
                    <label class="form-label h6">Location
                        <i class="bi bi-geo-alt-fill"></i>
                    </label>
                    <input type="hidden" id="latitude" name="latitude">
                    <input type="hidden" id="longitude" name="longitude">
                    <br>
                    <button type="button" onclick="getLocation()" class="btn btn-success">Get Location</button>
                </div>
                <div class="col-12">
                    <label class="form-label h6">Address</label>
                    <textarea name="address" class="form-control" rows="2" placeholder="Enter Your Address"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label h6">Description</label>
                    <textarea name="description" class="form-control" rows="4"
                        placeholder="Describe the book"></textarea>
                </div>
                <div class="row gap-2 mt-2">
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput1').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer1" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText1" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2">front image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="file" id="fileInput1" accept="image/*" class="d-none upload" multiple name="img1"
                        onchange="previewImages(event, 'imagePreviewContainer1', 'uploadText1')">
                    <br>

                    <!-- Second Upload Section -->
                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput2').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer2" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText2" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2"> image</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="file" id="fileInput2" accept="image/*" class="d-none upload" multiple name="img2"
                        style="width:100px; height:40px;"
                        onchange="previewImages(event, 'imagePreviewContainer2', 'uploadText2')">
                    <br>

                    <!-- Third Upload Section -->

                    <div class="col-sm-2">
                        <div class="d-flex justify-content-between">
                            <div class="card" style="width: 120px; cursor: pointer;"
                                onclick="document.getElementById('fileInput3').click()">
                                <div class="card-body text-center">
                                    <div id="imagePreviewContainer3" class="d-flex flex-wrap gap-2"></div>
                                    <div id="uploadText3" class="text-muted">
                                        <i class="bi bi-camera fs-1"></i>
                                        <p class="mt-2">Back Image</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="file" id="fileInput3" accept="image/*" class="d-none upload" multiple name="=img3"
                            onchange="previewImages(event, 'imagePreviewContainer3', 'uploadText3')">
                    </div>

                    <script>
                        function previewImages(event, previewContainerId, uploadTextId) {
                            const files = event.target.files;
                            const imagePreviewContainer = document.getElementById(previewContainerId);
                            const uploadText = document.getElementById(uploadTextId);

                            imagePreviewContainer.innerHTML = ''; // Purane previews clear karne ke liye

                            if (files.length > 0) {
                                uploadText.classList.add('d-none'); // "Add Photos" text hide karna

                                Array.from(files).forEach((file) => {
                                    if (file && file.type.startsWith('image/')) {
                                        const reader = new FileReader();

                                        reader.onload = function (e) {
                                            const img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.className = 'img-fluid rounded';
                                            img.style.maxWidth = '100px';
                                            img.style.maxHeight = '100px';
                                            img.style.objectFit = 'cover';
                                            imagePreviewContainer.appendChild(img);
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                });
                            }
                        }
                    </script>
                </div>
            </div>


            <div class="col-12 d-flex justify-content-end">

                <a href="sell.php" class="btn btn-warning me-2 mt-4">Reset</a>
                <button type="submit" class="btn btn-success me-2 w-25 mt-4" name="submit">Sell</button>
            </div>
    </div>
    </form>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    alert("Location captured!");
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>

    <?php
    if (isset($_POST['submit'])) {
        $subject = $_POST['Subject'];
        $book_name = $_POST['book_name'];
        $book_author = $_POST['author'];
        $book_binding = $_POST['binding'];
        $mrp = $_POST['mrp'];
        $price = $_POST['selling_price'];
        $pages = $_POST['pages'];
        $category = $_POST['category'];
        $sub_category = $_POST['sub_category'];
        $language = $_POST['language'];
        $isbn = $_POST['isbn'];
        $publish_year = $_POST['publish_year'];
        $quality = $_POST['quality'];
        $contact = $_POST['contact'];
        $firstname = $_POST['firstname'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $address = $_POST['address'];
        $sbook_description = $_POST['description'];

        $img1 = $_FILES['img1']['name'];
        $tmp_image1 = $_FILES['img1']['tmp_name'];
        $img2 = $_FILES['img2']['name'];
        $tmp_image2 = $_FILES['img2']['tmp_name'];
        $img3 = $_FILES['img3']['name'];
        $tmp_image3 = $_FILES['img3']['tmp_name'];
        if ($img1 && $tmp_image1) {
            move_uploaded_file($tmp_image1, "../sell/sell_images/$img1");
        }
        if ($img2 && $tmp_image2) {
            move_uploaded_file($tmp_image2, "../sell/sell_images/$img2");
        }
        if ($img3 && $tmp_image3) {
            if (move_uploaded_file($tmp_image3, "../sell/sell_images/$img3")) {
                echo "Image 3 uploaded successfully!";
            } else {
                echo "Failed to upload Image 3!";
            }
        } else {
            echo "Image 3 or tmp_image3 not set properly!";
        }



        $query = mysqli_query($connect, "INSERT INTO sellbook (subject, sbook_name, sbook_author, sbook_binding, sbook_mrp, sbook_price, sbook_pages, sbook_category, sbook_subcategory, sbook_language, sbook_isbn, sbook_pubyear, sbook_quality, seller_contact, seller_firstname, latitude, longitude, seller_address, sbook_description, sbook_img1, sbook_img2, sbook_img3) 
        VALUES ('$subject', '$book_name', '$book_author', '$book_binding', '$mrp', '$price', '$pages', '$category', '$sub_category', '$language', '$isbn', '$publish_year', '$quality', '$contact', '$firstname', '$latitude', '$longitude', '$address', '$sbook_description', '$img1', '$img2', '$img3')");


        if ($query) {
            echo "<script>window.open('../index.php','_self')</script>";
        } else {
            echo "<div class='alert alert-danger'><strong>Oops!</strong> Book insertion failed</div>";
        }
    }
    ?>
    </div>

    <!-- Add Bootstrap CSS -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>