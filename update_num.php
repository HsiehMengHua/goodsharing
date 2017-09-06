<?php

session_start();
include("connectDB.php");

$num = $_POST['number'];
$sql = "UPDATE `needs` SET `current_number` = '$num' WHERE `id` = ".$_POST['id'];

if($result = $conn->query($sql)){
  if(isset($_SESSION['member_id']))
    $to = "myAccount.php";
  else if(isset($_SESSION['or_id']))
    $to = "orAccount.php";
  
  echo '<script>
          window.alert("修改成功");
          window.location.href="'.$to.'";
        </script>';
}else
  echo "failed";
  //echo '<script> history.back(); </script>';

?>