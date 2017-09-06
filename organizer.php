<?php 

session_start();
include("connectDB.php");
$sql = "SELECT * FROM `organizer` WHERE `or_id` = ".$_GET['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$orName = $row['name'];

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="plugin/w3-carousel/w3-carousel.css">
  <link rel="stylesheet" href="css/progressbar.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="plugin/niftymodals/dist/jquery.niftymodals.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    .mySlides {display:none; height: 100%;}
  </style>
</head>
<body>
  <div>
    <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="clear header-fixed">
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
  <div class="clear organizer">
    <div class="image">
      <div class="container">
        <?php
        
        $sql_img = "SELECT `url` FROM `album` WHERE `or_id` = ".$_GET['id'];
        $result_img = $conn->query($sql_img);
        while($row_img = $result_img->fetch_assoc()){
          echo '<img class="mySlides w3-animate-right" src="'.$row_img['url'].'">';
        }
        
        ?>
      </div>
    </div>
    <section>
      <div class="container">
        <article>
          <h2><?php echo $row['name'] ?></h2>
          <p><?php echo $row['intro'] ?></p>
        </article>
        <div id="contact" class="contact-info">
          <ul>
            <li>聯絡人：<?php echo $row['contact_person'] ?></li>
            <li>電話：<?php echo $row['phone'] ?></li>
            <li>傳真：<?php echo $row['fax'] ?></li>
            <li>電子信箱：<?php echo $row['email'] ?></li>
            <li>地址：<?php echo $row['address'] ?></li>
          </ul>
        </div>
        
        <?php
  
        $sql_story = "SELECT `id`, `title`, `release_datetime`, `content` 
                      FROM `story` ORDER BY `release_datetime` DESC LIMIT 1";
        $result_story = $conn->query($sql_story);
        $row_story = $result_story->fetch_assoc();
  
        ?>
        
        <div class="story">
          <div class="heading">
            <h3>故事分享</h3>
          </div>
          <div class="content">
            <div class="clear">
              <?php
              
              // 找出內文中的第一個圖片
              preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $row_story['content'], $matches);
              $first_image = (isset($matches[1]))?$matches[1]:"img/transparent.png"; 
              
              ?>
              <div class="image-wrapper">
                <a href="story_article.php?id=<?php echo $row_story['id']; ?>">
                  <img src="<?php echo $first_image; ?>" alt="">
                </a>
              </div>
              <article>
                <h4>
                  <a href="story_article.php?id=<?php echo $row_story['id']; ?>"><?php echo $row_story['title']; ?></a>
                </h4>
                <span><?php echo $row_story['release_datetime']; ?></span>
                <p>
                  <a href="story_article.php?id=<?php echo $row_story['id']; ?>"><?php echo $row_story['content']; ?></a>
                </p>
              </article>
            </div>
          </div>
          <div class="more">
            <a href="storyWall.php?orId=<?php echo $_GET['id']; ?>">看他們的故事牆&#10140;</a>
          </div>
        </div>
        <div class="need-itemsList">
          <div class="heading">
            <h3>正在募集</h3>
          </div>
          <div class="grid">
            <?php
  
            $sql = "SELECT * FROM `needs` WHERE `current_number` <= `number_of_needs` AND `or_id` = ".$_GET['id'];
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
              $currentNeed = $row['number_of_needs'] - $row['current_number'];
              $percentage = ($row['current_number'] / $row['number_of_needs'])*100;
              $image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];
              echo '
              <div class="wrapper">
                <div class="grid-item md-trigger" data-modal="modal-'.$detailId = $row['id'].'">
                  <div class="image-wrapper">
                    <img src="'.$image.'" alt="">
                    <div class="devider"></div>
                  </div>
                  <div class="content">
                    <p class="title">'.$row['title'].'</p>
                    <p class="organizer">'.$orName.'</p>
                    <span>還需&nbsp;'.$currentNeed.'&nbsp;份</span>
                    <div class="w3-progress-container">
                      <div class="w3-progressbar w3-round-large" data-perc="'.$percentage.'">
                      </div>
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
                      <p class="organizer"><a href="organizer.php?id='.$_GET['id'].'">'.$orName.'</a></p>
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
      </div>
    </section>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="plugin/w3-carousel/w3-carousel.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="plugin/niftymodals/dist/jquery.niftymodals.js"></script>
  <script src="js/progressBarAnimation.js"></script>
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
    
    $('.md-trigger').on('click',function(){
      var modal = $(this).data('modal');
      $("#" + modal).niftyModal();
    });
  </script>
</body>
</html>