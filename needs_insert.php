<?php

session_start();
include("connectDB.php");

if(empty($_POST['title'])){
  echo '<script>
          window.alert("請輸入物品名稱");
          history.back();
        </script>';
}else if(empty($_POST['category'])){
  echo '<script>
          window.alert("請選擇分類");
          history.back();
        </script>';
}else{

  $title = $_POST['title'];

  if($_POST['category'] == "cate1")
    $category = "家電機器";
  else if($_POST['category'] == "cate2")
    $category = "生活用品";
  else if($_POST['category'] == "cate3")
    $category = "嬰幼童用品";
  else if($_POST['category'] == "cate4")
    $category = "食物飲品";
  else if($_POST['category'] == "cate5")
    $category = "服飾配件";
  else if($_POST['category'] == "cate6")
    $category = "居家擺設";
  else if($_POST['category'] == "cate7")
    $category = "健康管理";
  else if($_POST['category'] == "cate8")
    $category = "運動休閒";
  else if($_POST['category'] == "cate9")
    $category = "毛小孩用品";
  else if($_POST['category'] == "cate10")
    $category = "交通工具";

  $or_id = $_SESSION['or_id'];
  $number = $_POST['number'];
  $usage = $_POST['usage'];
  $image = $_POST['image'];
  $sql = "INSERT INTO `needs` (`title`, `category`, `or_id`, `number_of_needs`, `usage`, `image`) 
          VALUES ('$title', '$category', '$or_id', '$number', '$usage', '$image')";
  //$result = $conn->query($sql);
  //$row = $result->fetch_assoc();

  if($result = $conn->query($sql)){
    echo '<script>
            window.alert("新增成功");
            window.location.href="orAccount.php";
          </script>';
  }else{
    echo 'failed';
    //echo '<script> history.back(); </script>';
  }
}
?>