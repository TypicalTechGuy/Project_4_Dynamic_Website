<?php
include("php/session_handler.php");
include("php/db_connect.php");
include("php/user_detail.php");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$totalArticles = $conn->query("SELECT COUNT(*) as count FROM articles")->fetch_assoc()['count'];
$registeredUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$registeredAuthors = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'author'")->fetch_assoc()['count'];
$authorRequests = $conn->query("SELECT COUNT(*) as count FROM authorrequest")->fetch_assoc()['count'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Pages | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="AdminLTE/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="AdminLTE/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="AdminLTE/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="AdminLTE/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="css/adminpagestyling.css">
  <script>
    function loadMoreInfo(type) {
      var infoContent = document.getElementById('infoContent');
      var articlesTable = document.getElementById('articlesTable');
      var usersTable = document.getElementById('usersTable');
      var authorsTable = document.getElementById('authorsTable');
      var authorRequestsTable = document.getElementById('authorRequestsTable');

      // Hide all the tables
      articlesTable.style.display = 'none';
      usersTable.style.display = 'none';
      authorsTable.style.display = 'none';
      authorRequestsTable.style.display = 'none';

      // Display the relevant table based on the clicked button
      if (type === 'articles') {
        articlesTable.style.display = 'block';
      } else if (type === 'users') {
        usersTable.style.display = 'block';
      } else if (type === 'authors') {
        authorsTable.style.display = 'block';
      } else if (type === 'authorRequests') {
        authorRequestsTable.style.display = 'block';
      }

      infoContent.style.display = 'block';
    }
  </script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      <img src="AdminLTE/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-light">Admin Dashboard</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <a href="#" class="d-block"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></a>
        </div>
      </div>
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
          </li>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div>
        </div>
      </div>
    </div>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $totalArticles; ?></h3>
                <p>Total Articles</p>
              </div>
              <div class="icon">
                <i class="ion ion-document"></i>
              </div>
              <a href="javascript:void(0);" class="small-box-footer" onclick="loadMoreInfo('articles')">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $registeredUsers; ?></h3>
                <p>Registered Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="javascript:void(0);" class="small-box-footer" onclick="loadMoreInfo('users')">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $registeredAuthors; ?></h3>
                <p>Registered Authors</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-stalker"></i>
              </div>
              <a href="javascript:void(0);" class="small-box-footer" onclick="loadMoreInfo('authors')">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $authorRequests; ?></h3>
                <p>Author Requests</p>
              </div>
              <div class="icon">
                <i class="ion ion-email"></i>
              </div>
              <a href="javascript:void(0);" class="small-box-footer" onclick="loadMoreInfo('authorRequests')">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>

        <!-- Area to Display More Info -->
        <div id="infoContent" style="display:none; margin-top:20px;">
          <div id="articlesTable" style="display:none;">
            <h3>Articles Table</h3>
            <?php
              $result = $conn->query("SELECT * FROM articles");
              if ($result->num_rows > 0) {
                  echo "<table class='table table-bordered'><thead><tr><th>ID</th><th>Title</th></tr></thead><tbody>";
                  while($row = $result->fetch_assoc()) {
                      echo "<tr><td>".$row['id']."</td><td>".$row['title']."</td></tr>";
                  }
                  echo "</tbody></table>";
              } else {
                  echo "No articles found.";
              }
            ?>
          </div>

          <div id="usersTable" style="display:none;">
            <h3>Users Table</h3>
            <?php
              $result = $conn->query("SELECT * FROM users");
              if ($result->num_rows > 0) {
                  echo "<table class='table table-bordered'><thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th></tr></thead><tbody>";
                  while($row = $result->fetch_assoc()) {
                      echo "<tr><td>".$row['user_id']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['email']."</td><td>".$row['role']."</td></tr>";
                  }
                  echo "</tbody></table>";
              } else {
                  echo "No users found.";
              }
            ?>
          </div>

          <div id="authorsTable" style="display:none;">
            <h3>Authors Table</h3>
            <?php
              $result = $conn->query("SELECT * FROM users WHERE role = 'author'");
              if ($result->num_rows > 0) {
                  echo "<table class='table table-bordered'><thead><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Role</th></tr></thead><tbody>";
                  while($row = $result->fetch_assoc()) {
                      echo "<tr><td>".$row['user_id']."</td><td>".$row['first_name']."</td><td>".$row['last_name']."</td><td>".$row['email']."</td><td>".$row['role']."</td></tr>";
                  }
                  echo "</tbody></table>";
              } else {
                  echo "No authors found.";
              }
            ?>
          </div>

          <div id="authorRequestsTable" style="display:none;">
            <h3>Author Requests Table</h3>
            <?php
              $result = $conn->query("SELECT * FROM authorrequest");
              if ($result->num_rows > 0) {
                  echo "<table class='table table-bordered'><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Status</th></tr></thead><tbody>";
                  while($row = $result->fetch_assoc()) {
                      echo "<tr><td>".$row['RequestID']."</td><td>".$row['AuthorName']."</td><td>".$row['Email']."</td><td>".$row['Status']."</td></tr>";
                  }
                  echo "</tbody></table>";
              } else {
                  echo "No author requests found.";
              }
            ?>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
</body>
</html>
