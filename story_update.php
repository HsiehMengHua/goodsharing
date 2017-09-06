<?php

session_start();
include("connectDB.php");

$title = $_POST['title'];
$or_id = $_SESSION['or_id'];
$content = $_POST['editor'];

$sql = "UPDATE `story` SET `title` = '$title', `content` = '$content' WHERE `id` = ".$_GET['id'];
if($result = $conn->query($sql)){
  echo '<script>
          window.alert("編輯成功");
          window.location.href="story_article.php?id='.$_GET['id'].'";
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