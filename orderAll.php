<?php

session_start();
include("connectDB.php");

if(!isset($_SESSION['or_id']) && !isset($_SESSION['member_id'])){
  echo '<script>
          window.alert("登入先唷");
          window.location.href="login.php";
        </script>';
}

if(!isset($_GET['startDate']) || !isset($_GET['endDate'])){
  $_GET['startDate'] = date("Y-m-d", strtotime("-30 days"));
  $_GET['endDate'] = date("Y-m-d");
}

if(isset($_GET['status'])){
  if($_GET['status']=='toBeSent')
    $status = "待寄送";
  else if($_GET['status']=='delivering')
    $status = "運送中";
  else if($_GET['status']=='arrived')
    $status = "已送達";
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="plugin/datetimePicker/bootstrap-material-datetimepicker.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/orAccount.css">
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
    <div class="orderAll">
      <section>
        <div class="container">
          <div class="heading">
            <h3>贈物紀錄</h3>
          </div>
          <div class="searchBox">
            <div class="clear">
              <div>
                <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']);?>" method="get">
                  <span>日期</span>
                  <input class="date" name="startDate" value="<?php echo $_GET['startDate']; ?>">
                  <span>&#8764;</span>
                  <input class="date" name="endDate" value="<?php echo $_GET['endDate']; ?>">
                  <select name="status" onchange="this.form.submit();">
                    <option value="all" 
                      <?php echo (isset($_GET['status']))?"":"selected"; ?>>所有狀態
                    </option>
                    <option value="toBeSent" 
                      <?php echo (isset($_GET['status']) && $_GET['status']=='toBeSent')?"selected":""; ?>>待寄送
                    </option>
                    <option value="delivering" 
                      <?php echo (isset($_GET['status']) && $_GET['status']=='delivering')?"selected":""; ?>>運送中
                    </option>
                    <option value="arrived" 
                      <?php echo (isset($_GET['status']) && $_GET['status']=='arrived')?"selected":""; ?>>已送達
                    </option>
                  </select>
                  <button type="submit"><img src="img/icon/search.png" alt="search"></button>
                </form>
              </div>
            </div>
            
            <?php
            
            if(isset($_SESSION['member_id'])){
              $sql = "SELECT `order`.`id`,`datetime`,`num`,`status`,`remark`,`sendDate`,`arriveDate`,
                             `needs`.`or_id`,`title`,`image`, 
                             `organizer`.`name`
                      FROM `order`
                      INNER JOIN `needs`
                      ON `order`.`need_id` = `needs`.`id`
                      INNER JOIN `organizer`
                      ON `needs`.`or_id` = `organizer`.`or_id`
                      WHERE `order`.`member_id` = ".$_SESSION['member_id']."
                      AND `order`.`datetime` BETWEEN '".$_GET['startDate']."' AND '".$_GET['endDate']." 23:59:59"."'";
              if(isset($_GET['status']) && $_GET['status'] != 'all'){
                $sql .= "AND `order`.`status` = '".$status."' ORDER BY `datetime` DESC";
              }else if(isset($_GET['status']) && $_GET['status'] == 'all' || !isset($_GET['status'])){
                $sql .= " ORDER BY `datetime` DESC";
              }
              $fromTo = "社福單位";
            }else if(isset($_SESSION['or_id'])){
              $sql = "SELECT `order`.`id`,`datetime`,`num`,`status`,`remark`,`sendDate`,`arriveDate`,
                             `member`.`name`,  
                             `needs`.`title`,`image`
                      FROM `order`
                      INNER JOIN `member`
                      ON `order`.`member_id` = `member`.`id`
                      INNER JOIN `needs`
                      ON `order`.`need_id` = `needs`.`id`
                      WHERE `needs`.`or_id` = ".$_SESSION['or_id']."
                      AND `order`.`datetime` BETWEEN '".$_GET['startDate']."' AND '".$_GET['endDate']." 23:59:59"."'";
              if(isset($_GET['status']) && $_GET['status'] != 'all'){
                $sql .= "AND `order`.`status` = '".$status."' ORDER BY `datetime` DESC";
              }else if(isset($_GET['status']) && $_GET['status'] == 'all' || !isset($_GET['status'])){
                $sql .= " ORDER BY `datetime` DESC";
              }
              $fromTo = "贈物者";
            }else{
                echo '<script>
                        window.alert("錯誤的參數！\n請先確認登入");
                        history.back();
                      </script>';
            }

            $result = $conn->query($sql);
            $backTo = (isset($_SESSION['member_id']))?"myAccount.php":"orAccount.php";

            echo '
            <p>共<span>'.$result->num_rows.'</span>筆</p>
          </div>
          <div class="back">
            <a href="'.$backTo.'">
              <span>&#65513;</span>回上頁
            </a>
          </div>
          <div class="order-list">';

            while($row = $result->fetch_assoc()){
              $sendHide = (isset($_SESSION['or_id']) || $row['status'] != "待寄送")?'style="display:none"':'';
              $arrivedHide = (isset($_SESSION['member_id']) || $row['status'] == "已送達" || $row['status'] == "已取消")?'style="display:none"':'';
              $image = ($row['image']==NULL)?"img/default_image.jpg":$row['image'];
              $orLink = (isset($_SESSION['member_id']))?'<a href="organizer.php?id='.$row['or_id'].'">':'';
              
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
                          <button class="arrived" onclick="updateStatus(this, '.$row['id'].', \'arrived\')" '.$arrivedHide.'>登記已送達</button>
                          <div class="btn" '.$sendHide.'>
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
                          <li>'.$fromTo.'</li>
                          <li>寄送日期</li>
                          <li>送達日期</li>
                          <li>備註說明</li>
                        </ul>
                        <div class="devider"></div>
                        <ul>
                          <li>'.$row['id'].'</li>
                          <li>'.$row['datetime'].'</li>
                          <li>'.$orLink.$row['name'].'</a></li>
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
      </section>
    </div>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="plugin/datetimePicker/moment.min.js"></script>
  <script src="plugin/datetimePicker/bootstrap-material-datetimepicker.js"></script>
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
    
    $(function() {
      $('.date').bootstrapMaterialDatePicker({ weekStart: 0, time: false, maxDate: new Date() });
    });
    
    $('tbody .col-1, tbody .col-2').click(function(e){
      e.preventDefault();
      $(this).parent().parent().find(".order-detail").slideToggle("slow");
    });
    
    function updateStatus(elem, orderId, newStatus){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
          if(xhttp.responseText == "updated"){
            if(newStatus == 'arrived'){
              elem.previousElementSibling.innerHTML = "已送達";
              elem.style.display = "none";
            }else if(newStatus == "delivering"){
              elem.parentNode.previousElementSibling.previousElementSibling.innerHTML = "運送中";
              elem.parentNode.style.display = "none";
            }else if(newStatus == 'cancel'){
              elem.parentNode.previousElementSibling.previousElementSibling.innerHTML = "已取消";
              elem.parentNode.style.display = "none";
            }
          }else{
            console.log(xhttp.responseText);
          }
        }
      };
      xhttp.open("GET","updateStatus.php?id="+orderId+"&st="+newStatus,true);
      xhttp.send();
    }
  </script>
</body>
</html>