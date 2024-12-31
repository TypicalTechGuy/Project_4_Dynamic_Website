<?php
include("../php/session_handler.php");
include("../php/db_connect.php");
include("../php/user_detail.php");

if (isset($_SESSION['first_name']) && isset($_SESSION['last_name'])) {
  $loggedInFirstName = $_SESSION['first_name'];
  $loggedInLastName = $_SESSION['last_name'];
}

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id > 0) {
    $query = "SELECT a.title, a.content, a.image_url, a.category, a.published_date, u.first_name, u.last_name
              FROM articles a
              INNER JOIN users u ON a.user_id = u.user_id
              WHERE a.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $article_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
        $first_name = $article['first_name'];
        $last_name = $article['last_name'];
    } else {
        header("Location: ../HomePage.php");
        exit();
    }
} else {
    header("Location: ../HomePage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo htmlspecialchars($article['title']); ?> - Gaming Corner</title>
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
    <link rel="stylesheet" href="../css/articlestyling.css">
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
              <a class="nav-link" href="../pages/ConsolePage.php">Console</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/PCPage.php">PC</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/RetroPage.php">Retro</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../pages/ArcadePage.php">Arcade</a>
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
            <?php echo htmlspecialchars($loggedInFirstName); ?> <?php echo htmlspecialchars($loggedInLastName); ?>
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

    <article class="article-content">
        <h1><?php echo htmlspecialchars($article['title']); ?></h1>
        <p>Written By <?php echo htmlspecialchars($first_name); ?> <?php echo htmlspecialchars($last_name); ?>| Published on <?php echo date('F j, Y', strtotime($article['published_date'])); ?></p>
        <?php if (!empty($article['image_url'])): ?>
          <img src="../<?php echo htmlspecialchars($article['image_url']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="img-fluid">
        <?php endif; ?>
        <p><?php echo nl2br (htmlspecialchars($article['content'])); ?></p>
    </article>

    <section class="related-articles">
    <h2>Related Articles</h2>
    <div class="related-items">
        <?php
        $related_query = "SELECT id, title, image_url, content FROM articles WHERE category = ? AND id != ? LIMIT 3";
        $related_stmt = $conn->prepare($related_query);
        $related_stmt->bind_param("si", $article['category'], $article_id);
        $related_stmt->execute();
        $related_result = $related_stmt->get_result();

        if ($related_result->num_rows > 0) {
            while ($related = $related_result->fetch_assoc()): ?>
                <div class="related-item">
                    <?php if (!empty($related['image_url'])): ?>
                        <img src="../<?php echo htmlspecialchars($related['image_url']); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>">
                    <?php endif; ?>
                    <h3><a href="createarticlepage.php?id=<?php echo $related['id']; ?>"><?php echo htmlspecialchars($related['title']); ?></a></h3>
                    <p><?php echo htmlspecialchars(mb_strimwidth($related['content'], 0, 100, "...")); ?></p>
                </div>
            <?php endwhile;
        } else {
            echo "<p>No related articles found.</p>";
        }
        ?>
    </div>
</section>

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

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
  </body>
</html>

