<?php include "./components/header.php"; ?>
<?php
if($loginRow['category']!=1){
    header("Location: dashboard.php");
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