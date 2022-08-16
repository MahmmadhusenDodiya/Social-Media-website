<?php

$query = mysqli_query($conn, $sql);
if(!$query){
    echo mysqli_error($conn);
}
$width = '168px';
$height = '168px';
if(mysqli_num_rows($query) == 0){
    echo '<div class="userquery">';
    echo 'We couldn\'t find any results for these keywords: ' . $key;
    echo '<br><br>';
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
        
        echo '</div>';
        
        // echo '</center>';
        echo '</div>';
        }
}


?>