<?php
//
require 'functions/functions.php';
session_start();
// Check whether user is logged on or not
if (!isset($_SESSION['user_id'])) {
    header("location:index.php");
}
// Establish Database Connection
$conn = connect();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Book</title>
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
        <h1>Search Results</h1>
        <?php
            $location = $_GET['location'];
            $key = $_GET['query'];
           if($location == 'names') {
                $name = explode(' ', $key, 2); // Break String into Array.
                if(empty($name[1])) {
                    $sql = "SELECT * FROM users WHERE users.user_firstname = '$name[0]' OR users.user_lastname= '$name[0]'";
                } else {
                    $sql = "SELECT * FROM users WHERE users.user_firstname = '$name[0]' AND users.user_lastname= '$name[1]'";
                }
                include 'includes/userquery.php';
            } else if($location == 'hometowns') { 
                $sql = "SELECT * FROM users WHERE users.user_hometown = '$key'";
                include 'includes/userquery.php';
            }     
        ?>
    </div>
</body>
</html>
