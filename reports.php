<?php include "./components/header.php"; ?>
<?php
$date=date("Y-m-d");
if($loginRow['category']!=1){
    header("Location: dashboard.php");
}

$where="`Mobile`!='87'";
if(isset($_POST['user'])){
    $where.=" and `userId`='$_POST[user]'";
}
if(isset($_POST['date'])){
    if($_POST['date']!=""){
        $where.=" and `date`='$_POST[date]'";
    }
}
if(isset($_POST['radio'])){
    $where.=" and `completed`=$_POST[radio]";
}
?>
<div class="filterContainer">
    <form action="" method="post">
        <select name="user" id="user">
            <option value="" selected disabled>Select User</option>
            <?php
            $users=$conn->read("users");
            if($users->num_rows>0){
                while($userRow=$users->fetch_assoc()){
                    if($userRow['category']==1){
                        continue;
                    }
                    if($userRow['User_Id']==$_POST['user']){
                        $selected="selected";
                    }else{
                        $selected="";
                    }
                    ?>
                    <option value="<?php echo $userRow['User_Id'] ?>" <?php echo $selected; ?>><?php echo $userRow['name'] ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <input type="date" name="date" value="<?php echo isset($_POST['date'])?$_POST['date']:'' ?>" id="date" min="2020-01-01" max="<?php echo $date; ?>" >
        <div class="radio">
            <input type="radio" value="1" name="radio" id="success" <?php echo isset($_POST['radio'])?$_POST['radio']==1?'checked':'':'' ?>>
            <label for="success">Success Calls</label>
        </div>
        <div class="radio">
            <input type="radio" value="0" name="radio" id="pending" <?php echo isset($_POST['radio'])?$_POST['radio']==0?'checked':'':'' ?>>
            <label for="pending">Pending Calls</label>
        </div>
        <div class="save">
            <input type="submit" value="Show">
            <a href="reports.php" style="background-color:green">Reset</a>
        </div>
    </form>
</div>
<div class="usersPage">
    <h2>Reports</h2>
    <div class="add">
        <hr color="white" width="150px" size="2px">
    </div>
    <div class="tableContainer">
        <table cellspacing="0">
            <tr>
                <th>User</th>
                <th>Company</th>
                <th>C. Mobile</th>
                <th>Assign Date</th>
                <th>Call Date</th>
                <th>Remarks</th>
            </tr>
            <?php
            $users=$conn->read("calldetails","*",$where,"users on users.`User_Id`=calldetails.`userId` join client on client.`Client_Id`=calldetails.`clients`");
            if($users->num_rows>0){
                while($row=$users->fetch_assoc()){
                    if($row['completed']==0){
                        $color="style='color:white;background-color:red;'";
                    }else{
                        $color="";
                    }
                    ?>
                    <tr <?php echo $color; ?>>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['Name'] ?></td>
                        <td><?php echo $row['Mobile'] ?></td>
                        <td><?php echo $row['date'] ?></td>
                        <td><?php echo $row['call_date'] ?></td>
                        <td><?php echo $row['remarks'] ?></td>
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