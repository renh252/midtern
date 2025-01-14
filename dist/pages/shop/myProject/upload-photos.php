<?php
$fieldName = 'photo'; // photos[]


$dir = __DIR__ . ' /uploads/'; # 存放檔案的資料夾
$exts = [   # 檔案類型的篩選
  'image/jpeg' => '.jpg',
  'image/png' => '.png',
  'image/webp' => '.webp',
];

# 輸出的格式
$output = [
  'success' => false,
  'files' => []
];

// if (!empty($_FILES) and !empty($_FILES[$fieldName])) {

//   if (is_array($_FILES[$fieldName]['name'])) {    # 是不是陣列
//     foreach ($_FILES[$fieldName]['name'] as $i => $name) {
//       if (!empty($exts[$_FILES[$fieldName]['type'][$i]]) and $_FILES[$fieldName]['error'][$i] == 0) {
//         $ext = $exts[$_FILES[$fieldName]['type'][$i]]; # 副檔名
//         $f = sha1($name . uniqid() . rand()); # 隨機的主檔名
//         if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$i], $dir . $f . $ext)) {
//           $output['files'][] = $f . $ext;  // array push
//         }
//       }
//     }
//     if (count($output['files'])) {
//       $output['success'] = true;
//     }
//   }
// }

// gpt
if (!empty($_FILES) && !empty($_FILES[$fieldName])) {
  error_log(print_r($_FILES, true)); // 輸出詳細檔案資訊到日誌
  if (is_array($_FILES[$fieldName]['name'])) {
      foreach ($_FILES[$fieldName]['name'] as $i => $name) {
          $type = $_FILES[$fieldName]['type'][$i];
          $error = $_FILES[$fieldName]['error'][$i];
          if (!empty($exts[$type]) && $error == 0) {
              $ext = $exts[$type];
              $f = sha1($name . uniqid() . rand());
              if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$i], $dir . $f . $ext)) {
                  $output['files'][] = $f . $ext;
              } else {
                  $output['error'] = "無法移動檔案：{$name}";
              }
          } else {
              $output['error'] = "檔案類型或錯誤碼無效：{$type}, 錯誤碼：{$error}";
          }
      }
      if (count($output['files'])) {
          $output['success'] = true;
      }
  }
} else {
    error_log("未收到檔案，或欄位名稱與 '$fieldName' 不符。");
    $output['error'] = "未收到檔案或欄位名稱錯誤。";
}


header('Content-Type: application/json');
echo json_encode($output);

// 查看檔案的 type 和 error
error_log(print_r($_FILES, true));
