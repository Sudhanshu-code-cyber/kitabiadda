<?php
include_once "config/connect.php";

if (!isset($_GET['name'])) {
    redirect("index.php");
} 
$book_name = $_GET['name'];
echo $book_name;
$query = $connect->query("SELECT * from books where version='$book_name' OR ");
if ($query->num_rows == 0) {
    redirect("index.php");
}
$oldBook = $query->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>filter page</title>
</head>

<body>
    <div>
        <h1><?= $oldBook['book_name'];?></h1>
    </div>

</body>

</html>