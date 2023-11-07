<?php 
include("../Auth/Auth.php");
$conn;

$user_id = $_GET["edit_user_id"];
$user_firstname = $_GET["edit_user_firstname"];
$user_lastname = $_GET["edit_user_lastname"];
$user_email = $_GET["edit_user_email"];
$user_gender = $_GET["edit_user_gender"];
$user_address = $_GET["edit_user_address"];
$user_status = $_GET["edit_user_login_status"];

$query = "UPDATE users SET firstname = '$user_firstname', lastname = '$user_lastname', emailAddress = '$user_email', address = '$user_address', gender = '$user_gender', status = '$user_status' WHERE id = '$user_id'";

if(mysqli_query($conn, $query)){
    echo "Successfully updated user record.";
    header("Location: index.php");
}else{
    echo "Failed to update user record.";
}
?>