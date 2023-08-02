<?php include "./components/header.php"; ?>
<?php
$uid=$_GET['uid'];
$date=date("Y-m-d");
$userResult=$conn->read("users","*","`User_Id`=$uid");
$userrow=$userResult->fetch_assoc();

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

if(isset($_POST['uid'])){
    $uid=$_POST['uid'];
    $date=date("Y-m-d");
    $deleteUpdateClient=$conn->delete("updateclient");
    if($deleteUpdateClient){
        $readClient=$conn->read("client","`Client_Id`,`Name`",$where,null,"$offset","$limit");
        if($readClient->num_rows>0){
            while($readClientRow=$readClient->fetch_assoc()){
                $insertUpdateClientArray=[
                    "Client_Id"=>$readClientRow['Client_Id'],
                    "Name"=>$readClientRow['Name']
                ];
                $insert=$conn->insert("updateclient",$insertUpdateClientArray);
            }
        }
        $deleteAssignData=$conn->delete("calldetails","calldetails.`userId`=$uid and calldetails.`date`='$date'","calldetails","updateclient on updateclient.`Client_Id`=calldetails.`clients`");
        if(isset($_POST['check'])){
            $check=$_POST['check'];
            foreach($check as $value){
                $checkedData=$conn->read("calldetails","*","`userId`=$uid and `date`='$date' and `clients`='$value'");
                if($checkedData->num_rows>0){
                    continue;
                }
                $dataArray=[
                    "userId"=>$uid,
                    "clients"=>$value,
                    "date"=>$date
                ];
                $result=$conn->insert("calldetails",$dataArray);
            }
            if($result){
                echo "<script>alert('Clients Assigned Successfully')</script>";
            }else{
                echo "<script>alert('Clients Assignment Failed')</script>";
            }
        }
        else{
            if($deleteAssignData){
                echo "<script>alert('Clients Assignment Updated Successfully')</script>";
            }else{
                echo "<script>alert('Clients Assignment Updation Failed')</script>";
            }
        }
    }
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
            <a href="assignClient.php?uid=<?php echo $uid; ?>" style="background-color:green">Reset</a>
        </div>
    </form>
</div>
<div class="assignContainer">
    <h2>User : <?php echo $userrow['name'] ?></h2>
    <form action="" method="post" style="margin-top:30px">
        <?php echo $input ?>
        <input type="hidden" name="uid" value="<?php echo $uid ?>">
        <div class="tableContainer">
            <table cellspacing="0">
                <tr>
                    <th>Select</th>
                    <th>Client Id</th>
                    <th>Client Name</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Category</th>
                </tr>
                <?php
                $result=$conn->read("client","*",$where,"clientcategory on client.`Category`=clientcategory.`Category_Id`","$offset","$limit");
                $a=0;
                if($result->num_rows>0){
                    while($row=$result->fetch_assoc()){
                        $assignData=$conn->read("calldetails","*","`userId`=$uid and `date`='$date'");
                        if($assignData->num_rows>0){
                            while($assignRow=$assignData->fetch_assoc()){
                                if($assignRow['clients']==$row['Client_Id']){
                                    $checked="checked";
                                    break;
                                }else{
                                    $checked="";
                                }
                            }
                        }else{
                            $checked="";
                        }

                        $assignedClient=$conn->read("calldetails","*","`userId`!=$uid and `date`='$date' and `clients`=$row[Client_Id]");
                        if($assignedClient->num_rows>0){
                            continue;
                        }
                        ?>
                        <tr>
                            <td><input type="checkbox" name="check[]" id="check" value="<?php echo $row['Client_Id'] ?>" <?php echo $checked ?>></td>
                            <td><?php echo $row['Client_Id'] ?></td>
                            <td><?php echo $row['Name'] ?></td>
                            <td><?php echo $row['City'] ?></td>
                            <td><?php echo $row['State'] ?></td>
                            <td><?php echo $row['Category_Name'] ?></td>
                        </tr>
                        <?php
                        $a++;
                    }
                }
                if($a==0){
                    ?>
                    <tr><td colspan="10">All Clients Assigned Successfully</td></tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <div class="save">
            <input type="submit" value="Assign">
            <a href="assignment.php">cancel</a>
        </div>
    </form>
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