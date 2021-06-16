<?php
    include "lib/header.php";
    Session::checkSession();
    include "lib/User.php";
    $user = new User();   
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Registration Form</title>
    <link rel="stylesheet" href="css/style.css" media="all" type="text/css">
</head>
<!-- ==== Logout Script ==== -->
<?php 
    if(isset($_GET['action']) && $_GET['action'] == 'logout') {
        Session::destroy();
    }
?>
<body>
    <div class="container">
        <div class="form-header">
            <h4>Login Register System PHP OPP & PDO</h4>
            <div class="nav-menu">
                <?php 
                $id = Session::get('id');
                $userLogin = Session::get('login');
                if($userLogin == true) {                   
                ?>
                <a href="lib/profile.php?id=<?php echo $id; ?>">Profile</a>
                <a href="?action=logout">Logout</a>
                <?php } else { ?>
                <a href="lib/login.php">Login</a>                
                <a href="lib/register.php">Registration</a>
                <?php } ?>
            </div>
        </div>
        <?php 
            $loginmsg = Session::get('loginmsg');
            if(isset($loginmsg)) {
            echo $loginmsg;
            }
            Session::set('loginmsg', NULL);
        ?>
        <div class="form-body">
            <div class="body-head">
                <h2>User List</h2>
                <h2><strong>Welcome! </strong>
                <?php 
                    $name = Session::get('name');
                    if(isset($name)) {
                        echo $name;
                    }
                ?>
                </h2>
            </div>
            <div class="form-container">
                <table class="user-list-tbl">
                    <tr>
                        <th>Serial</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email Address</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                    $userData = $user->getUserData();
                    if($userData) {
                        $i = 0;
                        foreach($userData as $sdata) {
                        $i++;                        
                    ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td><?php echo $sdata['name']; ?></td>
                        <td><?php echo $sdata['uname']; ?></td>
                        <td><?php echo $sdata['email']; ?></td>
                        <td style="text-align: center;"><a class="view-btn" href="lib/profile.php?id=<?php echo $sdata['id'] ?>">View</a></td>
                    </tr>
                    <?php } } else{ ?>
                    <tr><td colspan="5"><h2>No User Data Found</h2></td></tr>
                    <?php } ?>
                </table>
            </div>

        </div>
        <div class="form-footer">
            <h4>Website: <a href="https://www.khalidbinahsan.com">www.khalidbinahsan.com</a></h4>
            <h4>Follow Me: <a href="https://www.facebook.com/khalidbinahsan2">www.focebook.com/khalidbinahsan2</a></h4>
        </div>
    </div>
</body>

</html>