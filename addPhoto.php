<?php

session_start();
include("connectDB.php");

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/formPage.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
  <div>
    <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="clear">
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
  <section>
    <div id="tabs">
      <ul class="by clear">
        <li class="active"><a href="#tabs-1">圖片連結</a></li>
        <li><a href="#tabs-2">從本機上傳</a></li>
      </ul>
      <div id="tabs-1">
        <div class="form">
            <div class="container">
              <form action="album_insert.php" method="post">
                <div class="clear">
                  <div class="image">
                    <img src="img/default_image.jpg" alt="">
                  </div>
                  <ul class="content">
                    <li>
                      <label>貼上圖片URL
                        <input name="url[]" onkeyup="preview(this)">
                      </label>
                    </li>
                  </ul>
                </div>
                <div id="add"><span>&#43;&nbsp;增加欄位</span></div>
                <div class="clear">
                  <button class="btn waves-effect waves-light orange accent-2" type="submit" name="action">送出</button>
                  <button onclick="history.back();" class="cancel">取消</button>
                </div>
              </form>
            </div>
          </div>
      </div>
      <div id="tabs-2">
        <div class="form">
            <div class="container">
              <form action="album_upload.php" method="post" enctype="multipart/form-data">
                <div class="clear">
                  <div class="image">
                    <img src="img/default_image.jpg" alt="">
                  </div>
                  <ul class="content">
                    <li>
                      <label>從本機上傳
                        <input type="file" name="imageUpload[]" multiple>
                      </label>
                    </li>
                  </ul>
                </div>
                <div class="clear">
                  <button class="submit btn waves-effect waves-light orange accent-2" type="submit" name="action">送出</button>
                  <button onclick="history.back();" class="cancel">取消</button>
                </div>
              </form>
            </div>
          </div>
      </div>
    </div>
  </section>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="js/formPage.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    
    $( function() {
      $( "#tabs" ).tabs();
    } );
    
    $(".by li a").click(function(){
      $(".by li.active").removeClass("active");
      $(this).parent().addClass("active");
    });
  </script>
  <script>
    
    function preview(elem){
      var url = elem.value;
      elem.parentNode.parentNode.parentNode.parentNode.querySelector('img').src = url;
    }
    
    var html = '<div class="clear"><div class="image"><img src="img/default_image.jpg" alt=""></div><ul class="content"><li><label>貼上圖片URL<input name="url[]" onkeyup="preview(this)"></label></li></ul></div>';
    $('#add').on("click", function(){
      $(this).before(html);
    });
    
  </script>
</body>
</html>