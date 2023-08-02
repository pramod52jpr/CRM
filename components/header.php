<?php include "conn.php" ?>
<?php
$conn=new Conn();
session_start();
if(!isset($_SESSION['User_Id'])){
    header("Location: $conn->index");
}
$userId=$_SESSION['User_Id'];
$loginUser=$conn->read("users","`name`,`category`","`User_Id`=$userId");
$loginRow=$loginUser->fetch_assoc();
session_abort();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Relation Management</title>
    <link rel="shortcut icon" href="https://media.smallbiztrends.com/2013/08/benefits-of-crm.jpg" type="image/x-icon">
    <link rel="stylesheet" href="./style/header.css">
    <link rel="stylesheet" href="./style/dashboard.css">
    <link rel="stylesheet" href="./style/userForm.css">
    <link rel="stylesheet" href="./style/users.css">
    <link rel="stylesheet" href="./style/reports.css">
</head>
<body>
    <header>
        <div class="hampburger">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="hello">
            Hello, <?php echo $loginRow['name'] ?>
        </div>
    </header>
    <div class="myaccount">
        <ul>
            <li><a href="logout.php"><i class="fa-solid fa-right-from-bracket"></i><div>Logout</div></a></li>
        </ul>
    </div>
    <div class="content">
        <div class="drawer">
            <ul type="none">
                <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i><div>Dashboard</div></a></li>
                <?php
                if($loginRow['category']==1){
                    ?>
                    <li><a href="users.php"><i class="fa-solid fa-user-secret"></i><div>Users</div></a></li>
                    <li><a href="client.php"><i class="fa-solid fa-user"></i><div>Client Master</div></a></li>
                    <li><a href="assignment.php"><i class="fa-solid fa-upload"></i><div>Assignment</div></a></li>
                    <li><a href="reports.php"><i class="fa-solid fa-flag"></i><div>Reports</div></a></li>
                    <?php
                }if($loginRow['category']==2){
                    ?>
                    <li><a href="assignedList.php"><i class="fa-solid fa-users-viewfinder"></i><div>Clients</div></a></li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="mainContainer">