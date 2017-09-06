<?php

include("connectDB.php");

$account = $_GET["acc"];
$sql = "SELECT * FROM `or_account` WHERE `account` = '$account'";
$result = $conn->query($sql);

if($result->num_rows){
  echo $accountDup = "true";
}else{
  echo $accountDup = "false";
}

?>