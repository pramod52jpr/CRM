<?php include "./components/header.php"; ?>
<?php
if($loginRow['category']!=1){
    header("Location: dashboard.php");
}
if(isset($_POST['name']) && isset($_POST['address'])){
    extract($_POST);
    $dataArray=array(
        "Name"=>$name,
        "Address"=>$address,
        "Contact_Person"=>$person,
        "Category"=>$category,
        "Mobile"=>$mobile,
        "Landline"=>$landline,
        "Email"=>$email,
        "City"=>$city,
        "State"=>$state,
        "GST"=>$gst
    );
    $readData=$conn->read("client","`Name`","`Name`='$name'");
    if($readData->num_rows==0){
        $result=$conn->insert("client",$dataArray);
        if($result){
            echo "<script>alert('Client Added Successfully')</script>";
        }else{
            echo "<script>alert('Client Addition Failed')</script>";
        }
    }else{
        echo "<script>alert('This client is already registered')</script>";
    }
}
if(isset($_POST['cuid']) && isset($_POST['updatedName']) && isset($_POST['updatedAddress'])){
    extract($_POST);
    $dataArray=array(
        "Name"=>$updatedName,
        "Address"=>$updatedAddress,
        "Contact_Person"=>$updatedPerson,
        "Category"=>$updatedCategory,
        "Mobile"=>$updatedMobile,
        "Landline"=>$updatedLandline,
        "Email"=>$updatedEmail,
        "City"=>$updatedCity,
        "State"=>$updatedState,
        "GST"=>$updatedGst
    );
    $result=$conn->update("client",$dataArray,"`Client_Id`=$cuid");
    if($result){
        echo "<script>alert('Client Updated Successfully')</script>";
    }else{
        echo "<script>alert('Client Updation Failed')</script>";
    }
}
if(isset($_GET['cdid'])){
    $cdid=$_GET['cdid'];
    $result=$conn->delete("client","`Client_Id`=$cdid");
    if($result){
        echo "<script>alert('Client Deleted Successfully')</script>";
    }else{
        echo "<script>alert('Client Deletion Failed')</script>";
    }
}
if(isset($_GET['cid']) && isset($_GET['cact'])){
    $cid=$_GET['cid'];
    $cact=$_GET['cact'];
    $date=date("Y-m-d");
    $updArray=$cact==1?array(
        "active"=>$cact,
        "Last_Active_Date"=>$date
    ):array(
        "active"=>$cact,
        "Last_Deactive_Date"=>$date
    );
    $result=$conn->update("client",$updArray,"`Client_Id`=$cid");
    if($result){
        echo "<script>alert($cact==1?'Client Activated Successfully':'Client Deactivated Successfully')</script>";
    }else{
        echo "<script>alert($cact==1?'Client Activation Failed':'Client Deactivation Failed')</script>";
    }
}
?>
<div class="usersPage">
    <h2>Clients</h2>
    <div class="add">
        <a href="addClientForm.php">Add</a>
        <hr color="white" width="100px" size="2px">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Person</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php
            $users=$conn->read("client");
            if($users->num_rows>0){
                while($row=$users->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Address'] ?></td>
                        <td><?php echo $row['Mobile'] ?></td>
                        <td><?php echo $row['Contact_Person'] ?></td>
                        <td>
                            <?php if($row['Active']==1){
                                ?>
                                <a href="?cid=<?php echo $row['Client_Id'] ?>&cact=0"><i class="fa-solid fa-toggle-on" style="color: #005eff;font-size:25px"></i></a>
                                <?php
                            }else{
                                ?>
                                <a href="?cid=<?php echo $row['Client_Id'] ?>&cact=1"><i class="fa-solid fa-toggle-off" style="color: #005eff;font-size:25px"></i></a>
                                <?php
                            } ?>
                        </td>
                        <td>
                            <a href="updateClientForm.php?cuid=<?php echo $row['Client_Id'] ?>"><i class="fa-sharp fa-solid fa-pen"></i></a>
                            <a href="?cdid=<?php echo $row['Client_Id'] ?>" style="pointer-events:none;"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr><td colspan="10">No Client Exist</td></tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<?php include "./components/footer.php"; ?>