<?php

session_start();
include("connectDB.php");

if(!isset($_SESSION['or_id'])){
  echo '<script>
          window.alert("登入先唷");
          window.location.href="orLogin.php";
        </script>';
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/orAccount.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
  <div>
    <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="clear header-fixed" style="position:static">
    <div class="nav-icon4">
      <span></span>
      <span></span>
      <span></span>
    </div>
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
  <aside>
    <nav>
      <ul>
        <li><a href="index.php">物資需求</a></li>
        <li><a href="share.php">物資分享</a></li>
        <li class="accAct">
          <?php

          if(isset($_SESSION['member_id']))
            echo '<a href="myAccount.php">帳號管理</a>';
          else if(isset($_SESSION['or_id']))
            echo '<a href="orAccount.php">帳號管理</a>';
          else
            echo '<a href="login.php">登入</a>';

          ?>
        </li>
        <li class="accAct">
          <?php

          if(isset($_SESSION['member_id']) || isset($_SESSION['or_id']))
            echo '<a href="logout.php">登出</a>';
          else
            echo '<a href="register.php">註冊</a>';

          ?>
        </li>
      </ul>
    </nav>
  </aside>
  <div>
    <div class="album">
      <section>
        <div class="container">
          <div class="heading clear">
            <h3>我的相片</h3>
            <a href="addPhoto.php">&#43;&nbsp;新增照片</a>
          </div>
          <div class="back">
            <a href="orAccount.php">
              <span>&#65513;</span>回上頁
            </a>
          </div>
          <div class="grid">
            <?php
            
            $sql = "SELECT `id`, `url` FROM `album` WHERE `or_id` = ".$_SESSION['or_id'];
            $result = $conn->query($sql);
            
            while($row = $result->fetch_assoc()){
              echo '
              <div class="wrapper">
                <div class="grid-item">
                  <div class="edit-tag"><a href="deletePhoto.php?id='.$row['id'].'">刪除</a></div>
                  <div>
                    <img src="'.$row['url'].'" alt="">
                  </div>
                </div>
              </div>';
            }
            
            ?>
          </div>
        </div>
      </section>
    </div>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script>
  var open = false;
  $('.nav-icon4').on('click', function(){
    open = !open;
    if(open){
      $('aside').animate({left: "0"},200);
      $(this).addClass("open");
    }else{
      $('aside').animate({left: "-250px"},200);
      $(this).removeClass("open");
    }
  });
  </script>
</body>
</html>