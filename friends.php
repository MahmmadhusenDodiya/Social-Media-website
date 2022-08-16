<?php 
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
    <style>
    .frame a{
        text-decoration: none;
        color: #4267b2;
    }
    .frame a:hover{
        text-decoration: underline;
    }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'includes/navbar.php'; ?>
        <h1 style="margin-top: 5vh;">My Friends</h1>
        <?php
            // echo '<center>'; 
            $sql = "SELECT *
                    FROM users
                    JOIN (
                        SELECT friendship.user1_id AS user_id
                        FROM friendship
                        WHERE friendship.user2_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                        UNION
                        SELECT friendship.user2_id AS user_id
                        FROM friendship
                        WHERE friendship.user1_id = {$_SESSION['user_id']} AND friendship.friendship_status = 1
                    ) userfriends
                    ON userfriends.user_id = users.user_id";
            $query = mysqli_query($conn, $sql); 
            if($query){
                if(mysqli_num_rows($query) == 0){
                    echo '<div class="post">';
                    echo 'You do not have any friends Yet!!.';
                    echo '</div>';
                } else {
                    while($row = mysqli_fetch_assoc($query)){
                    echo '<div class="frame">';
                    // echo '<center>';
                    
                    echo '<div class="subDivOfFriendList">';
                    // include 'includes/profile_picture.php';
                    $target = glob("data/images/profiles/" . $row['user_id'] . ".*");
                    if($target) {
                        echo '<img class="FriendListImg" src="' . $target[0].'">'; 
                    } else {
                        if($row['user_gender'] == 'M') {
                            echo '<img class="FriendListImg" src="data/images/profiles/M.jpg">';
                        } else if ($row['user_gender'] == 'F') {
                            echo '<img class="FriendListImg" src="data/images/profiles/F.jpg">';
                        }
                    }
                    
                    echo '</div>';
                    
                    // echo '<br>';

                    echo '<div class="subDivOfFriendList" id="showFriends">';
                    echo '<a href="profile.php?id=' . $row['user_id'] . '">' .'User Name: '. $row['user_firstname'] . ' ' . $row['user_lastname'] . '</a>';
                    // echo '<br>';
                    echo '<br><br>About: '. ($row['user_about']); 
                    echo '<br><br>Gender : '.(($row['user_gender']=='F')?"Female":"Male");
                    echo '<br><br>Home Town: '.($row['user_hometown']);
                    $Qmutual="SELECT `user2_id` FROM `friendship` WHERE `user1_id`=".$row['user_id']." and `friendship_status`=1 and `user2_id` IN (
                        SELECT `user2_id` FROM `friendship` WHERE `user1_id`=".$_SESSION['user_id']." and `user2_id`!=".$row['user_id']." and `friendship_status`=1)";
                    
                    // echo $Qmutual;
                    
                    $ResMutul= mysqli_query($conn, $Qmutual);  
                    $CountOfTotalMutulFriend=mysqli_num_rows($ResMutul);
                    echo '<br><br>mutual Friends:'.$CountOfTotalMutulFriend.'<a href="">';
                    echo '</div>';
                    
                    // echo '</center>';
                    echo '</div>';
                    }
                }
            }
            // echo '</center>';
        ?>
    </div>
</body>
</html>