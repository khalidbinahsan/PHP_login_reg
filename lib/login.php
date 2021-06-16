<?php
    include "User.php";
    $db = new User();
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    $userLogin = $db->userLogin($_POST);
    }
    Session::checkLogin();
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
                <a href="#">Login</a>
                <a href="register.php">Register</a>
            </div>
        </div>
        <div class="form-body">
            <div class="body-head">
                <h2>User Login</h2>
                <h2></h2>
            </div>
            <div class="form-container">
                <form class="register-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <?php 
                        if(isset($userLogin)) {
                            echo $userLogin;
                        }
                    ?>
                    <label for="email">Email Address</label><br>
                    <input id="email" type="email" name="email"><br>
                    <label for="password">Password</label><br>
                    <input id="password" type="password" name="password"><br>
                    <input class="submit-btn" type="submit" name="login" value="Login">
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