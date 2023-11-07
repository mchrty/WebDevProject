<?php
// ! Start Session
session_start();

// ! Establish Connection To Database
$dbName = "sd_208";
$conn = mysqli_connect("localhost", "root", "", $dbName);

if ($conn->error) {
    return;
}

// ! Establish GET Listeners
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action === 'logout') {
        logoutAuth($conn);
    } elseif ($action === 'login') {
        loginAuth($conn);
    } elseif ($action === 'register') {
        registerAuth($conn);
    }
}

// ! Identification Functions
function loginAuth($conn)
{
    // ! Get Values
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    $sql = "SELECT * FROM users WHERE emailAddress = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) {
            toggleAuthStatus($conn, $user['id'], "inactive");
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['auth'] = true;
            $_SESSION['email'] = $email;
            $_SESSION['fullname'] = $user['firstname'] . " " . $user['lastname'];
            if ($_SESSION['role'] === 'admin') {
                $_SESSION['popup-message'] = "Welcome Back Admin.";
                header('Location: /WebdevProject/Admin/index.php');
            } else {
                $_SESSION['popup-message'] = "Welcome, " . $_SESSION['fullname'];
                header("Location: /WebdevProject/User/index.php");
            }
        } else {
            $_SESSION['popup-message'] = "Invalid Email or Password Incorrect.";
            header("Location: /WebdevProject/login.php");
        }
    } else {
        $_SESSION['popup-message'] = "Invalid Email or Password Incorrect.";
        header("Location: /WebdevProject/login.php");
    }
}

function logoutAuth($conn)
{
    if (isset($_SESSION['id'])) {
        toggleAuthStatus($conn, $_SESSION['id'], "active");
    }
    session_destroy();
    header("Location: /WebdevProject/index.php");
}
function registerAuth($conn)
{
    $firstname = $_POST['reg-firstname'];
    $lastname = $_POST['reg-lastname'];
    $email = $_POST['reg-email'];
    $address = $_POST['reg-address'];
    $password = $_POST['reg-password'];
    $gender = $_POST['reg-gender'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (firstname, lastname, emailAddress, address, gender, password) VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $address, $gender, $password);

    if ($stmt->execute()) {
        $_SESSION['role'] = 'user';
        $_SESSION['auth'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['fullname'] = $firstname . " " . $lastname;
        $_SESSION['popup-message'] = "Welcome, " . $_SESSION['fullname'];
        header("Location: /WebdevProject/User/index.php");
    }

    $stmt->close();
    $conn->close();
}
// ! Fetch Listeners
if (isset($_GET['fetch'])) {
    $action = $_GET['fetch'];
    if ($action === 'activities') {
        fetchData($conn, "activities", "WHERE activityOwner = '" . $_SESSION['email'] . "' ORDER BY (status = 'done'), activityDate");
    } elseif ($action === 'users') {
        fetchData($conn, "users", "");
    } elseif ($action === 'all') {
        fetchData($conn, "activities", "");
    } elseif ($action === 'announcements') {
        fetchData($conn, "announcements", "");
    }
}

function fetchData($conn, $table, $filter)
{
    $sql = "SELECT * FROM $table $filter";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $conn->close();

    $json_data = json_encode($data);
    echo $json_data;
}

// ! Activity Listeners
if (isset($_GET['activity'])) {
    $action = $_GET['activity'];
    if ($action === 'add') {
        addActivity($conn);
    } elseif ($action === 'delete') {
        deleteActivity($conn, $_GET['id']);
    } elseif ($action === 'toggle') {
        toggleState($conn, $_GET['id'], $_GET['status']);
    } elseif ($action === 'edit') {
        editActivity($conn, $_GET['id']);
    }
}

// ! Activity Functions
function addActivity($conn)
{
    $date = $conn->real_escape_string($_POST['add-activity-date']);
    $time = $conn->real_escape_string($_POST['add-activity-time']);
    $title = $conn->real_escape_string($_POST['add-activity-title']);
    $desc = $conn->real_escape_string($_POST['add-activity-desc']);
    $email = $conn->real_escape_string($_POST['add-activity-email']);
    $location = $conn->real_escape_string($_POST['add-activity-location']);

    if (isset($_FILES['add-activity-img']) && $_FILES['add-activity-img']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['add-activity-img'];
        $imgName = $img['name'];

        $destination = "uploads/$imgName";
        if (move_uploaded_file($img['tmp_name'], $destination)) {
            // Image has been successfully uploaded
        }
    } else {
        $destination = NULL; // No image uploaded
    }

    $sql = "INSERT INTO activities (activityDate, activityTime, activityName, activityDesc, activityLocation,activityImg, activityOwner) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $date, $time, $title, $desc, $location, $destination, $email);

    if ($stmt->execute()) {
        $_SESSION['popup-message'] = "Activity Successfully Added.";
    } else {
        $_SESSION['popup-message'] = "Something went wrong.";
    }

    $stmt->close();
    $conn->close();

    header("Location: /WebdevProject/User/index.php");
}

function deleteActivity($conn, $id)
{
    $stmt = mysqli_prepare($conn, "DELETE FROM activities WHERE activityId = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Activity with ID $id has been deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $_SESSION['popup-message'] = "Activity Deleted Successfully.";
    header("Location: /WebdevProject/User/index.php");
}

function toggleState($conn, $id, $status)
{
    $newStatus = "";
    if (strtolower($status) === 'pending') {
        $newStatus = "done";
    } else $newStatus = "pending";
    $stmt = mysqli_prepare($conn, "UPDATE activities SET status = '$newStatus' WHERE activityId = $id");
    if (mysqli_stmt_execute($stmt)) {
        echo "Activity with ID $id has been deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $_SESSION['popup-message'] = "Activity Status Updated Successfully.";
    header("Location: /WebdevProject/User/index.php");
}

function toggleAuthStatus($conn, $id, $status)
{
    $newStatus = "";
    if (strtolower($status) === 'active') {
        $newStatus = "inactive";
    } else $newStatus = "active";
    $stmt = mysqli_prepare($conn, "UPDATE users SET status = '$newStatus' WHERE id = $id");
    if (mysqli_stmt_execute($stmt)) {
        echo "Activity with ID $id has been deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

function editActivity($conn, $id)
{
    $date = $conn->real_escape_string($_POST['add-activity-date']);
    $time = $conn->real_escape_string($_POST['add-activity-time']);
    $title = $conn->real_escape_string($_POST['add-activity-title']);
    $desc = $conn->real_escape_string($_POST['add-activity-desc']);
    $email = $conn->real_escape_string($_POST['add-activity-email']);
    $location = $conn->real_escape_string($_POST['add-activity-location']);

    $destination = null;
    if (isset($_FILES['edit-activity-img'])) {
        $img = $_FILES['edit-activity-img'];

        if ($img['error'] === UPLOAD_ERR_OK) {
            $imgName = $img['name'];
            $imgTmpName = $img['tmp_name'];

            $uploadDirectory = "uploads/";
            $destination = $uploadDirectory . $imgName;
            if (move_uploaded_file($imgTmpName, $destination)) {
                // New image has been successfully uploaded
            }
        }
    }

    $sql = "UPDATE activities SET activityDate = ?, activityTime = ?, activityName = ?, activityDesc = ?, activityLocation = ?,activityImg = ? WHERE activityId = ? AND activityOwner = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssis", $date, $time, $title, $desc, $location, $destination, $id, $email);

    if ($stmt->execute()) {
        echo "updated success";
        $_SESSION['popup-message'] = "Activity Successfully Updated.";
        header("Location: /WebdevProject/User/index.php");
    } else {
        echo " somethignwent wrong";
        $_SESSION['popup-message'] = "Something went wrong.";
        header("Location: /WebdevProject/User/index.php");
    }

    $stmt->close();
    $conn->close();
}

// ! Activity Listeners
if (isset($_GET['announcement'])) {
    $action = $_GET['announcement'];
    if ($action === 'add') {
        addAnnouncement($conn);
    } elseif ($action === 'delete') {
        deleteAnnouncement($conn, $_GET['id']);
    }
}

function addAnnouncement($conn)
{
    $title = $conn->real_escape_string($_POST['add-announcement-title']);
    $content = $conn->real_escape_string($_POST['add-announcement-content']);

    $sql = "INSERT INTO announcements (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        $_SESSION['popup-message'] = "Announcement Successfully Added.";
    } else {
        $_SESSION['popup-message'] = "Something went wrong.";
    }

    $stmt->close();
    $conn->close();

    header("Location: /WebdevProject/Admin/index.php");
}
function deleteAnnouncement($conn, $id)
{
    $stmt = mysqli_prepare($conn, "DELETE FROM announcements WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if (mysqli_stmt_execute($stmt)) {
        echo "Activity with ID $id has been deleted successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $_SESSION['popup-message'] = "Activity Deleted Successfully.";
    header("Location: /WebdevProject/Admin/index.php");
}