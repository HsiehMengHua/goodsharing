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
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="plugin/niftymodals/dist/jquery.niftymodals.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div>
    <a href="boby" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="header-fixed clear">
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
  <main class="sharePage">
    <div class="container clear">
      <aside>
        <div class="searchBox">
          <form action="index.php" method="get">
            <input name="keyword" id="keyword-input">
            <input name="cate" style="display:none" 

            <?php 
            if(isset($_GET['cate']))
              echo 'value="'.$_GET['cate'].'"';
            else
              echo 'disabled';
            ?>>

            <button type="submit" id="search-btn" style="display:none">
              <img src="img/icon/search.png" alt="">
            </button>
          </form>
        </div>
        <ul>
          <li><a href="index.php">全部</a></li>
          <li><a href="index.php?cate=1">家電機器</a></li>
          <li><a href="index.php?cate=2">生活用品</a></li>
          <li><a href="index.php?cate=3">嬰幼童用品</a></li>
          <li><a href="index.php?cate=4">食物飲品</a></li>
          <li><a href="index.php?cate=5">服飾配件</a></li>
          <li><a href="index.php?cate=6">居家擺設</a></li>
          <li><a href="index.php?cate=7">健康管理</a></li>
          <li><a href="index.php?cate=8">運動休閒</a></li>
          <li><a href="index.php?cate=9">毛小孩用品</a></li>
          <li><a href="index.php?cate=10">交通工具</a></li>
        </ul>
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
        <div class="container">
          <div class="heading clear">
            <h2>物資需求</h2>
          </div>

          <!-- 物品列表 -->

          <article>
            <div class="grid">

            <?php

            if(isset($_GET['cate'])){
              if($_GET['cate'] == 1)
                $cate = '家電機器';
              else if($_GET['cate'] == 2)
                $cate = '生活用品';
              else if($_GET['cate'] == 3)
                $cate = '嬰幼童用品';
              else if($_GET['cate'] == 4)
                $cate = '食物飲品';
              else if($_GET['cate'] == 5)
                $cate = '服飾配件';
              else if($_GET['cate'] == 6)
                $cate = '居家擺設';
              else if($_GET['cate'] == 7)
                $cate = '健康管理';
              else if($_GET['cate'] == 8)
                $cate = '運動休閒';
              else if($_GET['cate'] == 9)
                $cate = '毛小孩用品';
              else if($_GET['cate'] == 10)
                $cate = '交通工具';
            }

            if(isset($_GET['keyword'])){
              $keyword = '%'.$_GET['keyword'].'%';
              if(isset($_GET['cate'])){
                // 有給分類和關鍵字
                $sql = "SELECT * FROM `share` WHERE `title` LIKE '$keyword' AND `category` = '$cate' AND `offer` != 0";
              }else{
                // 有關鍵字，但沒分類
                $sql = "SELECT * FROM `share` WHERE `title` LIKE '$keyword' AND `offer` != 0";
              }
            }else{
              if(isset($_GET['cate'])){
                // 沒關鍵字，指定分類
                $sql = "SELECT * FROM `share` WHERE `category` = '$cate' AND `offer` != 0";
              }else{
                // 沒關鍵字，也沒分類
                $sql = "SELECT * FROM `share` WHERE `offer` != 0";
              }
            }
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
              $image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];
              $sql_contact = "SELECT `name`,`email`,`phone` FROM `member` WHERE `id` = ".$row['user_id'];
              $result_contact = $conn->query($sql_contact);
              $row_contact = $result_contact->fetch_assoc();

              echo '
              <div class="wrapper">
                <div class="grid-item md-trigger" data-modal="modal-'.$row['id'].'"">
                  <div class="image-wrapper">
                    <img src="'.$image.'" alt="">
                    <div class="devider"></div>
                  </div>
                  <div class="content">
                    <p class="title">'.$row['title'].'</p>
                    <span>可提供&nbsp;'.$row['offer'].'&nbsp;份</span>
                  </div>
                </div>
              </div>

              <div class="md-container md-effect-3" id="modal-'.$row['id'].'">
                <div class="md-content">
                  <div class="container clear">
                    <div class="image">
                      <img src="'.$image.'" alt="">
                    </div>
                    <div class="content">
                      <p class="title">'.$row['title'].'</p>
                      <span>可提供&nbsp;'.$row['offer'].'&nbsp;份</span>
                      <p class="usage">'.$row['intro'].'</p>
                    </div>
                  </div>
                  <div>
                    <h3>跟他聯絡</h3>
                    <ul>
                      <li>聯絡人：'.$row_contact['name'].'</li>
                      <li>聯絡電話：'.$row_contact['phone'].'</li>
                      <li>電子信箱：'.$row_contact['email'].'</li>
                    </ul>
                  </div>
                </div>
              </div>';
            }
            ?>
            
              
            
            <!--
                  <div class="devider"></div>
                  <div class="btn clear">
                    <button class="md-close">
                      <div class="icon close-icon">
                        <img src="img/icon/circle-close.png" alt="">
                      </div>
                      <span>返回</span>
                    </button>
                    <div class="devider"></div>
                    <button>
                      <div class="icon">
                        <img src="img/icon/contact.png" alt="">
                      </div>
                      <span>跟他聯繫</span>
                    </button>
                  </div>
            -->
            
            <div class="md-overlay"></div>
            </div>
          </article>
        </div>
      </section>
    </div>
  </main>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="plugin/ResponsiveSlides/responsiveslides.min.js"></script>
  <script>
    $(function() {
      $(".rslides").responsiveSlides();
    });
  </script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="plugin/niftymodals/dist/jquery.niftymodals.js"></script>
  <script>
  $('.grid-item').slice(0,8).css("opacity","1");
  </script>
  <script src="js/scrollFadeIn.js"></script>
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
    
    function ScrollToMain(){
        var offset = $( window ).height() + 75;
        $('html,body').animate({
            scrollTop: offset
        }, 600);
      }
    
    $(document).ready(function() {
      var hasVar = <?php echo (isset($_GET['keyword']) || isset($_GET['cate']))?1:0; ?>;
      var offset = $( window ).height() + 75;
      if(hasVar){
        $('html,body').animate({
            scrollTop: offset
        }, 600);
      }
      
      $('.md-trigger').on('click',function(){
        var modal = $(this).data('modal');
        $("#" + modal).niftyModal();
      });
    });
  </script>
</body>
</html>