<?php include "conn.php" ?>
<?php
session_start();
if(isset($_SESSION['User_Id'])){
    header("Location: dashboard.php");
}
session_abort();
session_start();
$conn=new Conn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Relation Management</title>
    <link rel="stylesheet" href="./style/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
</head>
<body>
    <section class="loginPage">
        <div class="loginContainer">
            <div class="loginHeader">
                <div class="headerContent">
                    <h2>BIOROLES</h2>
                    <div>Customer Relation Management</div>
                </div>
                <div class="LoginPg">Log in to start your session</div>
            </div>
            <div class="formContainer">
                <h3>Login to Continue</h3>
                <?php
                if(isset($_POST['username']) && isset($_POST['password'])){
                    $username=$_POST['username'];
                    $password=$_POST['password'];
                    $result=$conn->read("users","*","`username`='$username' and `password`='$password'");
                    if($result->num_rows==1){
                        $row=$result->fetch_assoc();
                        if($row['active']==1){
                            $_SESSION['User_Id']=$row['User_Id'];
                            Header("Location: dashboard.php");
                        }else{
                            echo "<script>alert('You are Deactivated by Admin')</script>";
                        }
                    }else{
                        echo "<script>alert('Wrong Username or Password')</script>";
                    }
                }
                ?>
                <form id="loginForm" action="" method="post">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo isset($_POST['username'])?$_POST['username']:'' ?>" required>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" value="<?php echo isset($_POST['password'])?$_POST['password']:'' ?>" required>
                    <input class="button" type="submit" value="Log In">
                </form>
            </div>
        </div>
    </section>
<script src="script/login.js"></script>
</body>
</html>