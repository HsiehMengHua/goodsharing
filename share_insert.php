<?php

session_start();
include("connectDB.php");

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

$user_id = $_SESSION['member_id'];
$number = $_POST['number'];
$intro = $_POST['intro'];
$image = $_POST['image'];
$sql = "INSERT INTO `share` (`user_id`, `title`, `category`, `offer`, `intro`, `image`) 
        VALUES ('$user_id', '$title', '$category', '$number', '$intro', '$image')";
//$result = $conn->query($sql);
//$row = $result->fetch_assoc();

if($result = $conn->query($sql)){
  echo '<script>
          window.alert("新增成功");
          window.location.href="myAccount.php";
        </script>';

}else{
  echo '<script>
          window.alert("Something wrong!");
          history.back();
        </script>';
}

?>