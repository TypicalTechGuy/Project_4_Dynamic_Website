<?php
include("php/session_handler.php");
include("php/db_connect.php");
include("php/user_detail.php");

$update_success = false;
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/gaming_corner/profilepages/sign_in.php");
    exit;
}

$categories = [];
$query = "SELECT category_id, category_name FROM categories";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

if (isset($_GET['id'])) {
    $article_id = $_GET['id']; // Ensure 'id' is consistent
    $query = "SELECT * FROM articles WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $article = $result->fetch_assoc();

    if (!$article) {
        die("Error: Article not found.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $user_id = $_POST['user_id'];
        $published_date = $_POST['published_date'];
        $content = $_POST['content'];
        $category = $_POST['category'];
        $status = $_POST['status'];

        $uploadDir = 'img/articleImage/';
        $image = $_FILES['image'];

        $imageUrl = $article['image_url'];
        if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($image['type'], $allowedTypes)) {
                $fileName = time() . '_' . basename($image['name']);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($image['tmp_name'], $filePath)) {
                    $imageUrl = $filePath;
                } else {
                    die("Error: Failed to move uploaded file.");
                }
            } else {
                die("Error: Invalid image type. Only JPG, PNG, and GIF are allowed.");
            }
        }

        $query = "UPDATE articles SET title = ?, user_id = ?, published_date = ?, content = ?, image_url = ?, category = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param(
            'sisssssi',
            $title,
            $user_id,
            $published_date,
            $content,
            $imageUrl,
            $category,
            $status,
            $article_id 
        );

        if ($stmt->execute()) {
            $update_success = true;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
} else {
    die("Error: No article ID provided.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <link rel="icon" href="img/Game-Controller.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/styling.css"/>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="HomePage.php">
      <img
        src="img/GamingCorner.png"
        alt="logo"
        class="navbar-logo"
        style="width: 120px"
      />
    </a>

    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="HomePage.php?category=Console">Console</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="HomePage.php?category=PC">PC</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="HomePage.php?category=Retro">Retro</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="HomePage.php?category=Arcade">Arcade</a>
        </li>
      </ul>

      <form class="d-flex w-10" action="search_results.php" method="GET">
        <input
          class="form-control"
          type="search"
          name="query"
          placeholder="Search..."
          aria-label="Search"
        />
      </form>

      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="dropdown ms-3">
          <a
            class="btn btn-secondary dropdown-toggle"
            href="#"
            role="button"
            id="userDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
          <?php echo htmlspecialchars($first_name); ?> <?php echo htmlspecialchars($last_name); ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profilepages/profile.php">View Profile</a></li>
            <li><a class="dropdown-item" href="profilepages/settings.php">Settings</a></li>
            <li><a class="dropdown-item" href="php/logout.php">Logout</a></li>
          </ul>
        </div>
        <?php else: ?>
          <div class="d-flex align-items-center">
            <a href="profilepages/sign_in.php" class="btn btn-outline-primary me-2">Sign In</a>
            <a href="profilepages/register.php" class="btn btn-primary">Register</a>
          </div>
        <?php endif; ?>
     </div>
    </nav>

    <?php if ($update_success): ?>
      <script>
          alert('Article updated successfully!');
          window.location.href = 'editarticle.php?id=<?php echo $article_id; ?>';
      </script>
    <?php endif; ?>

<div class="container mt-5">
    <h1>Edit Article</h1>
    <form action="editarticle.php?id=<?php echo $article_id; ?>" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="user_id" class="form-label">User ID (Author):</label>
            <input type="number" class="form-control" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" readonly required>
        </div>
        <div class="mb-3">
            <label for="published_date" class="form-label">Published Date:</label>
            <input type="datetime-local" class="form-control" id="published_date" name="published_date" value="<?php echo date('Y-m-d\TH:i', strtotime($article['published_date'])); ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($article['content']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Upload Image:</label>
            <input type="file" class="form-control" id="image" name="image">
            <br>
            <?php if ($article['image_url']): ?>
                <p>Current image: <img src="<?php echo $article['image_url']; ?>" alt="Article Image" width="100"></p>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category:</label>
            <select class="form-select" id="category" name="category" required>
                <option value="" disabled>Select a category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['category_name']; ?>" <?php echo $category['category_name'] === $article['category'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['category_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status:</label>
            <select class="form-select" id="status" name="status" required>
                <option value="draft" <?php echo $article['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                <option value="published" <?php echo $article['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                <option value="archived" <?php echo $article['status'] === 'archived' ? 'selected' : ''; ?>>Archived</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Article</button>
    </form>
</div>
<br>

<footer class="footer">
    <div class="container">
        <p>&copy; 2024 Gaming Corner. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Contact Us</a></li>
            <li><a href="#">Privacy Policy</a></li>
        </ul>
    </div>
</footer>

<script src="jscript/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

