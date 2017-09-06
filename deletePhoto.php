<?php

session_start();
include("connectDB.php");

$sql = "SELECT `basename` FROM `album` WHERE `id` = ".$_GET['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$basename = $row['basename'];
$or_id = $_SESSION['or_id'];

if($row['basename']==NULL){
  $sql = "DELETE FROM `album` WHERE `id` = ".$_GET['id'];
  if($result = $conn->query($sql)){
    echo '<script>
            window.alert("已從相簿移除");
            window.location.href="album.php";
          </script>';
  }else{
    echo '<script>
          window.alert("Something wrong!");
          window.location.href="album.php";
        </script>';
  }
}else{
  $path = "file_uploaded/$or_id/$basename";
  if(file_exists($path)){
    unlink(iconv("UTF-8", "big5", $path));
    $sql = "DELETE FROM `album` WHERE `id` = ".$_GET['id'];
    if($result = $conn->query($sql)){
      echo '<script>
              window.alert("已從相簿移除");
              window.location.href="album.php";
            </script>';
    }
  }
  echo '<script>
          window.alert("Something wrong!");
          window.location.href="album.php";
        </script>';
}

?>