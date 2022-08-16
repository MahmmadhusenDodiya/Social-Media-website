<div class="post">

    
    <p class="public">
        <?php if ($row['post_public'] == 'Y') echo 'Public'; else echo 'Private';?>
    
    <br>
    
    <span class="postedtime"><?php echo $row['post_time']; ?> </span>
    </p>


    <div>

    <!-- Including Profile Picture -->
<?php include 'profile_picture.php'; ?>

<?php 
//  delete file code 
// unlink('data\images\posts\AAA.jpg');

echo '<a class="profilelink" href="profile.php?id=' . $row['user_id'] .'">' . $row['user_firstname'] . ' ' . $row['user_lastname'] . '<a>';
echo'</div>';
echo '<br>';
echo '<p class="caption">' . $row['post_caption'] . '</p>';
echo '<center>'; 
$target = glob("data/images/posts/" . $row['post_id'] . ".*");
if($target) {
    echo '<img src="' . $target[0] . '" style="max-width:580px">'; 
    echo '<br><br>';
}

?>
        

        


      <button type="button" <?php  echo 'id=L'.$row['post_id']; ?>  class="Like">
      
        <?php 
         $servername = "localhost";
         $username = "root";
         $password = "";
         $db="socialbook";
         $conn = new mysqli($servername, $username, $password,$db);
         
         if($conn->connect_error)
         {
             die("Connection failed at Counting likes ");
            }
            
            // Like
            // SELECT `post_id`, `user_id` FROM `likes` WHERE `post_id`=2 and `user_id`=1;
            $sqll="SELECT `post_id`, `user_id` FROM `likes` WHERE `post_id`=".$row['post_id']." and `user_id`=".$_SESSION['user_id'];

            $ress=mysqli_query($conn,$sqll);
            // echo $sqll;
            if(mysqli_num_rows($ress)==1)
            {
                echo 'Liked';
            }
            else
            {
                echo 'Like';
            }

            // Make Proper Button
            
            // SELECT COUNT(*) FROM `likes` WHERE `post_id`=2;
            $sqll="SELECT * FROM `likes` WHERE `post_id`=".$row['post_id'];
            
            $ress=mysqli_query($conn,$sqll);
            
            
            
        //  echo $row['user_id'];
      ?>
      </button>

      <?php echo '<div class="likeCnt" id="P'.$row['post_id'].'">'.'('.mysqli_num_rows($ress).')'.'</div>';?>  &nbsp;&nbsp; <?php echo "this is post id=".$row['post_id'];?>
      

        <script>
           
          

            $('<?php echo '#L'.$row['post_id']; ?>').click(
                function()
                {
                    
                    
                    
                    
                    var a=document.querySelector('<?php echo '#L'.$row['post_id']; ?>').textContent;
                    var postid=<?php echo  $row['post_id'] ?>;
                    var userid=<?php echo $_SESSION['user_id'] ?>;
                    var st=document.querySelector('<?php echo '#L'.$row['post_id']; ?>').textContent;
                    st=st.trim();
                    // console.log(userid);
                    // console.log("<=this user likes this post =>");
                    // console.log(postid);
                    // console.log(" and status =>");
                    // console.log(st);
                    // console.log("and its length is ");
                    // console.log(st.length);
                    
                    

                    $.ajax({
                        url: "ajax-like.php",
                        type: "POST",
                        data:{status:st,post_id:postid,user_id:userid},
                        success: function(data)
                        {
                            //console.log(data);
                            document.querySelector('<?php echo '#L'.$row['post_id']; ?>').textContent=((st=="Like")?"Liked":"Like");
                            document.querySelector('<?php echo '#P'.$row['post_id']; ?>').textContent=data;
                            //  console.log("This is data of like=");
                            //  console.log(data);
                        }
                    });
                }
            );
        </script>
        <div class="Comments" <?php  echo 'id=C'.$row['post_id']; ?>   > <?php  $_SESSION['user_id'] ?>Comment</div> 
            
        <button type="button" <?php  echo 'id=D'.$row['post_id']; ?>  <?php if($_SESSION['user_id']!=$row['user_id']) echo 'style=" display:none; "'; ?> class="Delete">Delete</button>
       
            <script>
            $('<?php echo '#D'.$row['post_id']; ?>').click(
                
                function()
                {
                    console.log("Clicked On Delete");
                    
                    var postid=<?php echo  $row['post_id'] ?>;
                    var userid=<?php echo $_SESSION['user_id'] ?>;
                    


                    $.ajax({
                        url: "ajax-delete.php",
                        type: "POST",
                        data:{post_id:postid,user_id:userid},
                        success: function(data)
                        {   console.log(data);
                            location.reload();
                        }
                    });
                }
            );

            </script>

        </center>
</div>

