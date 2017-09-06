<?php 

session_start();
include("connectDB.php"); 

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="css/slideshow.css">
  <link rel="stylesheet" href="plugin/headhesive/headhesive.css">
  <link rel="stylesheet" href="css/progressbar.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="plugin/niftymodals/dist/jquery.niftymodals.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
  <div>
    <a href="boby" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="clear lengthen">
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
  <div class="jumbotron">
    <ul class="rslides">
      <li><img src="img/slides/slide1.jpg" alt=""></li>
      <li><img src="img/slides/slide2.jpg" alt=""></li>
      <li><img src="img/slides/slide3.jpg" alt=""></li>
      <li><img src="img/slides/slide4.jpg" alt=""></li>
      <li><img src="img/slides/slide5.jpg" alt=""></li>
      <li><img src="img/slides/slide6.jpg" alt=""></li>
    </ul>
    <div class="gradient">
      <div class="copy">
        <h1>別讓你的愛心浪費了</h1>
        <p>物資捐贈多不如巧</p>
        <p>讓物資到達真正需要的人手裡</p>
      </div>
      <div class="arrow" onclick="ScrollToMain()">
        <div class="wrapper">
          <span>&#10092;</span>
        </div>
      </div>
    </div>
  </div>
  <main id="a">
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
              <div class="container">

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
                  $sql = "SELECT * FROM `needs` WHERE `title` LIKE '$keyword' AND `category` = '$cate' AND `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16";
                }else{
                  // 有關鍵字，但沒分類
                  $sql = "SELECT * FROM `needs` WHERE `title` LIKE '$keyword' AND `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16";
                }
              }else{
                if(isset($_GET['cate'])){
                  // 沒關鍵字，指定分類
                  $sql = "SELECT * FROM `needs` WHERE `category` = '$cate' AND `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16";
                }else{
                  // 沒關鍵字，也沒分類
                  $sql = "SELECT * FROM `needs` WHERE `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16";
                }
              }

              $result = $conn->query($sql);

              while($row = $result->fetch_assoc()){
                $sql_or = "SELECT * FROM `organizer` WHERE `or_id` = ".$row['or_id'];
                $result_or = $conn->query($sql_or);
                $row_or = $result_or->fetch_assoc();
                $image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];            
                $currentNeed = $row['number_of_needs'] - $row['current_number'];
                $percentage = ($row['current_number'] / $row['number_of_needs'])*100;

                echo '
                <div class="wrapper">
                  <div class="grid-item md-trigger" data-modal="modal-'.$detailId = $row['id'].'">
                    <div class="image-wrapper">
                      <img src="'.$image.'" alt="">
                      <div class="devider"></div>
                    </div>
                    <div class="content">
                      <p class="title">'.$row['title'].'</p>
                      <p class="organizer">'.$row_or['name'].'</p>
                      <span>還需&nbsp;<span class="count">'.$currentNeed.'</span>&nbsp;份</span>
                      <div class="w3-progress-container">
                        <div class="w3-progressbar w3-round-large" data-perc="'.$percentage.'"></div>
                      </div>
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
                        <p class="organizer"><a href="organizer.php?id='.$row['or_id'].'">'.$row_or['name'].'</a></p>
                        <div>
                          <span>還需&nbsp;'.$currentNeed.'&nbsp;份</span>
                          
                          <div class="w3-progress-container">
                            <div class="w3-progressbar w3-round-large" data-perc="'.$percentage.'">
                            </div>
                          </div>
                        </div>
                        <p class="usage">'.$row['usage'].'</p>
                      </div>
                    </div>
                    <div class="devider"></div>
                    <div class="btn clear">
                      <button class="md-close">
                        <div class="icon close-icon">
                          <img src="img/icon/circle-close.png" alt="">
                        </div>
                        <span>返回</span>
                      </button>
                      <div class="devider"></div>
                      <button onclick="window.location.href=\'donate.php?id='.$row['id'].'\'">
                        <div class="icon swing">
                          <img src="img/icon/gift.png" alt="">
                        </div>
                        <span>我要捐贈此物</span>
                      </button>
                    </div>
                  </div>
                </div>';
              }

              ?>
                <div class="md-overlay"></div>
              </div>
              
            </div>
            <div class="listBottom">
              <img src="img/icon/icon_loading.png" alt="" class="loading">
              <div class="end"></div>
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
  <script src="plugin/headhesive/headhesive.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="plugin/niftymodals/dist/jquery.niftymodals.js"></script>
  <script src="js/scrollFadeIn.js"></script>
  <script src="js/progressBarAnimation.js"></script>
  <script>
    function ScrollToMain(){
        var offset = $( window ).height() + 75;
        $('html,body').animate({
            scrollTop: offset
        }, 600);
      }
  </script>
  <script>
    $(document).ready(function() {
      
      /* RWD側邊選單 */

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
      
      
      /* 如果url中有參數，滑到物品列表 */
      
      var hasVar = <?php echo (isset($_GET['keyword']) || isset($_GET['cate']))?1:0; ?>;
      var offset = $( window ).height() + 75;
      if(hasVar){
        $('html,body').animate({
            scrollTop: offset
        }, 600);
      }
      
      
      /* Animated Number */

      $('.count').each(function () {
        $(this).prop('Counter',0).animate({
          Counter: $(this).text()
        }, {
          duration: 4000,
          easing: 'swing',
          step: function (now) {
              $(this).text(Math.ceil(now));
          }
        });
      });
      
      
      /* Pupup Modal */
      
      $('.md-trigger').on('click',function(){
        var modal = $(this).data('modal');
        $("#" + modal).niftyModal();
      });
    });
    
    
    /* Auto Load Page */
    
    var pg = 1;
    $(window).scroll(function() {
      if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        loadPage();
      }
    });

    function loadPage(){
      var url = decodeURI(window.location.search.toString());
      if(url.indexOf("?") == -1){
        // url中沒有"?" 也就是沒有參數
        var urlSent = "?pg="+pg;
      }else{
        var urlSent = url+"&pg="+pg;
      }
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
          if(xhttp.responseText == 'end')
            $(".end").text("end");
          else
            $(xhttp.responseText).insertBefore( ".md-overlay" );
          $(".loading").css("display","none");
        }else{
          $(".loading").css("display","block");
        }
        console.log(xhttp.responseText);
      };
      xhttp.open("GET","load.php"+urlSent,true);
      xhttp.send();
      pg++;
    }
  </script>
</body>
</html>