<?php

session_start();
include("connectDB.php");

for($i=0; $i<sizeof($_POST['url']); $i++){
  $orId = $_SESSION['or_id'];
  $url = $_POST['url'][$i];
  $sql = "INSERT INTO `album` (`or_id`, `url`) VALUES ('$orId', '$url')";
  
  if($result = $conn->query($sql)){
    echo '<script>
            window.alert("新增成功");
            window.location.href="album.php";
          </script>';
  }
}

?>