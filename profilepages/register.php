<?php 
include("../php/session_handler.php");
include("../php/db_connect.php");
include("../php/user_detail.php");
function redirect($DoDie = true) {
  header('Location: http://localhost/gaming_corner/profilepages/profile.php');
  if ($DoDie)
    die();
}

if(isset($_SESSION['user_id'])) {
  redirect();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Gaming Corner</title>
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
    <link rel="stylesheet" href="../css/signin.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="../HomePage.php">
          <img
            src="../img/GamingCorner.png"
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
            <a class="nav-link" href="../HomePage.php?category=Console">Console</a>
            </li>
          <li class="nav-item">
            <a class="nav-link" href="../HomePage.php?category=PC">PC</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../HomePage.php?category=Retro">Retro</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../HomePage.php?category=Arcade">Arcade</a>
          </li>
          </ul>

          <form class="d-flex">
            <input
              class="form-control"
              type="search"
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
            <a href="sign_in.php" class="btn btn-outline-primary me-2">Sign In</a>
            <a href="register.php" class="btn btn-primary">Register</a>
          </div>
        <?php endif; ?>
      </div>
      </div>
    </nav>
    
    <div class="signin-container">
        <div class="signin-form">
          <h1>Register</h1>
          <form id="signup-form" action="../php/register_bd.php" method="post">
            <div class="input-group">
              <label for="firstname">First Name</label>
              <input type="text" id="firstname" name="firstname" required />
            </div>
            <div class="input-group">
                <label for="lastname">Last Name</label>
                <input type="text" id="lastname" name="lastname" required />
              </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <small id="password-error" style="color: red; display: none;">Passwords do not match!</small>
            </div>
            <button type="submit" class="signin-btn">Sign Up</button>
            <p class="signup-text">
              Have an account already? <a href="sign_in.php">Sign In here</a>.
            </p>
          </form>
          
          <?php if (isset($_SESSION['error'])): ?>
              <div class="alert alert-danger">
                  <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
              </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['success'])): ?>
              <div class="alert alert-success">
                  <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
              </div>
          <?php endif; ?>

        </div>
      </div>

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
      <script src="../jscript/register.js"></script>
      <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
      ></script>
</body>
</html>