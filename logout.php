<?php include "conn.php"; ?>
<?php
$conn=new Conn();
session_start();
session_reset();
session_destroy();
header("Location: $conn->index");
?>