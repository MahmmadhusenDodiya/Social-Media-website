<h1>Your Mail id is Not Verified so please verify it</h1>
<?php
    
    session_start();
    require 'functions/functions.php';
    //echo "Your Random Genrated Pin is =".$_SESSION['randomPin']." \n";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Book</title>
    <link rel="stylesheet" type="text/css" href="resources/css/main.css">
    <style>
        .container{
            margin: 40px auto;
            width: 60vw;

        }
        .content {
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 5px #4267b2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tab">
            <h3>Verify Email:An Email has been sent on Your email [<?php echo $_SESSION['V_Email'] ?>]</h3>
        </div>
        <div class="content">
            <div class="tabcontent" id="signin">
                <form method="post" onsubmit="return validateLogin()">
                    
                    <label>Enter Pin<span>*</span></label><br>
                    <input type="Number" name="userpin" id="userpin">
                    <div class="required"></div>
                    <br><br>
                    <input type="submit" value="Verify" name="Verify">
                </form>
            </div>

        </div>
    </div>
</body>
</html>


<?php
$conn = connect();
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // A form is posted
    if (isset($_POST['Verify'])) {        // Email Verify process
        $useremail=$_SESSION['V_Email'];
        $userpin=$_POST['userpin'];
        $randomPin=$_SESSION['randomPin'];

        //echo "Your Pin is =".$userpin." ok \n";

        if($userpin==$randomPin)
        {

            // Mark Email as Verified

            $query=mysqli_query($conn, "SELECT * FROM users WHERE user_email = '$useremail'");
            mysqli_query($conn,"UPDATE users
            SET Email_Verified = 1
            WHERE user_email = '$useremail'");
    
            if($query){
                $row = mysqli_fetch_assoc($query);

                if(mysqli_num_rows($query) == 1 ) {


                    if($row['Email_Verified']==1)
                    {

                        $row = mysqli_fetch_assoc($query);
                        $_SESSION['user_id'] = $row['user_id'];
                        $_SESSION['user_name'] = $row['user_firstname'] . " " . $row['user_lastname'];
                        header("location:home.php");
                    }
                    else
                    {
                        
                    }
                }
            } 
            else
            {
                echo mysqli_error($conn);
            }
        }
        else
        {
            echo "Wrong Pin \n";
        }
    }
    
}
?>
