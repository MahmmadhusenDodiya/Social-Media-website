<?php

    $status= $_POST['curr_status'];
    $u2=$_POST['u1'];
    $u1=$_POST['u2'];

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
        // echo 'console.log("KK2")';
        // echo "Connected successfully";
}

    
// INSERT INTO `friendship` (`user1_id`, `user2_id`, `friendship_status`) VALUES ('3', '7', '0');


    if($status=='Unfriend') // remove from friend
    {   $conn->query("DELETE FROM `friendship` WHERE (user1_id='$u1' and user2_id='$u2')");
        $conn->query("DELETE FROM `friendship` WHERE (user1_id='$u2' and user2_id='$u1')");
        echo 'send Friend Request';
    }
    else if($status=='Request Panding,cancle it?')
    {   
        // DELETE FROM `friendship` WHERE user1_id=4 and user2_id=3;
        $conn->query("DELETE FROM `friendship` WHERE (user1_id='$u1' and user2_id='$u2')");
        $conn->query("DELETE FROM `friendship` WHERE (user1_id='$u2' and user2_id='$u1')");
        echo 'send Friend Request';
    }
    else if($status=='send Friend Request')
    {   
        // u1 = sender
        // u2 = recver
        $conn->query("INSERT INTO `friendship` (`user1_id`, `user2_id`,`sender_id`,`friendship_status`) VALUES ('$u1', '$u2','$u1', '0')");
        $conn->query("INSERT INTO `friendship` (`user1_id`, `user2_id`,`sender_id`,`friendship_status`) VALUES ('$u2', '$u1','$u1', '0')");
        echo 'Request Panding,cancle it?';

    }

    $conn->query("UPDATE `users` SET `users`.`last_activity`=CURRENT_TIMESTAMP WHERE `users`.`user_id`='$u1'");



?>
