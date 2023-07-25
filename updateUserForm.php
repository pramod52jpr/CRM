<?php include "./components/header.php"; ?>
<?php
if(isset($_GET['uuid'])){
    $uuid=$_GET['uuid'];
    $result=$conn->read("users","*","`User_Id`=$uuid");
    $row=$result->fetch_assoc();
}
?>
<form action="users.php" method="post">
    <div class="title">Update User</div>
    <input type="hidden" name="uuid" value="<?php echo isset($_GET['uuid'])?$_GET['uuid']:'' ?>">
    <div class="upper">
        <div class="lower">
            <label for="updatedName">Name </label>
            <input type="text" name="updatedName" id="updatedName" placeholder="Enter Name" value="<?php echo isset($_GET['uuid'])?$row['name']:'' ?>">
        </div>
        <div class="lower">
            <label for="updatedUsername">Username </label>
            <input type="text" name="updatedUsername" id="updatedUsername" placeholder="Enter Username" value="<?php echo isset($_GET['uuid'])?$row['username']:'' ?>">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedPassword">Password </label>
            <input type="text" name="updatedPassword" id="updatedPassword" placeholder="Enter Password" value="<?php echo isset($_GET['uuid'])?$row['password']:'' ?>">
        </div>
        <div class="lower">
            <label for="updatedCategory">Category </label>
            <select name="updatedCategory" id="updatedCategory">
                <option value="" disabled>Select Category</option>
                <?php
                $result=$conn->read("usercategory");
                if($result->num_rows>0){
                    while($row1=$result->fetch_assoc()){
                        if($row1['Cid']==$row['category']){
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                        ?>
                        <option value="<?php echo $row1['Cid'] ?>" <?php echo $selected ?>><?php echo $row1['CName'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Update">
        <a href="users.php">cancel</a>
    </div>
</form>
<?php include "./components/footer.php"; ?>