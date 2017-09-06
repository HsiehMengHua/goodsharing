<?php

session_start();
include("connectDB.php");
$or_id = $_SESSION['or_id'];


// 上傳到哪個路徑
if (!file_exists("file_uploaded/$or_id/"))
  mkdir("file_uploaded/$or_id/");
$target_dir = "file_uploaded/$or_id/";

for($i=0; $i<sizeof($_FILES["imageUpload"]["name"]); $i++){
    $target_file = $target_dir.basename($_FILES["imageUpload"]["name"][$i]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // 檢查是不是圖片檔
    if(isset($_POST["submit"])){
        $check = getimagesize($_FILES["imageUpload"]["tmp_name"][$i]);
        if($check !== false){
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }else{
            echo "File is not an image.";
            $uploadOk = 0;
            $errMsg = basename( $_FILES["imageUpload"]["name"][$i]).' - 上傳失敗: 檔案不是圖片檔\n';
        }
    }
    // 檢查檔名(路徑)是否重複
    if(file_exists($target_file)){
        echo "Sorry, file already exists.";
        $uploadOk = 0;
        $errMsg = basename( $_FILES["imageUpload"]["name"][$i]).' - 上傳失敗: 此檔名已存在\n';
    }

    // 過濾圖片size
    if($_FILES["imageUpload"]["size"][$i] > 500000){
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
        $errMsg = basename( $_FILES["imageUpload"]["name"][$i]).' - 上傳失敗: 檔案過大\n';
    }
    // 只接受這幾種副檔名
    if(strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpeg"
    && strtolower($imageFileType) != "gif" ){
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        $errMsg = basename( $_FILES["imageUpload"]["name"][$i]).' - 上傳失敗: 請上傳 JPG, JPEG, PNG & GIF 檔案\n';
    }
    
  
    if($uploadOk == 0){
        echo "Sorry, your file was not uploaded.";
        echo '<script>
                window.alert("'.$errMsg.'");
                window.location.href="album.php";
              </script>';
    }else{
        // 關關難過關關過，終於可以上傳了
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"][$i], iconv("UTF-8", "big5", $target_file))){
            echo "The file ". basename( $_FILES["imageUpload"]["name"][$i]). " has been uploaded.<br>";
          
            // 紀錄url到DB
            $basename = basename( $_FILES["imageUpload"]["name"][$i]);
            $url = "file_uploaded/$or_id/".$basename;
            $sql_store = "INSERT INTO `album` (`or_id`, `url`, `basename`) VALUES ('$or_id', '$url', '$basename')";
            if($conn->query($sql_store)){
                echo "inserted";
                echo '<script>
                        window.alert("圖片已上傳");
                        window.location.href="album.php";
                      </script>';
            }else{
                echo "Error: ".$conn->error;
            }

        }else{
            echo "Sorry, there was an error uploading your file.";
            $errMsg = basename( $_FILES["imageUpload"]["name"][$i]).' - 上傳失敗\n';
        }
    }
}

?>