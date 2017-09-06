<?php

session_start();
include("connectDB.php");

$sql = "SELECT * FROM `share` WHERE `id` = ".$_GET['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="css/numberSpinner.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/formPage.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
  <div>
    <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="clear">
    <div class="logo">
      <a href="index.php">
        <img src="img/logo.png" alt="">
      </a>
    </div>
    <nav>
      <div class="navLeft">
        <ul>
          <li><a href="index.php">物資需求</a></li>
          <li><a href="share.php">物資分享</a></li>
        </ul>
      </div>
      <div class="navRight">
        <?php 
          if(isset($_SESSION['member_id'])){
            echo '<a href="logout.php">登出</a>';
            echo '&nbsp;/&nbsp;';
            echo '<a href="myAccount.php">帳號管理</a>';
          }else if(isset($_SESSION['or_id'])){
            echo '<a href="logout.php">登出</a>';
            echo '&nbsp;/&nbsp;';
            echo '<a href="orAccount.php">帳號管理</a>';
          }else{
            echo '<a href="login.php">登入</a>';
            echo '&nbsp;/&nbsp;';
            echo '<a href="register.php">註冊</a>';
          }
        ?>
      </div>
    </nav>
  </header>
  
  <div class="form">
    <div class="container">
      <form action="share_update.php?id=<?php echo $_GET['id']; ?>" method="post" class="clear">
        <div class="image">
          <img src="<?php echo ($row['image'] == NULL)?'img/default_image.jpg':$row['image']; ?>" alt="">
          <li>
            <label>圖片連結
              <input name="image" onkeyup="preview(this)" value="<?php echo $row['image']; ?>">
            </label>
          </li>
        </div>
        <ul class="content">
          <li>
            <label>物品名稱
              <input name="title" value="<?php echo $row['title']; ?>">
            </label>
          </li>
          <li>
            <label>物品分類</label>
            <select name="category">
              <option disabled>選擇分類</option>
              <option value="cate1" <?php if($row['category']=='家電機器') echo 'selected'; ?>>家電機器</option>
              <option value="cate2" <?php if($row['category']=='生活用品') echo 'selected'; ?>>生活用品</option>
              <option value="cate3" <?php if($row['category']=='嬰幼童用品') echo 'selected'; ?>>嬰幼童用品</option>
              <option value="cate4" <?php if($row['category']=='食物飲品') echo 'selected'; ?>>食物飲品</option>
              <option value="cate5" <?php if($row['category']=='服飾配件') echo 'selected'; ?>>服飾配件</option>
              <option value="cate6" <?php if($row['category']=='居家擺設') echo 'selected'; ?>>居家擺設</option>
              <option value="cate7" <?php if($row['category']=='健康管理') echo 'selected'; ?>>健康管理</option>
              <option value="cate8" <?php if($row['category']=='運動休閒') echo 'selected'; ?>>運動休閒</option>
              <option value="cate9" <?php if($row['category']=='毛小孩用品') echo 'selected'; ?>>毛小孩用品</option>
              <option value="cate10" <?php if($row['category']=='交通工具') echo 'selected'; ?>>交通工具</option>
            </select>
          </li>
          <li>
            <label>可提供數量
              <span class="spinner">
                <a class="sub btn-floating waves-effect waves-light blue-grey darken-1">&#45;</a>
                <input type="number" name="number" min="1" value="1">
                <a class="add btn-floating waves-effect waves-light blue-grey darken-1">&#43;</a>
              </span>
            </label>
          </li>
          <li>說明<br>
            <textarea name="intro" cols="30" rows="1" onkeyup="auto_grow(this)"><?php echo $row['intro']; ?></textarea>
          </li>
          <li class="clear">
            <button class="btn waves-effect waves-light orange accent-2" type="submit" name="action">送出</button>
            <button onclick="history.back();" class="cancel">取消</button>
          </li>
        </ul>
      </form>
    </div>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
  <script src="js/numberSpinner.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="js/formPage.js"></script>
  <script>
    function auto_grow(element) {
      element.style.height = "5px";
      element.style.height = (element.scrollHeight)+"px";
    }
    
    function preview(elem){
      var url = elem.value;
      elem.parentNode.parentNode.parentNode.parentNode.querySelector('img').src = url;
    }
  </script>
</body>
</html>