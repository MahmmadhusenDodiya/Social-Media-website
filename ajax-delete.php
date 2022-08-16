<?php

    $user=$_POST['user_id'];
    $post=$_POST['post_id'];


    $servername = "localhost";
    $username = "root";
    $password = "";
    $db="socialbook";
    $conn = new mysqli($servername, $username, $password,$db);




    // Check connection
    if ($conn->connect_error) {
        
        die("Connection failed: " . $conn->connect_error);
    }
    else 
    {
        // echo "Connected successfully";
    }


    $conn->query("UPDATE `users` SET `users`.`last_activity`=CURRENT_TIMESTAMP WHERE `users`.`user_id`='$user'");
    
    $conn->query("DELETE FROM `likes` WHERE `likes`.`post_id`=$post");
    $conn->query("DELETE FROM `Posts` WHERE `Posts`.`post_id`=$post");
    
    
    
    ?>
