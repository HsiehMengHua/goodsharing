<?php

session_start();
include("connectDB.php");

if(isset($_SESSION['or_id'])){
  $sql = "SELECT * FROM `organizer` WHERE `or_id` = ".$_SESSION['or_id'];
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $orName = $row['name'];
}else{
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
  <link rel="stylesheet" href="plugin/w3-carousel/w3-carousel.css">
  <link rel="stylesheet" href="css/progressbar.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/orAccount.css">
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
        <!--<p>還沒有新增相片唷</p>-->
        <?php
        
        $sql_img = "SELECT `url` FROM `album` WHERE `or_id` = ".$_SESSION['or_id'];
        $result_img = $conn->query($sql_img);
        while($row_img = $result_img->fetch_assoc()){
          echo '<img class="mySlides w3-animate-right" src="'.$row_img['url'].'">';
        }
        
        ?>
        <div class="edit">
          <div class="container">
            <a href="album.php">管理相簿</a>
          </div>
        </div>
      </div>
    </div>
    <section class="or-account">
      <div class="container">
        <div class="back">
          <a href="change_pass.php">修改密碼</a>
        </div>
        <article class="about-info">
          <div class="edit-tag"><a href="about_edit.php">編輯</a></div>
          <div class="intro">
            <h2><?php echo $row['name'] ?></h2>
            <p><?php echo $row['intro'] ?></p>
          </div>
          <div id="contact" class="contact-info">
            <ul>
              <li>聯絡人：<?php echo $row['contact_person'] ?></li>
              <li>電話：<?php echo $row['phone'] ?></li>
              <li>傳真：<?php echo $row['fax'] ?></li>
              <li>電子信箱：<?php echo $row['email'] ?></li>
              <li>地址：<?php echo $row['address'] ?></li>
            </ul>
          </div>
        </article>

        <div class="contentBlk">
          <div class="heading clear">
            <h3>贈物紀錄</h3>
            <a href="orderAll.php" class="more">看全部&#10140;</a>
          </div>
          <div class="order-list">
           
            <?php
            
            $sql = "SELECT `order`.`id`,`datetime`,`num`,`status`,`remark`,`sendDate`,`arriveDate`,
                           `member`.`name`,  `needs`.`title`,`image`
                    FROM `order`
                    INNER JOIN `member`
                    ON `order`.`member_id` = `member`.`id`
                    INNER JOIN `needs`
                    ON `order`.`need_id` = `needs`.`id`
                    WHERE `needs`.`or_id` = ".$_SESSION['or_id']."
                    ORDER BY `order`.`datetime` DESC LIMIT 2";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
              $hide = ($row['status'] == "已送達" || $row['status'] == "已取消")?'style="display:none"':'';
              $image = ($row['image']==NULL)?"img/default_image.jpg":$row['image'];
              
              echo '
              <div class="order-list-item">
                <p class="datetime">'.$row['datetime'].'</p>
                <table>
                  <thead>
                    <tr>
                      <th class="col-1">物品名稱</th>
                      <th class="col-2">數量</th>
                      <th class="col-3">狀態</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="col-1">
                        <div class="image-wrapper">
                          <img src="'.$image.'" alt="">
                        </div>
                        <p>'.$row['title'].'</p>
                      </td>
                      <td class="col-2">'.$row['num'].'</td>
                      <td class="col-3">
                        <div>
                          <p>'.$row['status'].'</p>
                          <button class="sent" onclick="updateStatus(this, '.$row['id'].', \'arrived\')" '.$hide.'>登記已送達</button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3" class="order-detail clear">
                        <ul class="left">
                          <li>贈物單編號</li>
                          <li>成立日期</li>
                          <li>贈物者</li>
                          <li>寄送日期</li>
                          <li>送達日期</li>
                          <li>備註說明</li>
                        </ul>
                        <div class="devider"></div>
                        <ul>
                          <li>'.$row['id'].'</li>
                          <li>'.$row['datetime'].'</li>
                          <li>'.$row['name'].'</li>
                          <li>'.$row['sendDate'].'</li>
                          <li>'.$row['arriveDate'].'</li>
                          <li>'.$row['remark'].'</li>
                        </ul>
                      </th>
                    </tr>
                  </tbody>
                </table>
              </div>';
            }
            ?>
            
          </div>
        </div>

        <div class="contentBlk story">
          <div class="heading clear">
            <h3>故事分享</h3>
            <a href="story_add.php">&#43;&nbsp;新增故事</a>
          </div>
          <?php
              
          $sql_story = "SELECT `id`, `title`, `release_datetime`, `content`
                        FROM `story` WHERE `or_id` = ".$_SESSION['or_id']." ORDER BY `release_datetime` DESC LIMIT 1";
          $result_story = $conn->query($sql_story);
          $row_story = $result_story->fetch_assoc();
          
          $hideContent = (!$result_story->num_rows)?'style="display:none"':'';

          // 找出內文中的第一個圖片
          preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $row_story['content'], $matches);
          $first_image = (isset($matches[1]))?$matches[1]:"img/transparent.png"; 

          ?>
          <div class="content" <?php echo $hideContent; ?>>
            <div class="clear">
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
            <a href="storyWall.php?orId=<?php echo $_SESSION['or_id']; ?>">故事牆&#10140;</a>
          </div>
        </div>
        
        <div class="contentBlk need-itemsList">
          <div class="heading clear">
            <h3>正在募集</h3>
            <a href="needs_add.php">&#43;&nbsp;新增品項</a>
          </div>
          <div class="grid">
            <?php
  
            $sql = "SELECT * FROM `needs` WHERE `current_number` <= `number_of_needs` AND `or_id` = ".$_SESSION['or_id']." ORDER BY `id` DESC";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
              $percentage = ($row['current_number'] / $row['number_of_needs'])*100;
              $image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];
              echo '
              <div class="wrapper">
                <div class="grid-item">
                  <div class="edit-tag"><a href="needs_edit.php?id='.$row['id'].'">編輯</a></div>
                  <div class="image-wrapper">
                    <img src="'.$image.'" alt="">
                    <div class="devider"></div>
                  </div>
                  <div class="content">
                    <p class="title"><a href="">'.$row['title'].'</a></p>
                    <p class="organizer"><a href="">'.$orName.'</a></p>
                    <div class="current-num">
                      <span>已徵得&nbsp;'.$row['current_number'].'&nbsp;份</span>
                    </div>
                    <form action="update_num.php" method="post">
                      <div class="update-number clear">
                        <div>
                          <span>已徵得&nbsp;<input type="number" name="number" value="'.$row['current_number'].'">&nbsp;份</span>
                        </div>
                        <input name="id" value="'.$row['id'].'" class="hide">
                        <button type="submit">確定</button>
                      </div>
                    </form>
                    <div class="w3-progress-container">
                      <div class="w3-progressbar w3-round-large" data-perc="'.$percentage.'"></div>
                    </div>
                    <button id="toggle" class="update">更新已徵得數量</button>
                  </div>
                </div>
              </div>';
            }

            ?>
          </div>
        </div>
      </div>
    </section>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="plugin/w3-carousel/w3-carousel.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
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
    
    $('tbody .col-1, tbody .col-2').click(function(e){
      e.preventDefault();
      $(this).parent().parent().find(".order-detail").slideToggle("slow");
    });
    
    $('#toggle.update').click(function(){
      $(this).prev().prev().prev().css("display","none");
      $(this).prev().prev().css("display","block");
      $(this).removeClass("update").addClass("disabled").attr("disabled", true);
    });
    
    function updateStatus(elem, orderId, newStatus){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
          if(xhttp.responseText == "updated"){
            elem.previousElementSibling.innerHTML = "已送達";
            elem.style.display = "none";
          }else{
            console.log(xhttp.responseText);
          }
        }
      };
      xhttp.open("GET","updateStatus.php?id="+orderId+"&st="+newStatus,true);
      xhttp.send();
      console.log(xhttp.responseText);
    }
  </script>
</body>
</html>