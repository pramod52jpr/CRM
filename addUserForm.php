<?php include "./components/header.php"; ?>
<form action="users.php" method="post">
    <div class="title">Add User</div>
    <div class="upper">
        <div class="lower">
            <label for="name">Name </label>
            <input type="text" name="name" id="name" placeholder="Enter Name" required>
        </div>
        <div class="lower">
            <label for="username">Username </label>
            <input type="text" name="username" id="username" placeholder="Enter Username" required>
        </div>
    </div>
    <div class="upper">
        <div class="lower">
            <label for="password">Password </label>
            <input type="password" name="password" id="password" placeholder="Enter Password" required>
        </div>
        <div class="lower">
            <label for="category">Category </label>
            <select name="category" id="category" required>
                <option value=""selected disabled>Select Category</option>
            <?php
            $result=$conn->read("usercategory");
            if($result->num_rows>0){
                while($row=$result->fetch_assoc()){
                    ?>
                    <option value="<?php echo $row['Cid'] ?>"><?php echo $row['CName'] ?></option>
                    <?php
                }
            }
            ?>
            </select>
        </div>
    </div>
    <div class="save">
        <input type="submit" value="Add">
        <a href="users.php">cancel</a>
    </div>
</form>
<?php include "./components/footer.php"; ?>