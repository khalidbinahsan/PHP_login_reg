<?php
include "User.php";
include "header.php";
Session::checkSession();
// $user = new User();
?>
<?php
if(isset($_GET['id'])) { //Get id from index.php view button..
$takeId=(int)$_GET['id'];
}
$user = new User();
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) { //Update User Profile...
$updatePro = $user->updateData($takeId, $_POST);
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
<!-- ==== Logout Script ==== -->
<?php 
    if(isset($_GET['action']) && $_GET['action'] == 'logout') {
        Session::destroyProfile();
    }
?>
<body>
    <div class="container">
        <div class="form-header">
            <h4>Login Register System PHP OPP & PDO</h4>
            <div class="nav-menu">
                <a href="../index.php">Home</a>
                <a href="#">Profile</a>
                <a href="?action=logout">Logout</a>
            </div>
        </div>
        <div class="form-body">
            <div class="body-head">
                <h2>User Profile</h2>
                <h2><a class="back-btn" href="../index.php">Back</a></h2>
            </div>
            <?php
                $insertPro = $user->getUserById($takeId);
                if($insertPro) {
            ?>
            <div class="form-container">
                <form class="register-form" action="" method="post">
                <?php 
                if(isset($updatePro)) {
                echo $updatePro;
                }
                ?>
                    <label for="name">Your Name</label><br>
                    <input id="name" type="text" name="name" value="<?php echo $insertPro->name; ?>"><br>
                    <label for="uname">Username</label><br>
                    <input id="uname" type="text" name="uname" value="<?php echo $insertPro->uname; ?>"><br>
                    <label for="email">Email Address</label><br>
                    <input id="email" type="email" name="email" value="<?php echo $insertPro->email; ?>"><br>
                    <?php 
                    $sessId = Session::get('id');
                    if($takeId == $sessId) {
                    ?>
                    <input class="submit-btn" type="submit" name="update" value="Update">
                    <a class="submit-btn pwdcng-btn" href="password.php?id=<?php echo $takeId; ?>">Password Change</a>
                    <?php }; ?>
                </form>
            </div>
            <?php }; ?>
        </div>
        <div class="form-footer">
            <h4>Website: <a href="https://www.khalidbinahsan.com">www.khalidbinahsan.com</a></h4>
            <h4>Follow Me: <a href="https://www.facebook.com/khalidbinahsan2">www.focebook.com/khalidbinahsan2</a></h4>
        </div>
    </div>
</body>

</html>