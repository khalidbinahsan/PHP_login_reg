<?php
 include "header.php";
 include "User.php";
 Session::checkSession(); 
?>
<?php
if(isset($_GET['id'])) { //Get id from index.php view button..
$takeId = (int)$_GET['id'];
$sessId = Session::get('id');
if($takeId != $sessId) {
    header("Location: ../index.php");
}
}
$user = new User();
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cngpwd"])) { //Change User Password...
$cngPassword = $user->cngPassword($takeId, $_POST);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Registration Form</title>
    <link rel="stylesheet" href="../css/style.css" media="all" type="text/css">
</head>

<body>
    <div class="container">
        <div class="form-header">
            <h4>Login Register System PHP OPP & PDO</h4>
            <div class="nav-menu">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
        <div class="form-body">
            <div class="body-head">
                <h2>Change Password</h2>
                <h2>
                    <a class="back-btn" href="profile.php?id=<?php echo $takeId; ?>">Back</a>
                </h2>
            </div>
            <div class="form-container">
                <form class="register-form" action="" method="post">
                    <?php 
                    if(isset($cngPassword)) {
                        echo $cngPassword;
                    }
                    ?>
                    <label for="oldpass">Old Password</label><br>
                    <input id="oldpass" type="password" name="oldpass"><br>
                    <label for="password">New Password</label><br>
                    <input id="password" type="password" name="newpass"><br>
                    <label for="password">Confirm Password</label><br>
                    <input id="password" type="password" name="cnfmpass"><br>
                    <input class="submit-btn" type="submit" name="cngpwd" value="Change">
                </form>
            </div>

        </div>
        <div class="form-footer">
            <h4>Website: <a href="https://www.khalidbinahsan.com">www.khalidbinahsan.com</a></h4>
            <h4>Follow Me: <a href="https://www.facebook.com/khalidbinahsan2">www.focebook.com/khalidbinahsan2</a></h4>
        </div>
    </div>
</body>

</html>