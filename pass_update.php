<?php

session_start();
include("connectDB.php");

if(isset($_SESSION['member_id'])){
  $pass = md5(input($_POST["password"]));
  $sql = "UPDATE `member` 
          SET `password` = '$pass' 
          WHERE `id` = ".$_SESSION['member_id'];
  $to = "myAccount.php";
}else if(isset($_SESSION['or_id'])){
  $pass = input($_POST["password"]);
  $sql = "UPDATE `or_account` 
          SET `password` = '$pass' 
          WHERE `id` = ".$_SESSION['or_id'];
  $to = "orAccount.php";
}else if(isset($_POST['email'])){
  $pass = md5(input($_POST["password"]));
  $sql = "UPDATE `member` 
          SET `password` = '$pass' 
          WHERE `email` = '".$_POST['email']."'";
  $to = "myAccount.php";
}else if(isset($_POST['account'])){
  $pass = input($_POST["password"]);
  $sql = "UPDATE `or_account` 
          SET `password` = '$pass' 
          WHERE `account` = '".$_POST['account']."'";
  $to = "orAccount.php";
}else{
  $to = "index.php";
  echo '<script>
        window.alert("你是誰???");
        window.location.href="'.$to.'";
      </script>';
}

if($result = $conn->query($sql)){
  if(isset($_POST['email'])){
    $sql = "SELECT `id` FROM `member` WHERE `email` = '".$_POST['email']."'";
    $row = $conn->query($sql)->fetch_assoc();
    $_SESSION['member_id'] = $row['id'];
  }else if(isset($_POST['account'])){
    $sql = "SELECT `id` FROM `or_account` WHERE `account` = '".$_POST['account']."'";
    $row = $conn->query($sql)->fetch_assoc();
    $_SESSION['or_id'] = $row['id'];
  }

  echo '<script>
          window.alert("修改成功");
          window.location.href="'.$to.'";
        </script>';
}else{
  echo 'failed';
  //echo '<script> history.back(); </script>';
}

function input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>