<?php include "./components/header.php"; ?>
<?php
// last week date

$day1=date("d")-7;
$month1=date("m");
$year1=date("Y");
$date1=date("$year1-$month1-$day1");
if($day1<1){
    $day1+=30;
    $month1--;
    $date1=date("$year1-$month1-$day1");
    if($month1<1){
        $month1+=12;
        $year1--;
        $date1=date("$year1-$month1-$day1");
    }
    if($day1<10 && $month1<10){
        $date1=date("$year1-0$month1-0$day1");
    }elseif($day1<10){
        $date1=date("$year1-$month1-0$day1");
    }elseif($month1<10){
        $date1=date("$year1-0$month1-$day1");
    }
}

// last working day

$vaar=date("D");
if($vaar=="Mon"){
    $day2=date("d")-2;
    $month2=date("m");
    $year2=date("Y");
    $date2=date("$year2-$month2-$day2");
    if($day2<1){
        $day2+=30;
        $month2--;
        $date2=date("$year2-$month2-$day2");
        if($month2<1){
            $month2+=12;
            $year2--;
            $date2=date("$year2-$month2-$day2");
        }
        if($day2<10 && $month2<10){
            $date2=date("$year2-0$month2-0$day2");
        }elseif($day2<10){
            $date2=date("$year2-$month2-0$day2");
        }elseif($month2<10){
            $date2=date("$year2-0$month2-$day2");
        }
    }
}else{
    $day2=date("d")-1;
    $month2=date("m");
    $year2=date("Y");
    $date2=date("$year2-$month2-$day2");
    if($day2<1){
        $day2+=30;
        $month2--;
        $date2=date("$year2-$month2-$day2");
        if($month2<1){
            $month2+=12;
            $year2--;
            $date2=date("$year2-$month2-$day2");
        }
        if($day2<10 && $month2<10){
            $date2=date("$year2-0$month2-0$day2");
        }elseif($day2<10){
            $date2=date("$year2-$month2-0$day2");
        }elseif($month2<10){
            $date2=date("$year2-0$month2-$day2");
        }
    }
}

// today date

$date3=date("Y-m-d");

///////////  date end   ////////////////////////

session_start();
$userId=$_SESSION['User_Id'];
session_abort();
$adminResult=$conn->read("users","`category`","`User_Id`=$userId");
$adminResultRow=$adminResult->fetch_assoc();
if($adminResultRow['category']==1){
    ?>
    <div class="dashboardPage">
        <?php
        $result=$conn->read("users");
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){
                $lastWeek=$conn->read("calldetails","*","`call_date`>='$date1' and `userId`=$row[User_Id]");
                $lastWeekcalls=$lastWeek->num_rows;

                $lastWorkingDay=$conn->read("calldetails","*","`call_date`='$date2' and `userId`=$row[User_Id]");
                $lastWorkingDaycalls=$lastWorkingDay->num_rows;

                $today=$conn->read("calldetails","*","`call_date`='$date3' and `userId`=$row[User_Id]");
                $todaycalls=$today->num_rows;
                ?>
                <a href="#" class="item">
                    <div class="user"><?php echo $row['name'] ?></div>
                    <div>Last week : <?php echo $lastWeekcalls ?> calls</div>
                    <div>Last working day : <?php echo $lastWorkingDaycalls ?> calls</div>
                    <div>Today : <?php echo $todaycalls ?> calls</div>
                </a>
                <?php
            }
        }
        ?>
    </div>
    <?php
}else{
    ?>
    <?php
    $date=date("Y-m-d");
    session_start();
    $userId=$_SESSION['User_Id'];
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
    <?php
    $lastWeek=$conn->read("calldetails","*","`call_date`>='$date1' and `userId`=$userId");
    $lastWeekcalls=$lastWeek->num_rows;

    $lastWorkingDay=$conn->read("calldetails","*","`call_date`='$date2' and `userId`=$userId");
    $lastWorkingDaycalls=$lastWorkingDay->num_rows;

    $today=$conn->read("calldetails","*","`call_date`='$date3' and `userId`=$userId");
    $todaycalls=$today->num_rows;
    ?>
    <div class="aboutUser">
        <span>
            <div><i class="fa-regular fa-calendar-days"></i>Last week : <?php echo $lastWeekcalls ?> calls</div>
            <div><i class="fa-solid fa-calendar-minus"></i>Last working day : <?php echo $lastWorkingDaycalls ?> calls</div>
            <div><i class="fa-solid fa-calendar-day"></i>Today : <?php echo $todaycalls ?> calls</div>
        </span>
    </div>
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
    <?php
}
?>
<?php include "./components/footer.php"; ?>