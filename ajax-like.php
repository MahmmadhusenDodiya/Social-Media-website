<?php

    $ss= $_POST['status'];
    $user=$_POST['user_id'];
    $post=$_POST['post_id'];
    // die("Sorry");


    $servername = "localhost";
    $username = "root";
    $password = "";
    $db="socialbook";
    // Create connection
    $conn = new mysqli($servername, $username, $password,$db);




    // Check connection
    if ($conn->connect_error) {
        
        die("Connection failed: " . $conn->connect_error);
    }
    else 
    {
        // echo "Connected successfully";
    }


    

    
    
    
    if($ss=='Like')
    {   
        $conn->query("INSERT INTO `likes` (`post_id`, `user_id`) VALUES ('$post', '$user')");
        // UPDATE `users` SET `last_activity`=CURRENT_TIMESTAMP WHERE 1;
        $conn->query("UPDATE `users` SET `users`.`last_activity`=CURRENT_TIMESTAMP WHERE `users`.`user_id`='$user'");

        // echo 'Liked';

        
    }
    else
    {
        $conn->query("DELETE FROM `likes` WHERE `likes`.`post_id` = '$post' AND `likes`.`user_id` = '$user'");
        $conn->query("UPDATE `users` SET `users`.`last_activity`=CURRENT_TIMESTAMP WHERE `users`.`user_id`='$user'");
        // echo 'Like';
    }
    
    $sqll="SELECT * FROM `likes` WHERE `post_id`=".$post;
    $ress=mysqli_query($conn,$sqll);
    echo '('.mysqli_num_rows($ress).')';
    
    ?>
