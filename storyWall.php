<?php

session_start();
include("connectDB.php");
$or_id = $_GET['orId'];

?>

<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>故事牆</title>
  <link rel="stylesheet" href="plugin/gotoTop/gotoTop.css">
  <link rel="stylesheet" href="css/hamburgerMenu.css">
  <link rel="stylesheet" href="css/style.css">

  <!-- Global CSS for the page and tiles -->
  <link rel="stylesheet" href="plugin/wookmark/main.css">

  <style>
    /**
     * Grid items
     */
    #tiles li {
      -webkit-transition: all 0.3s ease-out;
         -moz-transition: all 0.3s ease-out;
           -o-transition: all 0.3s ease-out;
              transition: all 0.3s ease-out;
    }

    /**
     * Sort buttons
     */
    #sortbys {
      list-style-type: none;
      text-align: center;
      margin: 0 5% 0 5%;
    }

    #sortbys li {
      font-size: 12px;
      float: left;
      padding: 6px 0 4px 0;
      cursor: pointer;
      margin: 0 1% 0 1%;
      width: 8%;
      -webkit-transition: all 0.15s ease-out;
         -moz-transition: all 0.15s ease-out;
           -o-transition: all 0.15s ease-out;
              transition: all 0.15s ease-out;
      -webkit-border-radius: 3px;
         -moz-border-radius: 3px;
              border-radius: 3px;
    }

    #sortbys li:hover {
      background: #dedede;
    }

    #sortbys li.active {
      background: #333333;
      color: #ffffff;
    }
  </style>
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
  
  <div>
    <div class="storyWall">
      <section>
        <div class="container">
          <div class="heading">
            <?php
            
            $sql = "SELECT `name` FROM `organizer` WHERE `or_id` = '$or_id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            
            ?>
            <h2><a href="organizer.php?id=<?php echo $or_id; ?>"><?php echo $row['name']; ?></a>&nbsp;&nbsp;的故事牆</h2>
            <a href="addPhoto.php" style="display:none">&#43;&nbsp;新增照片</a>
            <div class="line"></div>
          </div>
          
          <!-- Start tiles -->
          <div id="container_1">
            <ol id="sortbys" style="display:none">
              <li data-sortby="datetime" class="active">依時間</li>
              <li data-sortby="price">依花費</li>
              <li data-sortby="popularity">依熱門</li>
            </ol>

            <div id="main" role="main">
              <ul id="tiles">
                <?php
                
                $sql = "SELECT `id`, `title`, `release_datetime`, `content`
                        FROM `story` WHERE `or_id` = ".$_GET['orId']." 
                        ORDER BY `release_datetime` DESC";
                
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                  // 找出內文中的第一個圖片
                  preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $row['content'], $matches);
                  $first_image = (isset($matches[1]))?$matches[1]:"img/transparent.png";
                  $content = mb_substr($row['content'],0,47,'utf8')."...";
                  echo '
                  <li>
                    <div>
                      <a href="story_article.php?id='.$row['id'].'">
                        <img src="'.$first_image.'" width="200">
                      </a>
                    </div>
                    <div class="content">
                      <h4><a href="story_article.php?id='.$row['id'].'">'.$row['title'].'</a></h4>
                      <span class="datetime">'.$row['release_datetime'].'</span>
                      <p>'.$content.'</p>
                    </div>
                  </li>';
                }
                
                ?>
              </ul>
            </div>
          </div><!-- End tiles -->
  
        </div><!-- End container -->
      </section>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="plugin/wookmark/jquery.imagesloaded.js"></script>
  <script src="plugin/wookmark/jquery.wookmark.js"></script>
  <script type="text/javascript">
    (function ($){
      $('#tiles').imagesLoaded(function() {
        function comparatorDatetime(a, b) {
          return $(a).data('datetime') < $(b).data('datetime') ? -1 : 1;
        }
        function comparatorPopularity(a, b) {
          return $(a).data('popularity') > $(b).data('popularity') ? -1 : 1;
        }
        function comparatorPrice(a, b) {
          return $(a).data('price') < $(b).data('price') ? -1 : 1;
        }

        // Prepare layout options.
        var options = {
          autoResize: true, // This will auto-update the layout when the browser window is resized.
          container: $('#main'), // Optional, used for some extra CSS styling
          offset: 2, // Optional, the distance between grid items
          itemWidth: 210, // Optional, the width of a grid item
          comparator: comparatorDatetime
        };

        // Get a reference to your grid items.
        var $handler = $('#tiles li'),
            $sortbys = $('#sortbys li');

        // Call the layout function.
        $handler.wookmark(options);

        /**
         * When a filter is clicked, toggle it's active state and refresh.
         */
        var onClickSortBy = function(e) {
          e.preventDefault();
          $currentSortby = $(this);
          switch ($currentSortby.data('sortby')) {
            case 'price':
              options.comparator = comparatorPrice;
              break;
            case 'popularity':
              options.comparator = comparatorPopularity;
              break;
            case 'datetime':
            default:
              options.comparator = comparatorDatetime;
              break;
          }

          $sortbys.removeClass('active');
          $currentSortby.addClass('active');

          $handler.wookmark(options);
        }

        // Capture filter click events.
        $sortbys.click(onClickSortBy);
      });
    })(jQuery);
  </script>
  
    
</body>
</html>