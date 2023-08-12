<?php include "./components/header.php"; ?>
<form action="client.php" method="post">
    <div class="title">Add Client</div>
    <div class="upper">
        <div class="lower">
            <label for="name">Name </label>
            <input type="text" name="name" id="name" placeholder="Enter Name">
        </div>
        <div class="lower">
            <label for="address">Address </label>
            <input type="text" name="address" id="address" placeholder="Enter Address">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="person">Person </label>
            <input type="text" name="person" id="person" placeholder="Enter Contact Person Name">
        </div>
        <div class="lower">
            <label for="category">Category </label>
            <select name="category" id="category">
                <option value=""selected disabled>Select Category</option>
            <?php
            $result=$conn->read("clientcategory");
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    ?>
                    <option value="<?php echo $row['Category_Id'] ?>"><?php echo $row['Category_Name'] ?></option>
                    <?php
                }
            }
            ?>
            </select>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="mobile">Mobile No. </label>
            <input type="text" name="mobile" id="mobile" placeholder="Enter Mobile No.">
        </div>
        <div class="lower">
            <label for="landline">Landline </label>
            <input type="text" name="landline" id="landline" placeholder="Enter Landline">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="email">Email Id </label>
            <input type="email" name="email" id="email" placeholder="Enter Email Id">
        </div>
        <div class="lower">
            <label for="city">City </label>
            <input type="text" name="city" id="city" placeholder="Enter City">
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="state">State </label>
            <input type="text" name="state" id="state" placeholder="Enter State">
        </div>
        <div class="lower">
            <label for="gst">GST </label>
            <input type="text" name="gst" id="gst" placeholder="Enter Gst No.">
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Add">
        <a href="client.php">cancel</a>
    </div>
</form>
<?php include "./components/footer.php"; ?>