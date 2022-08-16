<?php

session_start();

static $conn;
    if ($conn === NULL){ 
        $conn = mysqli_connect('localhost','root','','socialbook');
    }

$x=$_SESSION['user_id'];
$conn->query("UPDATE `users` SET `users`.`last_activity`=CURRENT_TIMESTAMP WHERE `users`.`user_id`=$x");
session_destroy();
header("location:index.php");
?> 