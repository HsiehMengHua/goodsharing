<?php

session_start();
include("connectDB.php");

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$sql = "UPDATE `member` SET `name` = '$name', `phone` = '$phone', `email` = '$email' WHERE `id` = ".$_SESSION['member_id'];
//$result = $conn->query($sql);
//$row = $result->fetch_assoc();

if($result = $conn->query($sql)){
  echo '<script>
          window.alert("編輯成功");
          window.location.href="myAccount.php";
        </script>';
}else{
  echo 'failed';
  echo '<script> history.back(); </script>';
}

?>