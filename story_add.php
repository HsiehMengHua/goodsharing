<?php

session_start();
include("connectDB.php");

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Document</title>
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/formPage.css">
  <script src="//cdn.ckeditor.com/4.5.9/standard/ckeditor.js"></script><!-- See → http://cdn.ckeditor.com/ -->
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
            echo '<a href="orAccount.php">帳號管理</a>';
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
      <form action="story_insert.php" method="post">
        <ul>
          <li>
            <label>故事標題
              <input name="title">
            </label>
          </li>
          <!--<li>內文<br>
            <textarea name="content" cols="30" rows="1" onkeyup="auto_grow(this)"></textarea>
          </li>-->
          <li class="editor">編輯內容<br><br>
            <textarea name="editor"></textarea>
            <script>CKEDITOR.replace( 'editor' );</script>
          </li>
          <li class="clear">
            <button class="submit btn waves-effect waves-light orange accent-2" type="submit" name="action">送出</button>
            <button onclick="history.back();" class="cancel">取消</button>
          </li>
        </ul>
      </form>
    </div>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
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
      console.log(url);
    }
  </script>
</body>
</html>