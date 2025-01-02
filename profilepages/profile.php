<?php
include("../php/session_handler.php");
include("../php/db_connect.php");
include("../php/user_detail.php");
if(!isset($_SESSION['user_id'])) {
  header("Location: http://localhost/gaming_corner/profilepages/sign_in.php");
  exit;
}
$successMessage = "";
$errorMessage = "";

if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
  $loggedInFirstName = $_SESSION['first_name'];
  $loggedInLastName = $_SESSION['last_name'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $first_name = trim($_POST['first_name']);
  $last_name = trim($_POST['last_name']);
  $email = trim($_POST['email']);
  $bio = trim($_POST['bio']);
  $password = trim($_POST['password']);

  if (empty($first_name) || empty($last_name) || empty($email)) {
      $errorMessage = "First name, last name, and email are required.";
  } else {
      try {
          // Update query preparation
          if (!empty($password)) {
              $hashed_password = password_hash($password, PASSWORD_DEFAULT);
              $query_update = "UPDATE users SET first_name = ?, last_name = ?, email = ?, bio = ?, password = ? WHERE user_id = ?";
              $stmt_update = $conn->prepare($query_update);
              $stmt_update->bind_param("sssssi", $first_name, $last_name, $email, $bio, $hashed_password, $_SESSION['user_id']);
          } else {
              $query_update = "UPDATE users SET first_name = ?, last_name = ?, email = ?, bio = ? WHERE user_id = ?";
              $stmt_update = $conn->prepare($query_update);
              $stmt_update->bind_param("ssssi", $first_name, $last_name, $email, $bio, $_SESSION['user_id']);
          }

          if ($stmt_update->execute()) {
              $successMessage = "Profile updated successfully.";
              $_SESSION['first_name'] = $first_name;
              $_SESSION['last_name'] = $last_name;
              $user_details['first_name'] = $first_name;
              $user_details['last_name'] = $last_name;
              $user_details['email'] = $email;
              $user_details['bio'] = $bio;
          } else {
              $errorMessage = "Failed to update profile. Please try again.";
          }
          $stmt_update->close();
      } catch (Exception $e) {
          $errorMessage = "An error occurred: " . $e->getMessage();
      }
  }
}

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1);
$offset = ($page - 1) * $limit;

$query_count = "SELECT COUNT(*) as total FROM articles WHERE user_id = ?";
$stmt_count = $conn->prepare($query_count);
$stmt_count->bind_param("i", $user_id);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_articles = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_articles / $limit);
$stmt_count->close();

$query = "SELECT id, title, created_at FROM articles WHERE user_id = ? LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $user_id, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile - Gaming Corner</title>
    <link rel="icon" href="../img/Game-Controller.png" type="image/x-icon">
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
    <link rel="stylesheet" href="../css/styling.css"/>
    <link rel="stylesheet" href="../css/profile.css">
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
    
    <section class="profile-container container mt-4" style="max-width: 1400px; max-height: 700px;">
    <div class="row">
        <!-- Edit Profile Section -->
        <div class="col-md-6">
            <div class="profile-section p-4 shadow-sm bg-white rounded">
                <div class="profile-header">
                    <h1>My Profile</h1>
                </div>
                <?php if ($successMessage): ?>
                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                <?php elseif ($errorMessage): ?>
                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                <?php endif; ?>

                <div class="profile-form">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" 
                                value="<?php echo htmlspecialchars($first_name); ?>" required />
                        </div>

                        <div class="form-group mb-3">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" 
                                value="<?php echo htmlspecialchars($last_name); ?>" required />
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" 
                                value="<?php echo htmlspecialchars($email); ?>" required />
                        </div>

                        <div class="form-group mb-3">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" class="form-control"><?php echo htmlspecialchars($bio); ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Change Password</label>
                            <input type="password" id="password" name="password" class="form-control" 
                                placeholder="Enter new password (optional)" />
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
        <div class="profile-section p-4 shadow-sm bg-white rounded">
            <div class="profile-header">
                <h1>My Articles</h1>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <table class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Date Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                                <td>
                                    <a href="../editarticle.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="../php/delete_article.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this article?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
              <div style="display: flex; justify-content: center; align-items: center; height: 100%;">
                <p class="mt-3">You have not created any articles yet. <a href="../articleupload.php">Write one now!</a></p>
              </div>
            <?php endif; ?>

            <?php $stmt->close(); ?>

            <!-- Pagination Links -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center mt-4">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
      </div>
    </div>
    </section>
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
      <script src="../jscript/script.js"></script>
      <script src="../jscript/profile.js"></script>
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
      ></script>
</body>
</html>