<?php

include("connectDB.php");

$date = date("Y-m-d");

if($_GET['st']=="delivering"){
  $newStatus = "運送中";
  $sql = "UPDATE `order` SET `status` = '$newStatus', `sendDate` = '$date' WHERE `id` = ".$_GET['id'];
  if($result = $conn->query($sql)){
    $sql = "SELECT `need_id`,`num` FROM `order` WHERE `id` = ".$_GET['id'];
    $row = $conn->query($sql)->fetch_assoc();

    $sql = "UPDATE `needs` SET `current_number` = `current_number`+".$row['num']." WHERE `id` = ".$row['need_id'];
    if($result = $conn->query($sql))
      echo "updated";
    else
      echo "failed";
  }
}else if($_GET['st']=="arrived"){
  $newStatus = "已送達";
  $sql = "UPDATE `order` SET `status` = '$newStatus', `arriveDate` = '$date' WHERE `id` = ".$_GET['id'];
  if($result = $conn->query($sql))
      echo "updated";
    else
      echo "failed";
}else if($_GET['st']=="cancel"){
  $newStatus = "已取消";
  $sql = "UPDATE `order` SET `status` = '$newStatus' WHERE `id` = ".$_GET['id'];
  if($result = $conn->query($sql))
      echo "updated";
    else
      echo "failed";
}else{
  $newStatus = "發生錯誤";
}

?>