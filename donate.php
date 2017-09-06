<?php

session_start();
include("connectDB.php");

if(!isset($_SESSION['member_id'])){
  echo '<script>
          window.alert("登入先唷");
          window.location.href="login.php";
        </script>';
}

$sql = "SELECT `title`,`number_of_needs`,`current_number`,`image`,`name` 
        FROM `needs` 
        JOIN `organizer`
        ON `needs`.`or_id` = `organizer`.`or_id`
        WHERE `needs`.`id` = ".$_GET['id'];
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];
$currentNeed = $row['number_of_needs'] - $row['current_number'];
$percentage = ($row['current_number'] / $row['number_of_needs'])*100;

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/css/materialize.min.css">-->
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/numberSpinner.css">
  <link rel="stylesheet" href="css/progressbar.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/formPage.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    .title { font-size: 1.3em; }
    .organizer { color: gray; }
    .content span { color: #51a75a; margin: 0; }
  </style>
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
  <div class="form">
    <div class="container">
      <form action="orderEst.php?needId=<?php echo $_GET['id']; ?>" method="post" class="clear">
        <div class="image">
          <img src="<?php echo $image; ?>" alt="">
        </div>
        <ul class="content">
          <li class="title"><?php echo $row['title']; ?></li>
          <li class="organizer"><?php echo $row['name']; ?></li>
          <li>
            <span>還需&nbsp;<?php echo $currentNeed; ?>&nbsp;份</span>
            <div class="w3-progress-container">
              <div class="w3-progressbar w3-round-large" style="width:<?php echo $percentage; ?>%"></div>
            </div>
          </li>
          <li>
            <label>可提供數量
              <span class="spinner">
                <a class="sub btn-floating waves-effect waves-light blue-grey darken-1">&#45;</a>
                <!--<span class="sub">&#45;</span>-->
                <input type="number" name="number" min="1" value="1">
                <a class="add btn-floating waves-effect waves-light blue-grey darken-1">&#43;</a>
                <!--<span class="add">&#43;</span>-->
              </span>
               
            </label>
          </li>
          <li>備註說明<br>
            <textarea name="usage" cols="30" rows="1" onkeyup="auto_grow(this)"></textarea>
          </li>
          <li class="clear">
            <button class="btn waves-effect waves-light orange accent-2" type="submit" name="action">送出</button>
            <!--<button type="submit" class="submit">送出</button>-->
            <button onclick="history.back();" class="cancel">取消</button>
          </li>
        </ul>
      </form>
    </div>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
  <script src="plugin/gotoTop/gotoTop.js"></script>
  <script src="js/numberSpinner.js"></script>
  <script src="js/formPage.js"></script>
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
    
    function auto_grow(element) {
      element.style.height = "5px";
      element.style.height = (element.scrollHeight)+"px";
    }
  </script>
</body>
</html>