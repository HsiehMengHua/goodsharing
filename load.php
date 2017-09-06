<?php

include("connectDB.php");

if(isset($_GET['cate'])){
  if($_GET['cate'] == 1)
    $cate = '家電機器';
  else if($_GET['cate'] == 2)
    $cate = '生活用品';
  else if($_GET['cate'] == 3)
    $cate = '嬰幼童用品';
  else if($_GET['cate'] == 4)
    $cate = '食物飲品';
  else if($_GET['cate'] == 5)
    $cate = '服飾配件';
  else if($_GET['cate'] == 6)
    $cate = '居家擺設';
  else if($_GET['cate'] == 7)
    $cate = '健康管理';
  else if($_GET['cate'] == 8)
    $cate = '運動休閒';
  else if($_GET['cate'] == 9)
    $cate = '毛小孩用品';
  else if($_GET['cate'] == 10)
    $cate = '交通工具';
}

if(isset($_GET['keyword'])){
  $keyword = '%'.$_GET['keyword'].'%';
  if(isset($_GET['cate'])){
    // 有給分類和關鍵字
    $sql = "SELECT * FROM `needs` WHERE `title` LIKE '$keyword' AND `category` = '$cate' AND `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16 OFFSET ".$_GET['pg']*16;
  }else{
    // 有關鍵字，但沒分類
    $sql = "SELECT * FROM `needs` WHERE `title` LIKE '$keyword' AND `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16 OFFSET ".$_GET['pg']*16;
  }
}else{
  if(isset($_GET['cate'])){
    // 沒關鍵字，指定分類
    $sql = "SELECT * FROM `needs` WHERE `category` = '$cate' AND `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16 OFFSET ".$_GET['pg']*16;
  }else{
    // 沒關鍵字，也沒分類
    $sql = "SELECT * FROM `needs` WHERE `current_number` <= `number_of_needs` ORDER BY `id` DESC LIMIT 16 OFFSET ".$_GET['pg']*16;
  }
}

$result = $conn->query($sql);

if($result->num_rows){
  while($row = $result->fetch_assoc()){
    $sql_or = "SELECT * FROM `organizer` WHERE `or_id` = ".$row['or_id'];
    $result_or = $conn->query($sql_or);
    $row_or = $result_or->fetch_assoc();
    $image = ($row['image'] == NULL)?'img/default_image.jpg':$row['image'];            
    $currentNeed = $row['number_of_needs'] - $row['current_number'];
    $percentage = ($row['current_number'] / $row['number_of_needs'])*100;
    
    echo '
    <div class="wrapper">
      <div class="grid-item md-trigger" data-modal="modal-'.$detailId = $row['id'].'">
        <div class="image-wrapper">
          <img src="'.$image.'" alt="">
          <div class="devider"></div>
        </div>
        <div class="content">
          <p class="title">'.$row['title'].'</p>
          <p class="organizer">'.$row_or['name'].'</p>
          <span>還需&nbsp;'.$currentNeed.'&nbsp;份</span>
          <div class="w3-progress-container">
            <div class="w3-progressbar w3-round-large" style="width:'.$percentage.'%"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="md-container md-effect-3" id="modal-'.$row['id'].'">
      <div class="md-content">
        <div class="container clear">
          <div class="image">
            <img src="'.$image.'" alt="">
          </div>
          <div class="content">
            <p class="title">'.$row['title'].'</p>
            <p class="organizer"><a href="organizer.php?id='.$row['or_id'].'">'.$row_or['name'].'</a></p>
            <div>
              <span>還需&nbsp;'.$currentNeed.'&nbsp;份</span>
              <div class="w3-progress-container">
                <div class="w3-progressbar w3-round-large" style="width:'.$percentage.'%">
                </div>
              </div>
            </div>
            <p class="usage">'.$row['usage'].'</p>
          </div>
        </div>
        <div class="devider"></div>
        <div class="btn clear">
          <button class="md-close">
            <div class="icon close-icon">
              <img src="img/icon/circle-close.png" alt="">
            </div>
            <span>返回</span>
          </button>
          <div class="devider"></div>
          <button onclick="window.location.href=\'donate.php?id='.$row['id'].'\'">
            <div class="icon swing">
              <img src="img/icon/gift.png" alt="">
            </div>
            <span>我要捐贈此物</span>
          </button>
        </div>
      </div>
    </div>';
  }
}else{
  echo "end";
}

?>