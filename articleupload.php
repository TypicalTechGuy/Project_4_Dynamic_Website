<?php
include("php/session_handler.php");
include("php/db_connect.php");
include("php/user_detail.php");
if(!isset($_SESSION['user_id'])) {
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $user_id = $_POST['user_id'];
  $published_date = $_POST['published_date'];
  $content = $_POST['content'];
  $category = $_POST['category'];
  $status = $_POST['status'];

  $uploadDir = 'img/articleImage/';
  $image = $_FILES['image'];

  $imageUrl = null;
  if (isset($image) && $image['error'] === UPLOAD_ERR_OK) {
      $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
      if (in_array($image['type'], $allowedTypes)) {
          $fileName = time() . '_' . basename($image['name']);
          $filePath = $uploadDir . $fileName;

          if (move_uploaded_file($image['tmp_name'], $filePath)) {
              $imageUrl = $filePath; // Store relative path to the image
          } else {
              die("Error: Failed to move uploaded file.");
          }
      } else {
          die("Error: Invalid image type. Only JPG, PNG, and GIF are allowed.");
      }
  }

  $query = "INSERT INTO articles (title, user_id, published_date, content, image_url, category, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param(
      'sisssss',
      $title,
      $user_id,
      $published_date,
      $content,
      $imageUrl,
      $category,
      $status
  );

  if ($stmt->execute()) {
    $_SESSION['upload_success'] = true;
    header("Location: articleupload.php");
    exit();
  } else {
      echo "Error: " . $stmt->error;
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaming Corner - Upload an Article</title>
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

      <form class="d-flex w-10" action="SearchResult.php" method="GET">
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
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
              <li><a class="dropdown-item" href="adminPage.php">Admin Dashboard</a></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="profilepages/profile.php">View Profile</a></li>
            <li><a class="dropdown-item" href="articleupload.php">Upload Article</a></li>
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

    <div class="container mt-5">
    <h1>Upload an Article</h1>
    <form action="articleupload.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Title:</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="user_id" class="form-label">User ID (Author):</label>
        <input type="number" class="form-control" id="user_id" name="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>" readonly required>
    </div>
    <div class="mb-3">
        <label for="published_date" class="form-label">Published Date:</label>
        <input type="datetime-local" class="form-control" id="published_date" name="published_date" required>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content:</label>
        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Upload Image:</label>
        <input type="file" class="form-control" id="image" name="image" required>
    </div>
    <div class="mb-3">
      <label for="category" class="form-label">Category:</label>
      <select class="form-select" id="category" name="category" required>
        <option value="" disabled selected>Select a category</option>
        <?php foreach ($categories as $category): ?>
          <option value="<?php echo $category['category_name']; ?>">
              <?php echo htmlspecialchars($category['category_name']); ?>
          </option>
        <?php endforeach; ?>
       </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit Article</button>
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
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
      ></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if (isset($_SESSION['upload_success'])): ?>
                alert('Article uploaded successfully!');
                <?php unset($_SESSION['upload_success']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>