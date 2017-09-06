<?php

session_start();
include("connectDB.php");

$title = $_POST['title'];
$or_id = $_SESSION['or_id'];
$datetime = date("Y-m-d H:i:s");
$content = $_POST['editor'];

$sql = "INSERT INTO `story` (`or_id`, `title`, `release_datetime`, `content`) 
        VALUES ('$or_id', '$title', '$datetime', '$content')";
if($result = $conn->query($sql)){
  $sql = "SELECT `id` FROM `story` WHERE `or_id` = '$or_id' ORDER BY `id` DESC LIMIT 1";
  $row = $conn->query($sql)->fetch_assoc();
  echo '<script>
          window.alert("新增成功");
          window.location.href="story_article.php?id="'.$row['id'].';
        </script>';
}else{
  echo '<script>
          window.alert("發生錯誤");
          history.back();
        </script>';
}

/*
if($result = $conn->query($sql)){
  echo '<script>
          window.alert("新增成功");
          window.location.href="orAccount.php";
        </script>';
}else{
  echo 'failed';
  //echo '<script> history.back(); </script>';
}*/

?>