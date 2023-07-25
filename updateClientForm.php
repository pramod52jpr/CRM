<?php include "./components/header.php"; ?>
<?php
if(isset($_GET['cuid'])){
    $cuid=$_GET['cuid'];
    $result=$conn->read("client","*","`Client_Id`=$cuid");
    $row=$result->fetch_assoc();
}
?>
<form action="client.php" method="post">
    <div class="title">Add Client</div>
    <input type="hidden" name="cuid" value="<?php echo isset($_GET['cuid'])?$_GET['cuid']:'' ?>">
    <div class="upper">
        <div class="lower">
            <label for="updatedName">Name </label>
            <input type="text" value="<?php echo $row['Name'] ?>" name="updatedName" id="updatedName" placeholder="Enter Name" required>
        </div>
        <div class="lower">
            <label for="updatedAddress">Address </label>
            <input type="text" value="<?php echo $row['Address'] ?>" name="updatedAddress" id="updatedAddress" placeholder="Enter Address" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedPerson">Person </label>
            <input type="text" value="<?php echo $row['Contact_Person'] ?>" name="updatedPerson" id="updatedPerson" placeholder="Enter Contact Person Name" required>
        </div>
        <div class="lower">
            <label for="updatedCategory">Category </label>
            <select name="updatedCategory" id="updatedCategory" required>
                <option value=""selected disabled>Select Category</option>
            <?php
            $result=$conn->read("clientcategory");
            if($result->num_rows>0){
                while($row1=$result->fetch_assoc()){
                    if($row1['Category_Id']==$row['Category']){
                        $selected="selected";
                    }else{
                        $selected="";
                    }
                    ?>
                    <option value="<?php echo $row1['Category_Id'] ?>" <?php echo $selected ?>><?php echo $row1['Category_Name'] ?></option>
                    <?php
                }
            }
            ?>
            </select>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedMobile">Mobile No. </label>
            <input type="text" value="<?php echo $row['Mobile'] ?>" name="updatedMobile" id="updatedMobile" placeholder="Enter Mobile No." required>
        </div>
        <div class="lower">
            <label for="updatedLandline">Landline </label>
            <input type="text" value="<?php echo $row['Landline'] ?>" name="updatedLandline" id="updatedLandline" placeholder="Enter Landline">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedEmail">Email Id </label>
            <input type="email" value="<?php echo $row['Email'] ?>" name="updatedEmail" id="updatedEmail" placeholder="Enter Email Id" required>
        </div>
        <div class="lower">
            <label for="updatedCity">City </label>
            <input type="text" value="<?php echo $row['City'] ?>" name="updatedCity" id="updatedCity" placeholder="Enter City">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="updatedState">State </label>
            <input type="text" value="<?php echo $row['State'] ?>" name="updatedState" id="updatedState" placeholder="Enter State">
        </div>
        <div class="lower">
            <label for="updatedGst">GST </label>
            <input type="text" value="<?php echo $row['GST'] ?>" name="updatedGst" id="updatedGst" placeholder="Enter Gst No.">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="actDate">Active </label>
            <input type="date" value="<?php echo $row['Last_Active_Date'] ?>" name="actDate" id="actDate" disabled>
        </div>
        <div class="lower">
            <label for="deactDate">Deactive </label>
            <input type="date" value="<?php echo $row['Last_Deactive_Date'] ?>" name="deactDate" id="deactDate" disabled>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Update">
        <a href="client.php">cancel</a>
    </div>
</form>
<?php include "./components/footer.php"; ?>