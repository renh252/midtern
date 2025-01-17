<?php

$output=[
  'success'=>false,
  'file'=>'' //上傳之後的檔案名稱
];

// 測試上傳圖片
$dir= __DIR__.'/photos/'; #存放圖片的資料夾

// 篩選檔案類型，決定副檔名
$exts =[
  'image/jpeg' => '.jpg',
  'image/png'=> '.png',
  'image/webp'=> '.webp'
];

// 檢查是否有上傳檔案
if(!empty($_FILES)
   and
   !empty($_FILES['img'])
   and
   !empty($_FILES['img']['error'] == 0)
){
  // 檢查副檔名(MIME Type檔案類型)
  if(!empty($exts[$_FILES['img']['type']])){
    // 取得副檔名
    $exts = $exts[$_FILES['img']['type']];
    // 建立隨機檔案名稱
    $file_name = md5($_FILES['img']['name'].uniqid());
    // 將檔案移動到指定資料夾
    if(move_uploaded_file(
      // 暫存檔案的路徑
      $_FILES['img']['tmp_name'],
      $dir.$file_name.$exts
      )) {
        $output['success']=true; 
        $output['file']=$file_name.$exts
        ;
      }

  }
}

header('content-Type: application/json');
echo json_encode($output);