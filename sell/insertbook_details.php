<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div id="bookDetails" class="container py-5">
    <h2 class="mb-4">Book Details</h2>
    <form>
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label">Book Name</label>
                <input type="text" name="book_name" class="form-control" placeholder="Enter book name">
            </div>
            <div class="col-md-6">
                <label class="form-label">Author</label>
                <input type="text" name="author" class="form-control" placeholder="Enter author name">
            </div>

            <div class="col-md-4">
                <label class="form-label">Binding</label>
                <input type="text" name="binding" class="form-control" placeholder="e.g., Paperback, Hardcover">
            </div>
            <div class="col-md-4">
                <label class="form-label">MRP</label>
                <input type="number" name="mrp" class="form-control" placeholder="Enter MRP">
            </div>
            <div class="col-md-4">
                <label class="form-label">Selling Price</label>
                <input type="number" name="selling_price" class="form-control" placeholder="Enter selling price">
            </div>

            <div class="col-md-6">
                <label class="form-label">Pages</label>
                <input type="number" name="pages" class="form-control" placeholder="Total pages">
            </div>
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control" placeholder="Book category">
            </div>

            <div class="col-md-4">
                <label class="form-label">Language</label>
                <input type="text" name="language" class="form-control" placeholder="Book language">
            </div>
            <div class="col-md-4">
                <label class="form-label">ISBN</label>
                <input type="text" name="isbn" class="form-control" placeholder="ISBN number">
            </div>
            <div class="col-md-4">
                <label class="form-label">Publish Year</label>
                <input type="number" name="publish_year" class="form-control" placeholder="Enter publish year">
            </div>

            <div class="col-12">
                <label class="form-label">Quality</label>
                <select name="quality" class="form-select">
                    <option value="New">New</option>
                    <option value="Like New">Like New</option>
                    <option value="Good">Good</option>
                    <option value="Acceptable">Acceptable</option>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Describe the book"></textarea>
            </div>

            <div class="col-12 d-flex flex-wrap gap-3">
    <label class="form-label w-100">Upload Images</label>
    <div class="image-upload">
        <input type="file" name="image[]" class="form-control" multiple>
    </div>
    <div class="image-upload">
        <input type="file" name="image[]" class="form-control" multiple>
    </div>
    <div class="image-upload">
        <input type="file" name="image[]" class="form-control" multiple>
    </div>
    <div class="image-upload">
        <input type="file" name="image[]" class="form-control" multiple>
    </div>
    <div class="image-upload">
        <input type="file" name="image[]" class="form-control" multiple>
    </div>
    <div class="image-upload">
        <input type="file" name="image[]" class="form-control" multiple>
    </div>
</div>


            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <a href="sell.php" class="btn btn-primary me-2">Reset</a>
            </div>
        </div>
    </form>
</div>

<!-- Add Bootstrap CSS -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>