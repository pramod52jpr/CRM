<?php include "./components/header.php"; ?>
<?php
if($loginRow['category']!=1){
    header("Location: dashboard.php");
}
if(isset($_POST['name']) && isset($_POST['address'])){
    $name=$_POST['name'];
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
    $cuid=$_POST['cuid'];
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

$where="`Active`=1";
$whereCity=null;
$input="";
if(isset($_POST['state'])){
    $where.=" and `State`='$_POST[state]'";
    $whereCity="`State`='$_POST[state]'";
    $input.="<input type='hidden' name='state' value='$_POST[state]'>";
}
if(isset($_POST['city'])){
    $where.=" and `City`='$_POST[city]'";
    $input.="<input type='hidden' name='city' value='$_POST[city]'>";
}
if(isset($_POST['category'])){
    $where.=" and `Category`=$_POST[category]";
    $input.="<input type='hidden' name='category' value='$_POST[category]'>";
}
if(isset($_POST['page'])){
    $input.="<input type='hidden' name='page' value='$_POST[page]'>";
}

$clientCount=$conn->read("client","*",$where);
$totalClients=$clientCount->num_rows;
$offset=0;
$limit=40;
$pages=ceil($totalClients/$limit);

if(isset($_POST['page'])){
    $page=$_POST['page'];
    $offset=$limit*($page-1);
}

?>
<div class="filterContainer">
    <form action="" method="post">
        <select name="state" id="state">
            <option value="" selected disabled>Select State</option>
            <?php
            $users=$conn->read("client","*",null,null,null,null,"`State`");
            if($users->num_rows>0){
                while($userRow=$users->fetch_assoc()){
                    if(isset($_POST['state'])){
                        if($userRow['State']==$_POST['state']){
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                    }else{
                        $selected="";
                    }
                    ?>
                    <option value="<?php echo $userRow['State'] ?>" <?php echo $selected; ?>><?php echo $userRow['State'] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <select name="city" id="city">
            <option value="" selected disabled>Select City</option>
            <?php
            $users=$conn->read("client","*",$whereCity,null,null,null,"`City`");
            if($users->num_rows>0){
                while($userRow=$users->fetch_assoc()){
                    if(isset($_POST['city'])){
                        if($userRow['City']==$_POST['city']){
                            $selected="selected";
                        }else{
                            $selected="";
                        }
                    }else{
                        $selected="";
                    }
                    ?>
                    <option value="<?php echo $userRow['City'] ?>" <?php echo $selected; ?>><?php echo $userRow['City'] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <select name="category" id="category">
            <option value="" selected disabled>Select Category</option>
            <?php
            $users=$conn->read("clientcategory");
            if($users->num_rows>0){
                while($userRow=$users->fetch_assoc()){
                    if($userRow['Category_Id']==$_POST['category']){
                        $selected="selected";
                    }else{
                        $selected="";
                    }
                    ?>
                    <option value="<?php echo $userRow['Category_Id'] ?>" <?php echo $selected; ?>><?php echo $userRow['Category_Name'] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <div class="save">
            <input type="submit" value="Show">
            <a href="client.php" style="background-color:green">Reset</a>
        </div>
    </form>
</div>
<div class="usersPage">
    <h2>Clients</h2>
    <div class="add">
        <a href="addClientForm.php">Add</a>
        <hr color="white" width="100px" size="2px">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>Client Id</th>
                <th>Name</th>
                <th>City</th>
                <th>State</th>
                <th>Mobile</th>
                <th>Active</th>
                <th>Action</th>
            </tr>
            <?php
            $users=$conn->read("client","*",$where,null,"$offset","$limit");
            if($users->num_rows>0){
                while($row=$users->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $row['Client_Id'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['City'] ?></td>
                        <td><?php echo $row['State'] ?></td>
                        <td><?php echo $row['Mobile'] ?></td>
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
    <div class="pagination">
        <?php
        for($i=1;$i<=$pages;$i++){
            if(isset($_POST['page'])){
                if($page==$i){
                    $select="style='background-color:grey' disabled";
                }else{
                    $select="";
                }
            }else{
                if($i==1){
                    $select="style='background-color:grey' disabled";
                }else{
                    $select="";
                }
            }
            ?>
            <form action="" method="post">
                <?php echo $input ?>
                <input type="hidden" name="page" value="<?php echo $i ?>">
                <input type="submit" value="<?php echo $i ?>" <?php echo $select ?>>
            </form>
            <?php
        }
        ?>
    </div>
</div>
<?php include "./components/footer.php"; ?>