<?php
echo '<div class="profile">';
echo '<center>';
$row = mysqli_fetch_assoc($profilequery);
// echo "<pre>";



// Count Total Like 
$Qlike='SELECT * from `likes` WHERE `post_id` IN (SELECT `post_id` FROM `posts` WHERE `post_by`='.$row['user_id'].')';
$ResLike= mysqli_query($conn, $Qlike);  
$CountOfTotalLikes=mysqli_num_rows($ResLike);


// Count Total Friends
// echo $row['user_id'];
// SELECT * FROM `friendship` WHERE (`user1_id`=1 or `user2_id`=1) and `friendship_status`=1; 
$Qlike='SELECT * FROM `friendship` WHERE (`user1_id`='.$row['user_id'].') and `friendship_status`=1';
// echo "this is query".$Qlike."<br>";
$ResFriend= mysqli_query($conn, $Qlike);  
$CountOfTotalFriend=mysqli_num_rows($ResFriend);

// echo '<pre>';
// print_r($_SESSION);
// print_r($row['user_id']);
// echo '</pre>';



// SELECT * FROM `users` WHERE `user_id` IN 
// (SELECT DISTINCT `user2_id` FROM `friendship`
// WHERE (`user1_id`=1 or `user1_id`=3) and `user2_id`!=1 and `user2_id`!=3);
$Qmutual="SELECT `user2_id` FROM `friendship` WHERE `user1_id`=".$row['user_id']." and `friendship_status`=1 and `user2_id` IN (
    SELECT `user2_id` FROM `friendship` WHERE `user1_id`=".$_SESSION['user_id']." and `user2_id`!=".$row['user_id']." and `friendship_status`=1)";

// echo $Qmutual;

$ResMutul= mysqli_query($conn, $Qmutual);  
$CountOfTotalMutulFriend=mysqli_num_rows($ResMutul);



// Name and Nickname
if(!empty($row['user_nickname']))
    echo $row['user_firstname'] . ' ' . $row['user_lastname'] . ' (' . $row['user_nickname'] . ')';
else
    echo $row['user_firstname'] . ' ' . $row['user_lastname'];
echo '<br>';
// Profile Info & View
$width = '168px';

$height = '168px';
include 'includes/profile_picture.php';
echo '<br>';
// Gender
echo "Gender:<strong>";
if($row['user_gender'] == "M")
   {  
       
       echo 'Male';
   }
else if($row['user_gender'] == "F")
  {
      echo 'Female';
  }
echo '</strong><br>';
// Status
echo "Marital status: <strong>";
if(!empty($row['user_status'])){
    if($row['user_status'] == "S")
        echo 'Single';
    else if($row['user_status'] == "E")
        echo 'Engaged';
    else if($row['user_status'] == "M")
        echo 'Married';
    echo '</strong><br>';
}
// Birthdate
echo "Date Of Birth: <strong>";
echo $row['user_birthdate'];
echo "</strong><br>";

// Last Activity
echo "Last Activity:<strong>";
echo $row['last_activity'];
echo "</strong>";


// Additional Information
if(!empty($row['user_hometown'])){
    echo '<br>Home Town:<strong>';
    echo $row['user_hometown'].'</strong>';
}
if(!empty($row['user_about'])){
    echo '<br>';
    echo $row['user_about'];
}
echo '<br>';
echo "Total Likes:<u><strong>".$CountOfTotalLikes."</u></strong>"; 
echo "<br>Total Friends :<u><strong>".$CountOfTotalFriend."</u></strong>"; 


if($row['user_id']!=$_SESSION['user_id'])
{   
    // Printing Mutual Friends here
    echo "<br><br>Mutual friends:".$CountOfTotalMutulFriend;
    if($CountOfTotalMutulFriend!=0)
    {
        $sqlForMutulFriends="SELECT * FROM `users` WHERE `user_id` IN (SELECT `user2_id` FROM `friendship` WHERE `user1_id`=".$row['user_id']." and `friendship_status`=1 and `user2_id` IN (
            SELECT `user2_id` FROM `friendship` WHERE `user1_id`=".$_SESSION['user_id']." and `user2_id`!=".$row['user_id']." and `friendship_status`=1))";
        
        // echo $sqlForMutulFriends;
        $sqlForMutulFriends = mysqli_query($conn, $sqlForMutulFriends);  
        // $rowForMutulFriends = mysqli_fetch_assoc($sqlForMutulFriends);
        echo '<details><summary>This is Mutual Friends:</summary>';
            $num=1;
            while($rowForMutulFriends = mysqli_fetch_assoc($sqlForMutulFriends)){
                echo $num.'.'.$rowForMutulFriends['user_firstname'].' '.$rowForMutulFriends['user_lastname'];
                echo '<br>';
                $num++;

            }
        
        echo '</details>';
    }
}

// CountOfTotalFriend

// Friendship Status

    
        
    // </div>
if($isNotMyProfile == 1){
    echo '<br><br>';
    echo '<button type="button" id="bbtn">';



    if(isset($row['friendship_status'])) {
        if($row['friendship_status'] == 1){



            echo 'Unfriend';

        } else if ($row['friendship_status'] == 0){
            echo 'Request Panding,cancle it?';

        }
    } else {
        echo 'send Friend Request';

    }
    echo '</button>';
}

echo '<center>'; 

echo'</div>';


// showing users mobile number and other information
$query4 = mysqli_query($conn, "SELECT * FROM user_phone WHERE user_id = {$row['user_id']}");
if(!$query4){
    // 
    echo mysqli_error($conn);
}
if(mysqli_num_rows($query4) > 0){
    echo '<br>';
    echo '<div class="profile">';
    echo '<center class="changeprofile">'; 
    echo 'Phones:';
    echo '<br>';
    while($row4 = mysqli_fetch_assoc($query4)){
        echo $row4['user_phone'];
        echo '<br>';
    }
    echo '</center>';
    echo '</div>';
}

?>