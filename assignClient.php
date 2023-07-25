<?php include "./components/header.php"; ?>
<?php
$uid=$_GET['uid'];
$date=date("Y-m-d");
$userResult=$conn->read("users","*","`User_Id`=$uid");
$userrow=$userResult->fetch_assoc();
?>
<div class="assignContainer">
    <h2>User : <?php echo $userrow['name'] ?></h2>
    <form action="assignment.php" method="post" style="margin-top:30px">
        <input type="hidden" name="uid" value="<?php echo $uid ?>">
        <div class="tableContainer">
            <table cellspacing="0">
                <tr>
                    <th>Select</th>
                    <th>Client Name</th>
                    <th>Category</th>
                </tr>
                <?php
                $result=$conn->read("client","*","`Active`=1","clientcategory on client.`Category`=clientcategory.`Category_Id`");
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
                            <td><?php echo $row['Name'] ?></td>
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
</div>
<?php include "./components/footer.php"; ?>