<?php
session_start();
// ! Prevent access shortcut using link by header
if (!isset($_SESSION['auth']) || isset($_SESSION['role']) != 'user' ||  $_SESSION['role'] != 'user') {
  header("Location: /WebdevProject/index.php");
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.gstatic.com" rel="preconnect" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

  <!-- Vendor CSS Files -->
  <link href="../Admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../Admin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
  <link href="../Admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
  <link href="../Admin/assets/vendor/quill/quill.snow.css" rel="stylesheet" />
  <link href="../Admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
  <link href="../Admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
  <link href="../Admin/assets/vendor/simple-datatables/style.css" rel="stylesheet" />

  <!-- Template Main CSS File -->
  <link href="../Admin/assets/css/style.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/CSS/index.css">
  <title>User</title>
</head>

<body>
  <!-- ======= Announcements Div ======= -->
  <div class="announcement-container card">
    <div class="announcement-header">
      <h4>Announcements</h4>
      <button class="btn-close" onclick="announcementBtn.click()" style="width: 40px; height: 40px; position: absolute; right: 10px; top: 0;"></button>
    </div>
    <div class="announcement-div">
    </div>
  </div>
  <!-- ======= Forms Div ======= -->
  <div class="form add-activity-form" style="position: fixed; top:55%; left: 50%; transform: translate(-50%,-50%); padding: 20px; z-index: 10; background: #fff; box-shadow: 0 3px 5px #0002; border-radius: 5px;">
    <form action="/WebdevProject/Auth/auth.php?activity=add" method="POST" enctype="multipart/form-data">
      <i class="ri-close-fill close-add-activity-form" style="position: absolute; top: 0; right: 10px; font-size: 24px;"></i>
      <h3 style="text-align: center;">Add An Activity</h3>
      <div class="field input-field">
        <input type="hidden" name="add-activity-email" value="<?php echo $_SESSION['email']; ?>">
        <div class="form-date">
          <label for="activity-date">Date:</label>
          <input type="date" id="activity-date" name="add-activity-date" required>
        </div>
        <div class="form-time">
          <label for="activity-time">Time:</label>
          <input type="time" id="activity-time" name="add-activity-time" required>
        </div>
        <input type="text" placeholder="Title" name="add-activity-title" required>
        <textarea cols="30" rows="10" placeholder="What is the activity about?" name="add-activity-desc" required></textarea>
        <div>
          <label for="activity-outfit">Outfit For The Activity(Optional):</label>
          <input type="file" id="activity-outfit" accept=".jpg, .jpeg, .png" name="add-activity-img">
        </div>
        <input type="text" name="add-activity-location" placeholder="Activity Location" required>
        <button type="submit" id="activity-submit" class="btn btn-primary w-100 my-2">Add</button>
      </div>
    </form>
  </div>
  <!-- ======= Popup Message ======= -->
  <?php if (isset($_SESSION['popup-message'])) {
    echo '<p class="pop-up-message" style="position: fixed; top: 0; padding: 8px 12px; right: 30%; transform: translateX(-50%); z-index: 100;">' . $_SESSION['popup-message'] . "</p>";
    unset($_SESSION['popup-message']);
  } ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="" />
        <span class="d-none d-lg-block">UltraTask</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword" />
        <button type="submit" title="Search">
          <i class="bi bi-search"></i>
        </button>
      </form>
    </div>
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle" href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['fullname'] ?></span> </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6 style="text-transform: uppercase;"><?php echo $_SESSION['fullname'] ?></h6>
              <span style="text-transform: capitalize;"><?php echo $_SESSION['role'] ?></span>
            </li>
            <li>
              <hr class="dropdown-divider" />
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="../Auth/Auth.php?action=logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
          </ul>
          <!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->
      </ul>
    </nav>
    <!-- End Icons Navigation -->
  </header>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="activities-btn nav-link" href="#">
          <i class="bi bi-journal-check"></i>
          <span>Activities</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="manage-activities-btn nav-link" href="#">
          <i class="bi bi-journal-check"></i>
          <span>Manage Activities</span>
        </a>
      </li>
    </ul>
  </aside>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->


    <!-- // ! Main -->
    <div class="main">
      <h4>Upcoming Activity</h4>
      <div class="dashboard-section d-flex justify-content-center">
        <div class="latest-section"></div>
        <div class="main-tools">
          <button type="button" class="add-activity-btn btn btn-outline-success">
            <i class="ri-edit-2-fill"></i>
            <p>Create Activity</p>
          </button>
          <button type="button" class="manage-activity-alt-btn btn btn-outline-primary">
            <i class="ri-edit-2-fill"></i>
            <p>Manage Activities</p>
          </button>
          <button type="button" class="delete-activity-alt-btn btn btn-outline-danger">
            <i class="ri-edit-2-fill"></i>
            <p>Delete An Activity</p>
          </button>
          <button type="button" class="view-activities-alt-btn btn btn-outline-success">
            <i class="ri-edit-2-fill"></i>
            <p>View All Activities</p>
          </button>
        </div>
      </div>
      <div class="row gap-2">
        <div class="col card" style="padding: 0 !important; height: auto !important; flex: none; width: 230px;">
          <img src="assets/activity.jpg" class="card-img-top" alt="Hollywood Sign on The Hill" />
          <h5 class="activity-today card-title" style="text-align: center; margin-top: 5px;"></h5>
        </div>
        <div class="col card" style="padding: 0 !important; height: auto !important; flex: none; width: 230px;">
          <img src="assets/activity.jpg" class="card-img-top" alt="Hollywood Sign on The Hill" />
          <h5 class="activity-ahead card-title" style="text-align: center; margin-top: 5px;"></h5>
        </div>
        <div class="announcements-card col card" style="cursor: pointer;padding: 0 !important; height: auto !important; flex: none; width: 230px;">
          <img src="assets/activity.jpg" class="card-img-top" alt="Hollywood Sign on The Hill" />
          <h5 class="announcement-count activity-ahead card-title" style="text-align: center; margin-top: 5px;"></h5>
        </div>
      </div>
    </div>
    <!-- Vendor JS Files -->
    <script src="../Admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="../Admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../Admin/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="../Admin/assets/vendor/echarts/echarts.min.js"></script>
    <script src="../Admin/assets/vendor/quill/quill.min.js"></script>
    <script src="../Admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="../Admin/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="../Admin/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../Admin/assets/js/main.js"></script>
    <script src="assets/JS/index.js"></script>
</body>

</html>