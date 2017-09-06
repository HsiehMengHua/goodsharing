<?php

session_start();
include("connectDB.php");

$err = "";
$account = (isset($_POST['account']))?$_POST['account']:"";
$password = (isset($_POST['password']))?$_POST['password']:"";

if(!empty($account) && !empty($password)){
  $sql = "SELECT * FROM `or_account` WHERE `account` = '$account'";
  if($conn->query($sql)->num_rows){
    $err = "此帳號已被註冊過";
  }else{
    $sql = "INSERT INTO `or_account` (`account`, `password`) VALUES ('$account', '$password')";
    if($result = $conn->query($sql)){
      $sql = "SELECT * FROM `or_account` ORDER BY `id` DESC LIMIT 1";
      $row = $conn->query($sql)->fetch_assoc();
      $sql = "INSERT INTO `organizer` (`or_id`) VALUES (".$row['id'].")";
      if($result = $conn->query($sql)){
        echo '<script>
                window.alert("新增成功");
                window.location.href="index.php";
              </script>';
      }
    }
  }
}else{
  $err = "輸入資料不完整";
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
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
        <ul>
          <li>
            <label>帳號
              <input name="account" value="<?php echo (isset($_POST['account']))?$_POST['account']:""; ?>">
            </label>
          </li>
          <li>
            <label>密碼<button type="button" id="passGenerator" onclick="document.getElementById('password').value = Password.generate(8)">產生密碼</button>
              <input id="password" type="password" name="password" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();">
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
  <script src="js/randomStringGenerator.js"></script>
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
    
    
    /* View the password on hover */
    
    function mouseoverPass(obj) {
      var obj = document.getElementById('password');
      obj.type = "text";
    }
    function mouseoutPass(obj) {
      var obj = document.getElementById('password');
      obj.type = "password";
    }    
  </script>
</body>
</html>