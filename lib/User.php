<?php 
    include_once "Session.php";
    include "Database.php";
    class User {
        private $db;
        public function __construct()
        {
          $this->db = new Database();  
        }
        // =====Registration Form Validation and Insert ====
        // ====Form Validation****
        public function userRegistration($data) { //Registration form...
          $name = htmlspecialchars($data['name']);
          $uname = htmlspecialchars($data['uname']);
          $email = $data['email'];
          $email = filter_var($email, FILTER_SANITIZE_EMAIL);
          $email_check = $this->emailCheck($email);
          $password = $data['password'];
          if($name == "" || $uname == "" || $email == "" || $password == "") {
            $msg = "<div class='error-msg'><strong>Error!</strong> Field must not be empty</div>";
            return $msg;
          }
          if(strlen($uname) < 4) {
            $msg = "<div class='error-msg'><strong>Error!</strong> Username  is too short</div>";
            return $msg;
          } elseif(preg_match('/[^a-z0-9_-]+/i', $uname)) {
            $msg = "<div class='error-msg'><strong>Error!</strong> Username must only contain alphanumerical, dashes and underscores</div>";
            return $msg;
          }
          if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='error-msg'><strong>Error!</strong> The Email is not valid</div>";
            return $msg;
          }
          if($email_check == true) {
            $msg = "<div class='error-msg'><strong>Error!</strong> The Email address already Exist!</div>";
            return $msg;
          }
          // Make Password md5
          $password = md5($data['password']);
          // ====Form Insert*****
          $sql = "INSERT INTO login_reg (name, uname, email, password) VALUES(:name, :uname, :email, :password)";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':name', $name);
          $query->bindValue(':uname', $uname);
          $query->bindValue(':email', $email);
          $query->bindValue(':password', $password);
          $result = $query->execute();
          if($result) {
            $msg = "<div class='succ-msg'><strong>Success</strong>You have been Registered</div>";
            return $msg;
          } else {
            $msg = "<div class='error-msg'><strong>Error!</strong> Sorry, there has been problem to insert your details.</div>";
            return $msg;
          }
        }
        // ====Registration Form Validation and insert End
        //=====Functions****
        public function emailCheck($email) {
          $sql = "SELECT email FROM login_reg WHERE email = :email";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':email', $email);
          $query->execute();
          if($query->rowCount() > 0) {
            return true;
          } else {
            return false;
          }
        }
       public function getLoginUser($email, $password) {
          $sql = "SELECT * FROM login_reg WHERE email = :email AND password = :password LIMIT 1";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':email', $email);
          $query->bindValue(':password', $password);
          $query->execute();
          $result = $query->fetch(PDO::FETCH_OBJ);
          return $result;
       }
       public function getUserData() {
         $sql = "SELECT * FROM login_reg ORDER BY id DESC";
         $query = $this->db->pdo->prepare($sql);
         $query->execute();
         $result = $query->fetchAll();
         return $result;
       }
        public function getUserById($id) { //  Insert Profile function
          $sql = "SELECT * FROM login_reg WHERE id = :id LIMIT 1";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(":id", $id);
          $query->execute();
          $result = $query->fetch(PDO::FETCH_OBJ);
          return $result;
        }
        public function updateData($id, $data) { //Data update function.....
          $name = $data['name'];
          $uname = $data['uname'];
          $email = $data['email'];
          $email = filter_var($email, FILTER_SANITIZE_EMAIL);
          if($name == "" || $uname == "" || $email == "") {
            $msg = "<div class='error-msg'><strong>Error!</strong> Field must not be empty</div>";
            return $msg;
          }
          if(strlen($uname) < 4) {
            $msg = "<div class='error-msg'><strong>Error!</strong> Username  is too short</div>";
            return $msg;
          } elseif(preg_match('/[^a-z0-9_-]+/i', $uname)) {
            $msg = "<div class='error-msg'><strong>Error!</strong> Username must only contain alphanumerical, dashes and underscores</div>";
            return $msg;
          }
          if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='error-msg'><strong>Error!</strong> The Email is not valid</div>";
            return $msg;
          }
          // ====Form Update*****
          $sql = "UPDATE login_reg SET
          name = :name,
          uname = :uname,
          email = :email
          WHERE id = :id";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':name', $name);
          $query->bindValue(':uname', $uname);
          $query->bindValue(':email', $email);
          $query->bindValue(':id', $id);
          $result = $query->execute();
          if($result) {
            $msg = "<div class='succ-msg'><strong>Success!</strong> Data updated successfully</div>";
            return $msg;
          } else {
            $msg = "<div class='error-msg'><strong>Error!</strong> Sorry, There is a problem to updating data.</div>";
            return $msg;
          }
        }
        // Change Password..... 
        public function cngPassword($id, $data) {
          $oldPass = $data['oldpass'];
          $newPass = $data['newpass'];
          $cnfmPass = $data['cnfmpass'];
          $chk_pass = $this->checkPass($id, $oldPass);
          if($oldPass == "" || $newPass == "") {
            $msg = "<div class='error-msg'><strong>Error!</strong> Please Enter Old and New Password.</div>";
            return $msg;
          }
          if($chk_pass == false) {
            $msg = "<div class='error-msg'><strong>Error!</strong> Your Old Password Is Not Correct.</div>";
            return $msg;
          }
          if($newPass != $cnfmPass) {
            $msg = "<div class='error-msg'><strong>Error!</strong> New Password Not Matching.</div>";
            return $msg;
          }
          if(strlen($newPass) < 6) {
            $msg = "<div class='error-msg'><strong>Error!</strong> Password need more then 6 character.</div>";
            return $msg;
          }

          // ====pass Update*****
          $sql = "UPDATE login_reg SET
          password = :password
          WHERE id = :id";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':password', md5($cnfmPass));
          $query->bindValue(':id', $id);
          $result = $query->execute();
          if($result) {
            $msg = "<div class='succ-msg'><strong>Success!</strong> Password Changed successfully</div>";
            return $msg;
          } else {
            $msg = "<div class='error-msg'><strong>Error!</strong> Sorry, Password not Updated.</div>";
            return $msg;
          }
        }
        // Password Check on cng password
        private function checkPass($id, $old_pass) {
          $oldPass = md5($old_pass);
          $sql = "SELECT password FROM login_reg WHERE id = :id AND password = :password ";
          $query = $this->db->pdo->prepare($sql);
          $query->bindValue(':id', $id);
          $query->bindValue(':password', $oldPass);
          $query->execute();
          if($query->rowCount() > 0) {
            return true;
          } else {
            return false;
          }       
        }
        // Login Form Validation and Match
        public function userLogin($data) {
          $email = $data['email'];
          $password = md5($data['password']);
          $email_check = $this->emailCheck($email);
          if($email_check == false) {
            $msg = "<div class='error-msg'><strong>Error!</strong> The email address Not exist.</div>";
            return $msg;
          }
          if($email == "" || $password == "") {
            $msg = "<div class='error-msg'><strong>Error!</strong> Field Must not be empty</div>";
            return $msg;
          }
          if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "<div class='error-msg'><strong>Error!</strong> The Email is not valid</div>";
            return $msg;
          }
          $result = $this->getLoginUser($email, $password);
          if($result) {
            Session::init();
            Session::set('login', true);
            Session::set('id', $result->id);
            Session::set('name', $result->name);
            Session::set('uname', $result->uname);
            Session::set('loginmsg', '<div class="succ-msg"><strong>Success!</strong> You are logged in</div>');
            header("Location: ../index.php");
          } else {
            $msg = "<div class='error-msg'><strong>Error!</strong> Your Email or Password not matching</div>";
            return $msg;
          }
        }
    }
?>