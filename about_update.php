<?php

session_start();
include("connectDB.php");

$name = $_POST['name'];
$contact = $_POST['contact'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$email = $_POST['email'];
$address = $_POST['address'];
$intro = $_POST['intro'];
$sql = "UPDATE `organizer` 
        SET `name` = '$name', `contact_person` = '$contact', `phone` = '$phone', `fax` = '$fax', 
            `email` = '$email', `address` = '$address', `intro` = '$intro' 
        WHERE `or_id` = ".$_SESSION['or_id'];
//$result = $conn->query($sql);
//$row = $result->fetch_assoc();

if($result = $conn->query($sql)){
  echo '<script>
          window.alert("編輯成功");
          window.location.href="orAccount.php";
        </script>';
}else{
  echo 'failed';
  echo '<script> history.back(); </script>';
}

?>