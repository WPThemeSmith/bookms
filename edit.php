<?php include 'db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM books WHERE id=$id");
$book = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $book_title = $_POST['book_title'];
  $author = $_POST['author'];
  $category = $_POST['category'];
  $published_year = $_POST['published_year'];
  $isbn = $_POST['isbn'];
  $price = $_POST['price'];
  $publisher = $_POST['publisher'];
  $description = $_POST['description'];

  $sql = "UPDATE books SET book_title='$book_title', author='$author', category='$category', published_year='$published_year', isbn='$isbn', price='$price', publisher='$publisher', description='$description' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }

  if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
    $cover_image = $_FILES['cover_image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($book_title . '-' . $author . '-' . $_FILES["cover_image"]["name"]);
    if (move_uploaded_file($_FILES["cover_image"]["tmp_name"], $target_file)) {
      echo "The file ". htmlspecialchars(basename($_FILES["cover_image"]["name"])). " has been uploaded.";
      $conn->query("UPDATE books SET cover_image='$cover_image' WHERE id=$id");
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }

  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1 class="mb-4">Edit Book</h1>

  <?php
    $edit_book_array = [
      'book_title' => $book['book_title'],
      'author' => $book['author'],
      'category' => $book['category'],
      'published_year' => $book['published_year'],
      'isbn' => $book['isbn'],
      'price' => $book['price'],
      'publisher' => $book['publisher'],
      'description' => $book['description'],
    ];
  ?>
  <form action="edit.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
    <?php foreach ($edit_book_array as $key => $value): ?>
      <div class="mb-3">
        <label class="form-label"><?= ucfirst(str_replace('_', ' ', $key)) ?></label>
        <input name="<?= $key ?>" class="form-control" value="<?= htmlspecialchars($value) ?>">
      </div>
    <?php endforeach; ?>

    <div class="mb-3">
      <label class="form-label">Cover Image</label>
      <?php if ($book['cover_image']): ?>
        <img src="uploads/<?= $book['book_title'] . '-' . $book['author'] . '-' . $book['cover_image'] ?>" alt="Cover Image" width="100">
      <?php else: ?>
        No Image
      <?php endif; ?>
      <input type="file" name="cover_image" class="form-control mt-2">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
    <a href="index.php" class="btn btn-secondary">Back</a>
  </form>

</body>
</html>

