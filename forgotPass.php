<?php

session_start();
include("connectDB.php");

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
  <style>
    .new-pass {display:none; margin-top: 30px;}
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
    <div class="container thin">
      <form action="pass_update.php" method="post">
          <div>
            <ul class="by clear">
              <li class="active member">一般會員</li>
              <li class="organization">社福機構</li>
            </ul>
          </div>
          <div>
            <label class="byEmail">輸入email<span class="err" style="color:#e53a3a"></span>
              <input id="email" type="email" name="email" onkeyup="checkEmail(this.value)">
            </label>
            <label class="byAccount">輸入帳號<span class="err" style="color:#e53a3a"></span>
              <input id="account" name="account" onkeyup="checkAccount(this.value)">
            </label>
          </div>
          <div class="new-pass">
            <ul>
              <li>
                <label>新密碼
                  <input type="password" name="password" id="password">
                </label>
              </li>
              <li>
                <label>確認密碼<span id="passErr" style="color:#e53a3a"></span>
                  <input type="password" id="confirmPassword">
                </label>
              </li>
              <li class="clear">
                <button class="submit btn waves-effect waves-light orange accent-2" type="submit" name="action" disabled>下一步</button>
                <button onclick="history.back();" class="cancel">取消</button>
              </li>
            </ul>
          </div>
      </form>
    </div>
  </div>
  
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.7/js/materialize.min.js"></script>
  <script src="js/numberSpinner.js"></script>
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
    
    $('form .by li').on("click",function(){
      $('form .by li').removeClass("active");
      $(this).addClass("active");
      if($('form .by li.member').hasClass("active")){
        $('.byEmail').show();
        $('.byEmail input').attr("disabled",false);
        $('.byAccount').hide();
        $('.byAccount input').attr("disabled",true);
      }else{
        $('.byEmail').hide();
        $('.byEmail input').attr("disabled",true);
        $('.byAccount').show();
        $('.byAccount input').attr("disabled",false);
      }
    });
    
    
    console.log($('form .by li.organization').hasClass("active"));
    
    function checkEmail(str){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {

          if(xhttp.responseText == "true"){
            $("#email").css("borderBottomColor","#75da7a");
            $("#email").parent().css("color","#75da7a");
            $("#email").prev().html("");
            $('.new-pass').css("display","block");
          }else if(xhttp.responseText == "false"){
            $("#email").css("borderBottomColor","#e53a3a");
            $("#email").parent().css("color","#e53a3a");
            $("#email").prev().html("&nbsp;此email未被註冊過");
            $('.new-pass').css("display","none");
          }else{
            console.log(xhttp.responseText);
          }
        }
      };
      xhttp.open("GET","checkEmail.php?email="+str,true);
      xhttp.send();
    }
    
    function checkAccount(str){
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if(xhttp.readyState == 4 && xhttp.status == 200) {

          if(xhttp.responseText == "true"){
            $("#account").css("borderBottomColor","#75da7a");
            $("#account").parent().css("color","#75da7a");
            $("#account").prev().html("");
            $('.new-pass').css("display","block");
          }else if(xhttp.responseText == "false"){
            $("#email").css("borderBottomColor","#e53a3a");
            $("#email").parent().css("color","#e53a3a");
            $("#account").prev().html("&nbsp;此帳號未被註冊過");
            $('.new-pass').css("display","none");
          }else{
            console.log(xhttp.responseText);
          }
        }
      };
      xhttp.open("GET","checkAccount.php?acc="+str,true);
      xhttp.send();
    }
  </script>
  <script>
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
  </script>
</body>
</html>