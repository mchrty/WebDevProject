<?php
session_start();
// ! Prevent access shortcut using link by header
if (!isset($_SESSION['auth']) && isset($_SESSION['role']) != 'admin') {
    header("Location: /WebdevProject/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Dashboard</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
    <!-- ======= Announcement Form ======= -->
    <div class="add-announcement-form" style="position: fixed; top:55%; left: 50%; transform: translate(-50%,-50%); padding: 20px; z-index: 10; background: #fff; box-shadow: 0 3px 5px #0002; border-radius: 5px;">
        <form action="/WebdevProject/Auth/auth.php?announcement=add" method="POST" enctype="multipart/form-data">
            <i class="ri-close-fill close-add-announcement-form" style="position: absolute; top: 0; right: 10px; font-size: 24px;"></i>
            <h3 style="text-align: center;">Add An Announcement</h3>
            <div class="field input-field">
                <input type="text" placeholder="Title" name="add-announcement-title" required>
                <textarea cols="30" rows="10" placeholder="What is the announcement about?" name="add-announcement-content" required></textarea>
                <button type="submit" id="announcement-submit" class="btn btn-primary w-100 my-2">Add</button>
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
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="assets/img/logo.png" alt="" />
                <span class="d-none d-lg-block">Admin</span>
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
                <a class="nav-link" href="announcements.php">
                    <i class="bi bi-megaphone"></i>
                    <span>Announcements</span>
                </a>
            </li>
        </ul>
    </aside>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Announcements</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Announcements</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <button class="add-announcement-btn btn btn-primary">Add Announcement</button>
        <div class="announcement-table"></div>
    </main>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/index.js"></script>
    <script>
        const announcementDiv = document.querySelector(".announcement-table");
        fetch("/webdevproject/Auth/auth.php?fetch=announcements")
            .then((res) => res.json())
            .then((data) => {
                console.log(data)
                let announcementTemplate = `
      <div class="table-responsive" style="margin: 20px 0;">
      <table id="example" style="width:100%" class="text-center table table-striped table-bordered datatable">
        <thead>
          <tr>
            <th scope="col">Title</th>
            <th scope="col">Content</th>
            <th scope="col">Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          ${data
            .map((announcement) => {
              return `
          <tr style="vertical-align: middle;">
            <td>${announcement.title}</td>
            <td>${announcement.content}</td>
            <td>${announcement.createdAt}</td>
            <td style="display:flex;flex-direction: column; gap: 5px;"><a href="/WebdevProject/Auth/auth.php?announcement=delete&id=${
              announcement.id
            }" class="btn btn-danger" onclick="return confirm('Confirm to delete this announcement?')">Delete</a>
            </td>
          </tr>
          `;
            })
            .join("")}
        </tbody>
      </table>
    </div>
      `;
                announcementDiv.insertAdjacentHTML("beforeend", announcementTemplate);
            });
    </script>
</body>

</html>