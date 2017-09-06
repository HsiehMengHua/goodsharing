<?php

session_start();
include("connectDB.php");

$err = "";
$email = (isset($_POST["email"]))?input($_POST["email"]):"";
$password = (isset($_POST["password"]))?md5(input($_POST["password"])):"";

$sql = "SELECT id,email,password FROM `member` WHERE `email` = '$email' AND `password` = '$password'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$id = $row["id"];

// 帳密match
// num_rows return the number of rows in result set
if($result->num_rows){
  $_SESSION["member_id"] = $id;
  echo '<script>
          window.location.href="index.php";
        </script>';
  /* Redirect to homepage
  $host  = $_SERVER['HTTP_HOST'];
  $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $extra = 'index.php';
  header("Location: http://$host$uri/$extra");
  exit();*/
}else{ // 登入失敗
  $err = (empty($email) && empty($password))?"":"Email或密碼輸入錯誤";
}

function input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

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
  <div class="form">
    <div class="container thin">
      <div class="toLogin"><a href="orLogin.php">機構登入<span>&#10140;</span></a></div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <ul>
          <li>
            <label>Email
              <input type="email" name="email" value="<?php echo (isset($_POST["email"]))?$_POST["email"]:""; ?>">
            </label>
          </li>
          <li>
            <label>密碼<a href="forgotPass.php"><span>忘記密碼?</span></a>
              <input type="password" name="password">
            </label>
          </li>
          <li class="clear">
            <button class="submit btn waves-effect waves-light orange accent-2" type="submit" name="action">送出</button>
            <button onclick="history.back();" class="cancel">取消</button>
            <span id="err"><?php echo $err."&nbsp;"; ?></span>
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
  </script>
</body>
</html>