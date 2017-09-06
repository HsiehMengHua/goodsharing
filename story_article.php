<?php 

session_start();
include("connectDB.php");

$sql = "SELECT * FROM `story` WHERE `id` = ".$_GET['id'];
$row = $conn->query($sql)->fetch_assoc();

$story_id = $row['id'];
$title = $row['title'];
$datetime = $row['release_datetime'];
$content = $row['content'];

// 找出內文中的第一個圖片
preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content, $matches);
$first_image = (isset($matches[1]))?$matches[1]:"img/transparent.png";

// 此機構的前7篇最新文章，sidebar用
$sql_latest = "SELECT `id`,`title` FROM `story` WHERE `or_id` = ".$row['or_id']." ORDER BY `release_datetime` DESC LIMIT 7";
$result_latest = $conn->query($sql_latest);
//$popularIdList = [];
//$popularTitleList = [];
$latestIdList = array();
$latestTitleList = array();

// 把多項結果存成陣列
while($row_latest = $result_latest->fetch_assoc()){
  array_push($latestIdList,$row_latest['id']);
  array_push($latestTitleList,$row_latest['title']);
}

// 取得上一篇
$sql_prev = 'SELECT `id`,`title`,`content` FROM `story` 
             WHERE `or_id` = '.$row['or_id'].' AND `id` <'.$_GET['id'].' ORDER BY `id` DESC LIMIT 1';
$result_prev = $conn->query($sql_prev);
if($result_prev->num_rows){
  $row_prev = $result_prev->fetch_assoc();
  $prev_id = $row_prev['id'];
  $prev_title = $row_prev['title'];
  $prev_content = $row_prev['content'];
  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $prev_content, $prev_matches);
  $prev_image = (isset($prev_matches[1]))?$prev_matches[1]:"";
}

// 取得下一篇
$sql_next = 'SELECT `id`,`title`,`content` FROM `story` 
             WHERE `or_id` = '.$row['or_id'].' AND `id` >'.$_GET['id'].' ORDER BY `id` ASC LIMIT 1';
$result_next = $conn->query($sql_next);
if($result_next->num_rows){
  $row_next = $result_next->fetch_assoc();
  $next_id = $row_next['id'];
  $next_title = $row_next['title'];
  $next_content = $row_next['content'];
  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $next_content, $next_matches);
  $next_image = (isset($next_matches[1]))?$next_matches[1]:"";
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
  <link rel="stylesheet" href="css/article.css">
</head>
<body>
  <div>
    <a href="#" id="back-to-top" title="Back to top">&uarr;</a>
  </div>
  <header class="clear header-thin">
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
  <main>
    <div class="container">
      <div class="clear">
        <div class="main-content">
          <a href="storyWall.php?orId=<?php echo $row['or_id']; ?>">
            <span>&#65513;</span>回故事牆
          </a>
          <div class="heading">
            <h1><?php echo $title; ?></h1>
            <div class="article-info clear">
              <p><!--<i class="material-icons">schedule</i>-->&nbsp;&nbsp;<?php echo $datetime; ?></p>
              <!--<p class="pull-right">這裡放分享連結</p>-->
              <a href="story_edit.php?id=<?php echo $_GET['id']; ?>" class="edit">編輯</a>
            </div>
          </div>

          <img src="<?php echo $first_image; ?>" alt="title">

          <article>
            <?php echo $content; ?>
          </article>

          <div class="other-container">
            <div class="prev-news" <?php echo ($result_prev->num_rows)?'':'style="display:none"'; ?>>
              <a href="<?php echo "story_article.php?id=$prev_id"; ?>"><p>上一篇文章</p></a>
              <a href="<?php echo "story_article.php?id=$prev_id"; ?>">
                <div class="image" style="background-image: url(<?php echo $prev_image; ?>)"></div>
              </a>
              <a href="<?php echo "story_article.php?id=$prev_id"; ?>">
                <h4><?php echo $prev_title; ?></h4>
              </a>
            </div>
            <div class="next-news pull-right" <?php echo ($result_next->num_rows)?'':'style="display:none"'; ?>>
              <a href="<?php echo "story_article.php?id=$next_id"; ?>"><p>下一篇文章</p></a>
              <a href="<?php echo "story_article.php?id=$next_id"; ?>">
                <div class="image" style="background-image: url(<?php echo $next_image; ?>)"></div>
              </a>
              <a href="<?php echo "story_article.php?id=$next_id"; ?>">
                <h4><?php echo $next_title; ?></h4>
              </a>
            </div>
          </div>
        </div>
        <div class="sidebar pull-right">
          <?php
          
          $sql_orName = "SELECT `name` FROM `organizer` WHERE `or_id` = ".$row['or_id'];
          $row_orName = $conn->query($sql_orName)->fetch_assoc();
          
          ?>
          <h4><?php echo $row_orName['name']; ?>的最新故事</h4>
          <ul>
            <?php
            for($i=0; $i<sizeof($latestIdList); $i++){
              echo '<li><a href="story_article.php?id='.$latestIdList[$i].'">'.$latestTitleList[$i].'</a></li>';
            }
            ?>
          </ul>
        </div>
      </div>
    </div>
  </main>
  
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
    
    var animaion = setInterval(update, 5);
    function update(){
      var y = document.querySelector("body").scrollTop-120;
      if(y>0){
        document.querySelector(".sidebar").style.top = y.toString()+"px";
      }
    }
  </script>
</body>
</html>