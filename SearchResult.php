<?php
include("php/session_handler.php");
include("php/db_connect.php");
include("php/user_detail.php");

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 4;
$offset = ($page - 1) * $items_per_page;

$search_query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '';

if (!empty($search_query)) {
    $query = "SELECT id, title, content, image_url, category, published_date 
              FROM articles 
              WHERE title LIKE ? OR content LIKE ?
              LIMIT ? OFFSET ?";
    $search_term = "%" . $search_query . "%";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $search_term, $search_term, $items_per_page, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    $count_query = "SELECT COUNT(*) as total FROM articles WHERE title LIKE ? OR content LIKE ?";
    $count_stmt = $conn->prepare($count_query);
    $count_stmt->bind_param("ss", $search_term, $search_term);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $total_articles = $count_result->fetch_assoc()['total'];
    $total_pages = ceil($total_articles / $items_per_page);
} else {
    $result = false;
    $total_pages = 0;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gaming Corner</title>
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
    <script>
      document.addEventListener("DOMContentLoaded", function () {
          const limitedTextElements = document.querySelectorAll(".limited-text");
          const maxChars = 150;

          limitedTextElements.forEach((element) => {
              if (element.textContent.length > maxChars) {
                  element.textContent =
                      element.textContent.substring(0, maxChars) + "...";
              }
          });
      });
    </script>
  
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

    <div class="container mt-4">
    <h1>Search Results</h1>
    <?php if ($result && $result->num_rows > 0): ?>
      <div class="article-grid">
        <?php while ($row = $result->fetch_assoc()): ?>
          <article class="article">
            <a href="articlepages/createarticlepage.php?id=<?= $row['id']; ?>">
              <img
                src="<?= !empty($row['image_url']) ? htmlspecialchars($row['image_url']) : 'img/placeholder.png' ?>"
                alt="<?= htmlspecialchars($row['title']) ?>"
                class="img-fluid"
              />
              <div class="article-content">
                <h2><?= htmlspecialchars($row['title']) ?></h2>
                <p><?= substr(htmlspecialchars($row['content']), 0, 150) ?>...</p>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>
    <?php else: ?>
      <p>No articles found matching your search query.</p>
    <?php endif; ?>
  </div>

  <nav aria-label="Page navigation">
  <ul class="pagination">
    <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="?query=<?= urlencode($search_query) ?>&page=<?= $page - 1 ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a class="page-link" href="?query=<?= urlencode($search_query) ?>&page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
      <li class="page-item">
        <a class="?query=<?= urlencode($search_query) ?>&page=<?= $page + 1 ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>
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
    <script src="jscript/category.js"></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

</body>
</html>