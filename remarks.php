<?php include "./components/header.php"; ?>
<?php
if(!isset($_GET['cid'])){
    header("Location: dashboard.php");
}
if(isset($_GET['cid'])){
    $cid=$_GET['cid'];
}
?>
<form action="assignedList.php" method="post">
    <input type="hidden" name="cid" value="<?php echo $cid ?>">
    <div class="title">
        <?php
        $result=$conn->read("client","`Name`","`Client_Id`=$cid");
        $row=$result->fetch_assoc();
        echo "Company :- ".$row['Name'];
        ?>
    </div>
    <div class="title">Remarks : </div>
    <div class="upper">
        <label for="remarks">Remarks </label>
        <textarea name="remarks" id="remarks" placeholder="Enter Remarks about Call" cols="30" rows="10" required></textarea>
    </div>
    <div class="save">
        <input type="submit" value="Save">
        <a href="assignedList.php">cancel</a>
    </div>
</form>
<?php include "./components/footer.php"; ?>