<?php
include("php/session_handler.php");
include("php/db_connect.php");
include("php/user_detail.php");

$articles_per_row = 2;
$rows_per_page = 2;
$articles_per_page = $articles_per_row * $rows_per_page;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $articles_per_page;

$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : null;

if ($category) {
    $total_articles_query = "SELECT COUNT(*) as total FROM articles WHERE category = ?";
    $stmt = $conn->prepare($total_articles_query);
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_articles = $result->fetch_assoc()['total'];

    $query = "SELECT id, title, content, image_url, category, published_date FROM articles WHERE category = ? LIMIT ?, ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sii", $category, $offset, $articles_per_page);
} else {
    $total_articles_query = "SELECT COUNT(*) as total FROM articles";
    $result = $conn->query($total_articles_query);
    $total_articles = $result->fetch_assoc()['total'];

    $query = "SELECT id, title, content, image_url, category, published_date FROM articles LIMIT $offset, $articles_per_page";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

$total_pages = ceil($total_articles / $articles_per_page);
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


    <header class="container mt-4">
      <h1 id="main">Welcome to Gaming Corner</h1>
      <p id="sub">Your daily source for the latest gaming news, reviews, and more.</p>
    </header>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
      const category = "<?= $category ?>";
      const mainHeading = document.getElementById("main");
      const subHeading = document.getElementById("sub");

      const messages = {
        Console: {
          main: "Console",
          sub: "Discover the latest in console games and hardware.",
        },
        PC: {
          main: "PC",
          sub: "Get the best tips, tricks, and reviews for PC games.",
        },
        Retro: {
          main: "Retro",
          sub: "Celebrate the classics that shaped the gaming world.",
        },
        Arcade: {
          main: "Arcade",
          sub: "Step into the nostalgia of arcade gaming adventures.",
        },
      };

      if (category && messages[category]) {
        mainHeading.textContent = messages[category].main;
        subHeading.textContent = messages[category].sub;
      }
    });
    </script>

  <section class="main-content container mt-4">
  <div class="article-grid">
    <?php if ($result && $result->num_rows > 0): ?>
      <?php $count = 0; ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php if ($count % $articles_per_row == 0): ?>
          <div class="article-row">
        <?php endif; ?>

        <article class="article">
        <a href="articlepages/createarticlepage.php?id=<?php echo $row['id']; ?>">
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

        <?php $count++; ?>
        <?php if ($count % $articles_per_row == 0 || $count == $result->num_rows): ?>
          </div>
        <?php endif; ?>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No articles found. Please check back later.</p>
    <?php endif; ?>
  </div>
</section>

  <nav aria-label="Page navigation">
  <ul class="pagination">
    <?php if ($page > 1): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <li class="page-item <?= $i == $page ? 'active' : '' ?>">
        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
      <li class="page-item">
        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>

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