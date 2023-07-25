<?php include "./components/header.php"; ?>
<?php
$date=date("Y-m-d");
session_start();
$userId=$_SESSION['User_Id'];
if($loginRow['category']==1){
    header("Location: dashboard.php");
}
session_abort();
if(isset($_POST['remarks']) && isset($_POST['cid'])){
    $cid=$_POST['cid'];
    $remarks=$_POST['remarks'];
    $array=[
        "call_date"=>$date,
        "remarks"=>$remarks,
        "completed"=>1
    ];
    $result=$conn->update("calldetails",$array,"`userId`=$userId and `clients`=$cid");
    if($result){
        echo "<script>alert('Remarks Added Successfully')</script>";
    }else{
        echo "<script>alert('Remarks Addition Failed')</script>";
    }
}
?>
<div class="usersPage">
    <h2 style="margin:10px 0px">Pending Clients</h2>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>Name</th>
                <th>Person Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php
            $assignedData=$conn->read("calldetails","*","`userId`=$userId and `date`<'$date' and `completed`=0","client on client.`Client_Id`=calldetails.`clients`");
            if($assignedData->num_rows>0){
                while($clientRow=$assignedData->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $clientRow['Name'] ?></td>
                        <td><?php echo $clientRow['Contact_Person'] ?></td>
                        <td><?php echo $clientRow['Mobile'] ?></td>
                        <td><?php echo $clientRow['Address'] ?></td>
                        <td>
                            <?php
                            if($clientRow['completed']==1){
                                ?>
                                <a href="remarks.php?cid=<?php echo $clientRow['Client_Id'] ?>" style="pointer-events:none;"><i class="fa-solid fa-check" style="font-size:25px"></i></a>
                                <?php
                            }else{
                                ?>
                                <a href="remarks.php?cid=<?php echo $clientRow['Client_Id'] ?>"><i class="fa-solid fa-plus" style="font-size:25px"></i></a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr><td colspan="10">No Pending Client</td></tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<div class="usersPage">
    <h2 style="margin:10px 0px">Today Clients</h2>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>Name</th>
                <th>Person Name</th>
                <th>Mobile</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            <?php
            $assignedData=$conn->read("calldetails","*","`userId`=$userId and `date`='$date'","client on client.`Client_Id`=calldetails.`clients`");
            if($assignedData->num_rows>0){
                while($clientRow=$assignedData->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $clientRow['Name'] ?></td>
                        <td><?php echo $clientRow['Contact_Person'] ?></td>
                        <td><?php echo $clientRow['Mobile'] ?></td>
                        <td><?php echo $clientRow['Address'] ?></td>
                        <td>
                            <?php
                            if($clientRow['completed']==1){
                                ?>
                                <a href="remarks.php?cid=<?php echo $clientRow['Client_Id'] ?>" style="pointer-events:none;"><i class="fa-solid fa-check" style="font-size:25px"></i></a>
                                <?php
                            }else{
                                ?>
                                <a href="remarks.php?cid=<?php echo $clientRow['Client_Id'] ?>"><i class="fa-solid fa-plus" style="font-size:25px"></i></a>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr><td colspan="10">No Client Assigned</td></tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<?php include "./components/footer.php"; ?>