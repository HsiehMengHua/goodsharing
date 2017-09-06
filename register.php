<?php

session_start();
include("connectDB.php");

$err = "";
$email = (isset($_POST["email"]))?input($_POST["email"]):"";
$password = (isset($_POST["password"]))?md5(input($_POST["password"])):"";
$userName = (isset($_POST["userName"]))?input($_POST["userName"]):"";
$phone = (isset($_POST["phone"]))?input($_POST["phone"]):"";
date_default_timezone_set("Asia/Taipei");
$datetime = date("Y-m-d H:i:s");
$act_code = md5($email.$password.$datetime);

if(empty($email) || empty($password) || empty($userName) || empty($phone)){
  $err = (empty($email) && empty($password) && empty($userName) && empty($phone))?"":"輸入資料不完整";
}else{
  $sql = "SELECT * FROM `member` WHERE `email` = '$email'";
  $result = $conn->query($sql);

  if($result->num_rows){
    $err = "Email已被註冊過";
  }else{
    $sql_insert = "INSERT INTO `member` (`email`, `password`, `name`, `phone`, `register_datetime`) 
                   VALUES ('$email', '$password', '$userName', '$phone', '$datetime')";
    
    if($conn->query($sql_insert)){

      //id寫入SESSION
      $sql_retrieveId = "SELECT `id` FROM `member` WHERE `email` = '$email'";
      $row = $conn->query($sql_retrieveId)->fetch_assoc();
      $id = $row["id"];
      $_SESSION["member_id"] = $id;
      
      echo '<script>
              window.alert("已註冊成為會員!");
              window.location.href="index.php";
            </script>';

      /*
      $header = "Content-type:text/html;charset=UTF-8";
      $header .= "\nFrom: mailnotice3@gmail.com";
      $host  = $_SERVER['HTTP_HOST'];
      $uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = "activate.php?code=$act_code";
      $act_link = "http://$host$uri/$extra";
      $text = '
      <p>你已註冊成為會員，請點擊以下連結驗證你的電子信箱：</p>
      <a href="'.$act_link.'">'.$act_link.'</a>';

      if(mail($email,"會員帳號啟用信",$text,$header)){
        header("Location: act_sent.php");
      }else{
        echo "Somthing wrong. Email was not sent.";
      }*/
    }else{
      $err = "Error: ".$conn->error;
    }
  }
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Document</title>
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/formPage.css">
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
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <ul>
          <li>
            <label>Email<span id="emailErr" style="color:#e53a3a"></span>
              <input type="email" name="email" id="email" value="<?php echo $email; ?>" onkeyup="checkEmail(this.value)">
            </label>
          </li>
          <li>
            <label>密碼
              <input type="password" name="password" id="password">
            </label>
          </li>
          <li>
            <label>確認密碼<span id="passErr" style="color:#e53a3a"></span>
              <input type="password" id="confirmPassword">
            </label>
          </li>
          <li>
            <label>姓名
              <input type="text" name="userName" value="<?php echo $userName; ?>">
            </label>
          </li>
          <li>
            <label>聯絡電話
              <input type="text" name="phone" value="<?php echo $phone; ?>">
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
    
    $(function() {
      $('form input').on("focus",function(){
        $(this).parent().css("color","#55bbb5");
        $(this).css("borderBottomColor","#55bbb5");
      });
      $('form input').on("blur",function(){
        $(this).parent().css("color","#313b4f");
        $(this).css("borderBottomColor","#313b4f");
      });

      $('#confirmPassword').keyup(function(){
        if($(this).val() == $('#password').val()){
          $(this).css("borderBottomColor","#75da7a");
          $(this).parent().css("color","#75da7a");
          $("#passErr").html("");
          $("button.submit").attr("disabled",false);
        }else{
          $(this).css("borderBottomColor","#e53a3a");
          $(this).parent().css("color","#e53a3a");
          $("#passErr").html("&nbsp;輸入密碼不一致");
          $("button.submit").attr("disabled",true);
        }
      });
    });
  </script>
  <script>
    function checkEmail(str){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {
          console.log(xhttp.responseText);

          if(xhttp.responseText == "false"){
            $("#email").css("borderBottomColor","#75da7a");
            $("#email").parent().css("color","#75da7a");
            $("#emailErr").html("");
          }else if(xhttp.responseText == "true"){
            $("#email").css("borderBottomColor","#e53a3a");
            $("#email").parent().css("color","#e53a3a");
            $("#emailErr").html("&nbsp;你已註冊過");
          }else{
            console.log(xhttp.responseText);
          }
        }
      };
      xhttp.open("GET","checkEmail.php?email="+str,true);
      xhttp.send();
    }
  </script>
</body>
</html>