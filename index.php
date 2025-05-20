<?php include 'db.php'; ?>


<!DOCTYPE html>
<html>
<head>
  <title>Book List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
  <h1 class="mb-4">Book List</h1>
  <a href="add.php" class="btn btn-primary mb-3">Add New Book</a>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Cover Image</th>
        <th>Book Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Published Year</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $result = $conn->query("SELECT * FROM books");
      while($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td>
          <?php if ($row['cover_image']): ?>
            <img src="uploads/<?= $row['book_title'] . '-' . $row['author'] . '-' . $row['cover_image'] ?>" alt="Cover Image" width="100">
          <?php else: ?>
            No Image
          <?php endif; ?>
        </td>
        
        <td><?= $row['book_title'] ?></td>
        <td><?= $row['author'] ?></td>
        <td><?= $row['category'] ?></td>
        <td><?= $row['published_year'] ?></td>
        <td>
          <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
