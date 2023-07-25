<?php include "./components/header.php"; ?>
<?php
if($loginRow['category']!=1){
    header("Location: dashboard.php");
}
if(isset($_POST['username']) && isset($_POST['password'])){
    $name=$_POST['name'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $category=$_POST['category'];

    $dataArray=array(
        "name"=>$name,
        "username"=>$username,
        "password"=>$password,
        "category"=>$category,
    );
    $readData=$conn->read("users","`username`","`username`='$username'");
    if($readData->num_rows==0){
        $result=$conn->insert("users",$dataArray);
        if($result){
            echo "<script>alert('User Added Successfully')</script>";
        }else{
            echo "<script>alert('User Addition Failed')</script>";
        }
    }else{
        echo "<script>alert('Try Another Username')</script>";
    }
}
if(isset($_POST['uuid']) && isset($_POST['updatedUsername']) && isset($_POST['updatedPassword'])){
    $uuid=$_POST['uuid'];
    $updatedName=$_POST['updatedName'];
    $updatedUsername=$_POST['updatedUsername'];
    $updatedPassword=$_POST['updatedPassword'];
    $updatedCategory=$_POST['updatedCategory'];

    $dataArray=array(
        "name"=>$updatedName,
        "username"=>$updatedUsername,
        "password"=>$updatedPassword,
        "category"=>$updatedCategory,
    );
    $result=$conn->update("users",$dataArray,"`User_Id`=$uuid");
    if($result){
        echo "<script>alert('User Updated Successfully')</script>";
    }else{
        echo "<script>alert('User Updation Failed')</script>";
    }
}
if(isset($_GET['udid'])){
    $udid=$_GET['udid'];
    $result=$conn->delete("users","`User_Id`=$udid");
    if($result){
        echo "<script>alert('User Deleted Successfully')</script>";
    }else{
        echo "<script>alert('User Deletion Failed')</script>";
    }
}
if(isset($_GET['uid']) && isset($_GET['uact'])){
    $uid=$_GET['uid'];
    $uact=$_GET['uact'];
    $updArray=array(
        "active"=>$uact
    );
    $result=$conn->update("users",$updArray,"`User_Id`=$uid");
    if($result){
        echo "<script>alert($uact==1?'User Activated Successfully':'User Deactivated Successfully')</script>";
    }else{
        echo "<script>alert($uact==1?'User Activation Failed':'User Deactivation Failed')</script>";
    }
}
?>
<div class="usersPage">
    <h2>Users</h2>
    <div class="add">
        <a href="addUserForm.php">Add</a>
        <hr color="white" width="100px" size="2px">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>Name</th>
                <th>username</th>
                <th>Category</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php
            $users=$conn->read("users","*",null,"usercategory on usercategory.Cid=users.category");
            if($users->num_rows>0){
                while($row=$users->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['username'] ?></td>
                        <td><?php echo $row['CName'] ?></td>
                        <td>
                            <?php if($row['active']==1){
                                ?>
                                <a href="?uid=<?php echo $row['User_Id'] ?>&uact=0"><i class="fa-solid fa-toggle-on" style="color: #005eff;font-size:25px"></i></a>
                                <?php
                            }else{
                                ?>
                                <a href="?uid=<?php echo $row['User_Id'] ?>&uact=1"><i class="fa-solid fa-toggle-off" style="color: #005eff;font-size:25px"></i></a>
                                <?php
                            } ?>
                        </td>
                        <?php
                        if($row['category']==1){
                            $disabled="style='pointer-events:none'";
                        }else{
                            $disabled="";
                        }
                        ?>
                        <td><a href="updateUserForm.php?uuid=<?php echo $row['User_Id'] ?>"><i class="fa-sharp fa-solid fa-pen"></i></a><a href="?udid=<?php echo $row['User_Id'] ?>" <?php echo $disabled ?>><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr><td colspan="10">No Users Exist</td></tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<?php include "./components/footer.php"; ?>