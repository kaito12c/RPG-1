<?php
session_start();
include("../functions.php");
check_session_id();


if(
  !isset($_SESSION['username']) || $_SESSION['username']=='' ||
  !isset($_POST['mission_goal']) || $_POST['mission_goal']=='' ||
  !isset($_POST['mission']) || $_POST['mission']=='' ||
  !isset($_POST['deadline']) || $_POST['deadline']==''
){
  exit('入力データがありません。');
}


$name = $_SESSION['username'];
$mission_goal = $_POST['mission_goal'];
$mission = $_POST['mission'];
$deadline = $_POST['deadline'];


if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0)
 {
// 一時保管しているtmpフォルダの場所の取得.
// アップロード先のパスの設定(サンプルではuploadフォルダ <- 作成!)
$uploaded_file_name = $_FILES['upfile']['name']; 

// アップロードしたファイル名を取得.
$temp_path = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所 
$directory_path = 'upload/'; //アップロード先ォルダ

 // ファイルの拡張子の種類を取得.
$extension = pathinfo($uploaded_file_name, PATHINFO_EXTENSION); 

// ファイルごとにユニークな名前を作成.(最後に拡張子を追加) 
$unique_name = date('YmdHis').md5(session_id()) . "." . $extension; 

// ファイルの保存場所をファイル名に追加.
$filename_to_save = $directory_path . $unique_name;
// 最終的に「upload/hogehoge.png」のような形になる

// var_dump($filename_to_save);
// exit();

//一時保存場所にファイルがあるかどうかチェック
if (is_uploaded_file($temp_path)) {
  // ↓ここでtmpファイルを移動する、ファイルの保存がうまくいったかどうかチェック
  if (move_uploaded_file($temp_path, $filename_to_save)) {
  chmod($filename_to_save, 0644); // 権限の変更
  } else {
    //upload先（保存先フォルダ）の権限を「読み/書き」に変更しないとひっかかる。
    exit('Error:アップロードできませんでした'); // 画像の保存に失敗 
  }
  } else {
    exit('Error:画像がありません'); // tmpフォルダにデータがない 
  }
  } else {
  // 送られていない，エラーが発生，などの場合
  exit('Error:画像が送信されていません'); 
}



 // DB接続
$pdo = connect_to_db();         

$sql = 'INSERT INTO mission_table(id, name, image, mission, mission_goal, deadline, created_at, updated_at) VALUES(NULL, :name, :image, :mission, :mission_goal, :deadline, sysdate(), sysdate())';

// var_dump($_FILES);
// exit();

$stmt = $pdo->prepare($sql);
// バインド変数に格納（セキュリティ）
$stmt->bindValue(':name', $name, PDO::PARAM_STR); //数値だった場合、INT(INTEGER:整数)
$stmt->bindValue(':image', $filename_to_save, PDO::PARAM_STR); 
$stmt->bindValue(':mission', $mission, PDO::PARAM_STR);
$stmt->bindValue(':mission_goal', $mission_goal, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR); 
$status = $stmt->execute(); // SQLを実行

// var_dump($_FILES);
// exit();

if ($status==false) {
  $error = $stmt->errorInfo(); // データ登録失敗次にエラーを表示 exit('sqlError:'.$error[2]);
  } else {
  // 登録ページへ移動
    header('Location:mission_read.php');
  }
