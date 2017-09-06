<?php

session_start();
include("connectDB.php");

if(isset($_SESSION['member_id'])){
  $sql = "SELECT * FROM `member` WHERE `id` = ".$_SESSION['member_id'];
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $orName = $row['name'];
}else{
  echo '<script>
          window.alert("登入先唷");
          window.location.href="login.php";
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
  <div class="my-account">
    <section>
      <div class="container">
        <article class="about-info">
          <div class="edit-tag"><a href="profile_edit.php">編輯</a></div>
          <div>
            <h2><?php echo $row['name'] ?><span>&nbsp;小姐/先生，你好！</span></h2>
          </div>
          <div class="contact-info profile">
            <ul>
              <li>電子信箱：<?php echo $row['email'] ?></li>
              <li>密碼：&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;</li>
              <li>電話：<?php echo $row['phone'] ?></li>
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
                           `needs`.`title`,`image`, 
                           `organizer`.`or_id`,`name` 
                    FROM `order` 
                    INNER JOIN `needs`
                    ON `order`.`need_id` = `needs`.`id` 
                    INNER JOIN `organizer`
                    ON `organizer`.`or_id` = `needs`.`or_id`
                    WHERE `order`.`member_id` = ".$_SESSION['member_id']."
                    ORDER BY `datetime` DESC LIMIT 2";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
              $hide = ($row['status'] != "待寄送")?'style="display:none"':'';
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
                        <div class="clear">
                          <p>'.$row['status'].'</p>
                          <div class="btn" '.$hide.'>
                            <button class="sent" 
                                    onclick="updateStatus(this, '.$row['id'].', \'delivering\')">
                            通知已寄送</button>
                            <button class="cancel" 
                                    onclick="updateStatus(this, '.$row['id'].', \'cancel\')">
                            取消贈物</button>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="3" class="order-detail clear">
                        <ul class="left">
                          <li>贈物單編號</li>
                          <li>成立日期</li>
                          <li>社福單位</li>
                          <li>寄送日期</li>
                          <li>送達日期</li>
                          <li>備註說明</li>
                        </ul>
                        <div class="devider"></div>
                        <ul>
                          <li>'.$row['id'].'</li>
                          <li>'.$row['datetime'].'</li>
                          <li><a href="organizer.php?id='.$row['or_id'].'">'.$row['name'].'</a></li>
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
        
        <div class="contentBlk">
          <div class="heading clear">
            <h3>我的物品</h3>
            <a href="share_add.php">&#43;&nbsp;新增品項</a>
          </div>
          <div class="grid need-itemsList">
            <?php
  
            $sql = "SELECT * FROM `share` WHERE `user_id` = ".$_SESSION['member_id']." ORDER BY `id` DESC";
            $result = $conn->query($sql);

            while($row = $result->fetch_assoc()){
              $image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];
              echo '
              <div class="wrapper">
                <div class="grid-item">
                  <div class="edit-tag"><a href="share_edit.php?id='.$row['id'].'">編輯</a></div>
                  <div class="image-wrapper">
                    <img src="'.$image.'" alt="">
                    <div class="devider"></div>
                  </div>
                  <div class="content">
                    <p class="title"><a href="">'.$row['title'].'</a></p>
                    <span>可提供&nbsp;'.$row['offer'].'&nbsp;份</span>
                    <form action="update_num.php" method="post" style="margin-bottom:10px">
                      <div class="update-number clear">
                        <div>
                          <span class="offer">可提供&nbsp;<input type="number" name="number" value="'.$row['offer'].'">&nbsp;份</span>
                        </div>
                        <input name="id" value="'.$row['id'].'" class="hide">
                        <button type="submit">確定</button>
                      </div>
                    </form>
                    <button id="toggle" class="update" type="submit" name="action">更新可提供數量</button>
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
    
    $('#toggle.update').click(function(){
      $(this).prev().prev().css("display","none");
      $(this).prev().css("display","block");
      $(this).removeClass("update").addClass("disabled").attr("disabled", true);;
    });
    
    $('tbody .col-1, tbody .col-2').click(function(e){
      e.preventDefault();
      $(this).parent().parent().find(".order-detail").slideToggle("slow");
    });
    
    function updateStatus(elem, orderId, newStatus){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
          console.log(xhttp.responseText);
          if(xhttp.responseText == "updated"){
            if(newStatus == 'delivering'){
              elem.parentNode.previousElementSibling.innerHTML = "運送中";
              elem.parentNode.style.display = "none";
            }else if(newStatus == 'cancel'){
              elem.parentNode.previousElementSibling.innerHTML = "已取消";
              elem.parentNode.style.display = "none";
            }
          }
        }
      };
      xhttp.open("GET","updateStatus.php?id="+orderId+"&st="+newStatus,true);
      xhttp.send();
    }
  </script>
</body>
</html>