<?php include "./components/header.php"; ?>
<?php
if($loginRow['category']!=1){
    header("Location: dashboard.php");
}
if(isset($_POST['uid'])){
    $uid=$_POST['uid'];
    $date=date("Y-m-d");
    
    $readAssignData=$conn->delete("calldetails","`userId`=$uid and `date`='$date'");
    if(isset($_POST['check'])){
        $check=$_POST['check'];
        foreach($check as $value){
            $dataArray=[
                "userId"=>$uid,
                "clients"=>$value,
                "date"=>$date
            ];
            $result=$conn->insert("calldetails",$dataArray);
        }
        if($readAssignData && $result){
            echo "<script>alert('Clients Assigned Successfully')</script>";
        }else{
            echo "<script>alert('Clients Assignment Failed')</script>";
        }
    }else{
        if($readAssignData){
            echo "<script>alert('Clients Assignment Updated Successfully')</script>";
        }else{
            echo "<script>alert('Clients Assignment Updation Failed')</script>";
        }
    }
}
?>
<div class="usersPage">
    <h2 style="margin:10px 0px">Assign Clients</h2>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>Name</th>
                <th>Assign</th>
            </tr>
            <?php
            $users=$conn->read("users","*","`Category`=2 and `active`=1");
            if($users->num_rows>0){
                while($row=$users->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?php echo $row['name'] ?></td>
                        <td><a href="assignClient.php?uid=<?php echo $row['User_Id'] ?>"><i class="fa-solid fa-upload" style="font-size: 25px"></i></a></td>
                    </tr>
                    <?php
                }
            }else{
                ?>
                <tr><td colspan="10">No User Exist</td></tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<?php include "./components/footer.php"; ?>