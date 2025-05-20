<?php include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $book_title = $_POST['book_title'];
  $author = $_POST['author'];
  $category = $_POST['category'];
  $published_year = $_POST['published_year'];
  $isbn = $_POST['isbn'];
  $price = $_POST['price'];
  $publisher = $_POST['publisher'];
  $description = $_POST['description'];
  $cover_image = $_FILES['cover_image']['name'];

  $sql = "INSERT INTO books (book_title, author, category, published_year, isbn, price, publisher, description, cover_image)
          VALUES ('$book_title', '$author', '$category', '$published_year', '$isbn', '$price', '$publisher', '$description', '$cover_image')";

  if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }


  if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($book_title . '-' . $author . '-' . $_FILES["cover_image"]["name"]);
    if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars(basename($_FILES["cover_image"]["name"])). " has been uploaded.";
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Add Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1 class="mb-4">Add New Book</h1>

<?php
  $add_book_array = [
    'book_title' => '',
    'author' => '',
    'category' => '',
    'published_year' => '',
    'isbn' => '',
    'price' => '',
    'publisher' => '',
    'description' => '',
  ];
?>
<form action="add.php"  method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Book Title</label>
      <input name="book_title" class="form-control">
    </div>
  <?php foreach ($add_book_array as $key => $value): ?>
    <div class="mb-3">
      <label class="form-label"><?= ucfirst(str_replace('_', ' ', $key)) ?></label>
      <input name="<?= $key ?>" class="form-control" value="<?= htmlspecialchars($value) ?>">
    </div>
  <?php endforeach; ?>

    <div class="mb-3">
      <label class="form-label">Cover Image</label>
      <input type="file" name="cover_image" class="form-control">
    </div>

    <button type="submit" class="btn btn-success">Submit</button>
    <a href="index.php" class="btn btn-secondary">Back</a>
</form>
<?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Location: index.php");
    exit;
  }
?>
</body>
</html>
