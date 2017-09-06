<?php

session_start();
include("connectDB.php");

$memberId = $_SESSION['member_id'];
$needId = $_GET['needId'];
$datetime = date("Y-m-d H:i:s");
$num = $_POST['number'];

$sql = "INSERT INTO `order` (`member_id`,`need_id`,`datetime`,`num`) VALUES ('$memberId', '$needId', '$datetime', '$num')";
if($result = $conn->query($sql)){
  echo '<script>
          window.alert("贈物單已成立！\n\n完成寄送後請至帳號管理更新寄送狀態");
          window.location.href="myAccount.php";
        </script>';
}else{
  echo '<script>
          window.alert("Something wrong!");
          history.back();
        </script>';
}

?>